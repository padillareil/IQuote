<?php
session_start();
require_once "../../../config/local_db.php";

$Admin       = $_SESSION['UserName'];
$Password    = $_POST['Password'];

try {
    $conn->beginTransaction();


    $upd_password = $conn->prepare("UPDATE usr SET PassWord=? WHERE UserName=?");
    $upd_password->execute([$Password, $Admin]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    