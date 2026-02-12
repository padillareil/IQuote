<?php
require_once "../../../config/local_db.php";

$Termdid    = $_POST['Termdid'];
$TRMSCON    = $_POST['TRMSCON'];

try {
    $conn->beginTransaction();


    $upd_terms = $conn->prepare("UPDATE trmscondition SET TRMSCON=? WHERE Termdid=?");
    $upd_terms->execute([$TRMSCON,$Termdid]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    