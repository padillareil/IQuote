<?php
session_start();
require_once "../config/local_db.php";

$Admin      = $_SESSION['UserName'];
$Password = $_POST['Password'];
$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
$IDMAccess = '';

try {
    $conn->beginTransaction();


    $upd_password = $conn->prepare("UPDATE USR SET PassWord = ?,IDMAccess=? WHERE UserName=?");
    $upd_password->execute([$hashedPassword,$IDMAccess,$Admin]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    