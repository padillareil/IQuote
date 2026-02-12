<?php
require_once "../../../../config/local_db.php";

$Bnkid = $_POST['Bnkid'];

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

    $fetch_bnk = $conn->prepare("
        SELECT
            Bnkid,
            Bank,
            AccName,
            AccNumber,
            UserName,
            Corpo,
            BnkMode,
            BnkOwnership,
            Branch
        FROM BNK 
        WHERE Bnkid = ?
    ");
    $fetch_bnk->execute([$Bnkid]);
    $get_branch = $fetch_bnk->fetch(PDO::FETCH_ASSOC);

    while ($fetch_bnk->nextRowset()) {}

    // Decrypt only AccName and AccNumber
    if (!empty($get_branch['AccName'])) {
        $get_branch['AccName'] = reil_decrypt($get_branch['AccName']);
    }
    if (!empty($get_branch['AccNumber'])) {
        $get_branch['AccNumber'] = reil_decrypt($get_branch['AccNumber']);
    }

    $conn->commit();

    echo json_encode([
        "isSuccess" => 'success',
        "Data" => $get_branch
    ]);

} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo json_encode([
        "isSuccess" => 'Failed',
        "Data" => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    ]);
}
?>
