<?php
require_once "../../../../config/local_db.php";

$Branch      = $_POST['Branch'];
$response   = array();

try {
    $fetch_corpcode = $conn->prepare("EXEC dbo.[RMCORPCODE_PROCEDURE] ?;");
    $fetch_corpcode->execute([$Branch]);
    $get_branch = $fetch_corpcode->fetch(PDO::FETCH_ASSOC);
    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_branch
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
