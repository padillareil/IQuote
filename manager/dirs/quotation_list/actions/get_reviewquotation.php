<?php
require_once "../../../../config/local_db.php";

$QNumber = $_POST['QNumber'];

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("EXEC dbo.[ReviewQuotation_Summary] ?");
    $stmt->execute([$QNumber]);

    // ✅ 1st result set: Header
    $header = $stmt->fetch(PDO::FETCH_ASSOC);


    /*Function Decrypt Encrypted Information*/
    function reil_decrypt(string $encryptedData): string {
        $key = hash('sha256', 'Greek2001', true);
        $data = base64_decode($encryptedData);
        if ($data === false || strlen($data) < 17) return '';
        $iv = substr($data, 0, 16);
        $cipher = substr($data, 16);
        $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return $plain === false ? '' : $plain;
    }

    /* ✅ Decrypt specific fields */
    if ($header) {
        $header['ACCOUNTNAME'] = reil_decrypt($header['ACCOUNTNAME'] ?? '');
        $header['ACCNUM']      = reil_decrypt($header['ACCNUM'] ?? '');
    }


    if ($header) {
        $header['CorpAccountName']      = reil_decrypt($header['CorpAccountName'] ?? '');
        $header['CorpAccountNumber']    = reil_decrypt($header['CorpAccountNumber'] ?? '');
    }
    // ✅ 2nd result set: Orders
    $stmt->nextRowset();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // ✅ 3rd result set: Terms
    $stmt->nextRowset();
    $terms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ 4th result set: Warranty
    $stmt->nextRowset();
    $warranty = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    echo json_encode([
        "isSuccess" => "success",
        "Header"    => $header,
        "Orders"    => $orders,
        "Terms"     => $terms,
        "Warranty"  => $warranty
    ]);

} catch (PDOException $e) {
    $conn->rollback();
    echo json_encode([
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    ]);
}
?>