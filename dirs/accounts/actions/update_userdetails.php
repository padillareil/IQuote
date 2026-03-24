<?php
require_once "../../../config/local_db.php";

$Username       = $_POST['Username'];
$Fullname       = $_POST['Fullname'];
$Position       = $_POST['Position'];
$Landline       = $_POST['Landline'];
$Mobile         = $_POST['Mobile'];
$Email          = $_POST['Email'];

try {
    $conn->beginTransaction();


    $upd_details = $conn->prepare("UPDATE usr SET Mobile=?,Name=?, UPosition = ?,Landline=?, Email = ? WHERE UserName=?");
    $upd_details->execute([$Mobile,$Fullname,$Position,$Landline,$Email, $Username]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    