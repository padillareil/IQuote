<?php
require_once "../../../../config/local_db.php";

$CurrentPage = $_POST['CurrentPage'];
$PageSize    = $_POST['PageSize'];
$Search      = $_POST['Search'];
$BnkType     = $_POST['BnkType'];

function reil_decrypt(string $encryptedData): string {
    $key = hash('sha256', 'Greek2001', true);
    $data = base64_decode($encryptedData);
    if ($data === false || strlen($data) < 17) return '';

    $iv = substr($data, 0, 16);
    $cipher = substr($data, 16);
    $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $plain === false ? '' : $plain;
}

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("EXEC dbo.[IAP_BRANCH_BANK] ?,?,?,?");
    $stmt->execute([$Search, $BnkType, $CurrentPage, $PageSize]);

    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    while ($stmt->nextRowset()) {}

    // Decrypt only AccName and AccNumber
    foreach ($branches as &$row) {
        if (!empty($row['AccName'])) {
            $row['AccName'] = reil_decrypt($row['AccName']);
        }
        if (!empty($row['AccNumber'])) {
            $row['AccNumber'] = reil_decrypt($row['AccNumber']);
        }
    }
    unset($row);

    $conn->commit();

    $response = [
        "isSuccess" => "success",
        "Data" => $branches
    ];
    echo json_encode($response);

} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollback();
    }
    echo json_encode([
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    ]);
}
?>
