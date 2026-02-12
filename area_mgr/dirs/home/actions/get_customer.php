<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin      = $_SESSION['UserName'];
$response   = array();

try {
    $fetch_customer = $conn->prepare("EXEC dbo.[CUSTOMER_PROCEDURE] ?;");
    $fetch_customer->execute([$Admin]);
    $get_customer = $fetch_customer->fetchAll(PDO::FETCH_ASSOC);
    $fetch_customer->closeCursor();
    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_customer
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
