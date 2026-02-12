<?php
require_once "../../../config/local_db.php";

function reil_encrypt(string $data): string {
    $key = hash('sha256', 'Greek2001', true); // 32-byte key
    $iv  = random_bytes(16);

    $encrypted = openssl_encrypt(
        $data,
        'AES-256-CBC',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );
    return base64_encode($iv . $encrypted);
}

$Bnkid      = $_POST['Bnkid'];
$Bank       = $_POST['Bank'];
$AccName    = reil_encrypt($_POST['AccName']);
$AccNumber  = reil_encrypt($_POST['AccNumber']);

try {
    $conn->beginTransaction();

    $upd_bank = $conn->prepare("UPDATE bnk SET Bank=?,AccName=?,AccNumber=? WHERE Bnkid=?");
    $upd_bank->execute([$Bank, $AccName, $AccNumber, $Bnkid]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    