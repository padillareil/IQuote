<?php
require_once "../../../../config/local_db.php";

$QNUMBER      = $_POST['QNUMBER'];
$response   = array();

try {
    $fetch_customer = $conn->prepare("EXEC  dbo.[EDITTERMSCONDITION_PROCEDURE] ?;");
    $fetch_customer->execute([$QNUMBER]);
    $get_customer = $fetch_customer->fetchAll(PDO::FETCH_ASSOC);
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
