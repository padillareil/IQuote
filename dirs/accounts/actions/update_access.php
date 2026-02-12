<?php
require_once "../../../config/local_db.php";

$Username       = $_POST['Username'];
$AccountStatus    = $_POST['AccountStatus'];

try {
    $conn->beginTransaction();


    $upd_password = $conn->prepare("UPDATE USR SET AccountStatus=? WHERE UserName=?");
    $upd_password->execute([$AccountStatus,$Username]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    