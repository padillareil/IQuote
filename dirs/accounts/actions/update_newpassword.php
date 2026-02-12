<?php
require_once "../../../config/local_db.php";

$Username   = $_POST['Username'];
$Newpassword = $_POST['Newpassword'];

$hashedPassword = password_hash($Newpassword, PASSWORD_DEFAULT);


try {
    $conn->beginTransaction();


    $upd_password = $conn->prepare("UPDATE USR SET PassWord=? WHERE UserName=?");
    $upd_password->execute([$hashedPassword,$Username]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    