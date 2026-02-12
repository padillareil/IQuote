<?php
require_once "../../../../config/local_db.php";

/*Function for Encyryption Data*/
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


$Branch         = $_POST['Branch'];
$Corporation    = $_POST['Corporation'];
$Bnkid          = $_POST['Bnkid'];
$Bank           = $_POST['Bank'];
$Accountname    = reil_encrypt($_POST['Accountname']);
$Accountnumber  = reil_encrypt($_POST['Accountnumber']);


try {
    $conn->beginTransaction();

    $upd_bank = $conn->prepare("UPDATE BNK SET Branch=?,Corpo=?,Bank=?,AccName=?,AccNumber=? WHERE Bnkid=?");
    $upd_bank->execute([$Branch,$Corporation,$Bank,$Accountname,$Accountnumber,$Bnkid]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    