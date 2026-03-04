<?php
require_once "../../../../config/local_db.php";

$Username   = $_POST['Username'];
$Contact    = $_POST['Contact'];
$Email      = $_POST['Email'];

try {
    $conn->beginTransaction();

    $upd_contact = $conn->prepare("UPDATE USR SET Mobile=?,Email=? WHERE Username=?");
    $upd_contact->execute([$Contact,$Email,$Username]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    