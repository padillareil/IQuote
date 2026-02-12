<?php
session_start();
require_once "../../../config/local_db.php";

$Admin              = $_SESSION['UserName'];
$Username           = $_POST['Username'];

try {
    $conn->beginTransaction();

    date_default_timezone_set('Asia/Manila');
    $approvedDate = date('Y-m-d H:i:s');


    $fetch_user = $conn->prepare("SELECT UserName, Name, Branch, UPosition FROM usr WHERE UserName = ?");
    $fetch_user->execute([ $Username ]);
    $row = $fetch_user->fetch(PDO::FETCH_ASSOC);

    $Name       = $row['Name'];
    $Branch     = $row['Branch'];
    $Position  = $row['UPosition'];


    $insert_user = $conn->prepare("INSERT INTO remove_usr
        (Username, Name, Branch, Position, Deletedby, DocRemoved)VALUES(?,?,?,?,?,?)");
    $insert_user->execute([$Username, $Name, $Branch, $Position, $Admin, $approvedDate]);


    /*Delete user after insrting the removed user to table remove_usr*/
    $del_user= $conn->prepare("DELETE FROM usr WHERE UserName=?");
    $del_user->execute([ $Username ]);


    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    