<?php
require_once "../../../../config/local_db.php";
$Branch = $_POST['Branch'] ?? '';

if (empty($Branch)) {
    echo json_encode([
        "isSuccess" => "Failed",
        "Data"      => "Invalid branch parameter."
    ]);
    exit;
}

function reil_decrypt(?string $encryptedData): string
{
    if (!$encryptedData) return '';

    $key  = hash('sha256', 'Greek2001', true);
    $data = base64_decode($encryptedData);

    if ($data === false || strlen($data) < 17) return '';

    $iv     = substr($data, 0, 16);
    $cipher = substr($data, 16);

    $plain = openssl_decrypt(
        $cipher,
        'AES-256-CBC',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );

    return $plain === false ? '' : $plain;
}

$response = [];

try {

    $conn->beginTransaction();

    $stmt = $conn->prepare("
        EXEC GET_PERSONALBANKACCOUNT @mBranch_ = ?
    ");
    $stmt->execute([$Branch]);

    $get_branchbank = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($get_branchbank as &$row) {
        if (!empty($row['AccountName'])) {
            $row['AccountName'] = reil_decrypt($row['AccountName']);
        }

        if (!empty($row['AccountNumber'])) {
            $row['AccountNumber'] = reil_decrypt($row['AccountNumber']);
        }
    }

    $conn->commit();

    $response = [
        "isSuccess" => "success",
        "Data"      => $get_branchbank
    ];

} catch (PDOException $e) {

    if ($conn->inTransaction()) {
        $conn->rollback();
    }

    $response = [
        "isSuccess" => "Failed",
        "Data"      => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    ];
}

echo json_encode($response);
?>