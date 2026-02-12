<?php
require_once "../../../../config/local_db.php";

function reil_decrypt(string $encryptedData): string {
    $key = hash('sha256', 'Greek2001', true);
    $data = base64_decode($encryptedData);
    if ($data === false || strlen($data) < 17) return '';

    $iv = substr($data, 0, 16);
    $cipher = substr($data, 16);
    $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

    return $plain === false ? '' : $plain;
}

$CurrentPage = $_POST['CurrentPage'] ?? 1;
$PageSize    = $_POST['PageSize'] ?? 100;
$Search      = $_POST['Search'] ?? '';

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("EXEC dbo.[IAP_COPORATE_BANK] ?,?,?");
    $stmt->execute([$Search, $CurrentPage, $PageSize]);
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

    echo json_encode([
        "isSuccess" => "success",
        "Data"      => $branches
    ]);

} catch (PDOException $e) {
    if ($conn->inTransaction()) $conn->rollback();
    echo json_encode([
        "isSuccess" => "Failed",
        "Data"      => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    ]);
}
?>
