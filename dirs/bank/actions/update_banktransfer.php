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

$RowNum         = $_POST['RowNum'];
$Corporation    = $_POST['Corporation'];
$Bank           = $_POST['Bank'];
$Accountname    = reil_encrypt($_POST['Accountname']);
$Accountnumber  = reil_encrypt($_POST['Accountnumber']);
$Corpcode       = $_POST['Corpcode'];

try {
    $conn->beginTransaction();

    $upd_banks = $conn->prepare("UPDATE CORPBNK SET 
        Corporation=?, 
        Bank=?,
        BankAccountname=?,
        BankAccountnumber=?,
        Corpcode = ? 
    WHERE RowNum=?");
    $upd_banks->execute([$Corporation,$Bank,$Accountname,$Accountnumber,$Corpcode,$RowNum]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    