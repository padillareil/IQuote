<?php
require_once "../../../config/local_db.php";

    $Branch         =   strtoupper($_POST['Branch']);
    $Telephone      =   $_POST['Telephone'];
    $Mobile         =   $_POST['Mobile'];
    $Network        =   $_POST['Network'];
    $TID            =   $_POST['TID'];

try {
    $conn->beginTransaction();

    

    $upd_contact = $conn->prepare("UPDATE contacts SET Branch=?,Telephone=?,Mobile=?,Network=? WHERE TID=?");
    $upd_contact->execute([$Branch,$Telephone,$Mobile,$Network,$TID]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    