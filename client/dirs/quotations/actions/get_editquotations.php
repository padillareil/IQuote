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

$QNumber = $_POST['QNumber'] ?? '';

try {

    $stmt = $conn->prepare("EXEC dbo.[GET_QUOTATION_INFO] @mQNumber = ?");
    $stmt->execute([$QNumber]);

    /* ---------- RESULT SET 1 — QUOTE ---------- */
    $get_quote = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($get_quote) {
        $get_quote['AccountName']    = reil_decrypt($get_quote['AccountName'] ?? '');
        $get_quote['AccountNumber']  = reil_decrypt($get_quote['AccountNumber'] ?? '');
        $get_quote['BnkTraAccnname'] = reil_decrypt($get_quote['BnkTraAccnname'] ?? '');
        $get_quote['BnkTraAccnum']   = reil_decrypt($get_quote['BnkTraAccnum'] ?? '');
    }

    /* ---------- RESULT SET 2 — TERMS ---------- */
    $terms = [];
    if ($stmt->nextRowset()) {
        $terms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------- RESULT SET 3 — WARRANTY ---------- */
    $warranty = [];
    if ($stmt->nextRowset()) {
        $warranty = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------- RESULT SET 4 — ORDERS ---------- */
    $orders = [];
    if ($stmt->nextRowset()) {
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode([
        "isSuccess" => "success",
        "Data"      => $get_quote,
        "Terms"     => $terms,
        "Warranty"  => $warranty,
        "Orders"    => $orders
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    ]);
}

?>


