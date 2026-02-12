<?php
session_start();
require_once "../../../../config/local_db.php";

$UserName     = $_SESSION['UserName'];
$response   = array();

try {
    $fetch_account = $conn->prepare("EXEC dbo.[STAFFPERFORMANCE_PROCEDURE] ?;");
    $fetch_account->execute([$UserName]);
    $get_account = $fetch_account->fetch(PDO::FETCH_ASSOC);
    $fetch_account->closeCursor();
    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_account
    );
    echo json_encode($response);

} catch (PDOException $e) {
    $response = array(
        "isSuccess" => 'Failed',
        "Data" => "<b>Error. Please Contact System Developer. <br/></b>".$e->getMessage()
    );
    echo json_encode($response);
}
?>
