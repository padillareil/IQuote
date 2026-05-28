<?php
require_once "../../../../config/local_db.php";

function reil_decrypt(?string $encryptedData): string {
    if (!$encryptedData) return '';

    $key  = hash('sha256', 'Greek2001', true);
    $data = base64_decode($encryptedData);
    if ($data === false || strlen($data) < 17) return '';

    $iv     = substr($data, 0, 16);
    $cipher = substr($data, 16);

    $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $plain === false ? '' : $plain;
}

try {

    $stmt = $conn->prepare("EXEC [GET_PERSONALBANKACCOUNTTRANSFER]");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // decrypt per row
    foreach ($rows as &$r) {
        if (isset($r['AccountName'])) {
            $r['AccountName'] = reil_decrypt($r['AccountName']);
        }
        if (isset($r['AccountNumber'])) {
            $r['AccountNumber'] = reil_decrypt($r['AccountNumber']);
        }
    }
    unset($r);

    echo json_encode([
        "isSuccess" => "success",
        "Data" => $rows
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact System Developer.</b><br>".$e->getMessage()
    ]);
}
