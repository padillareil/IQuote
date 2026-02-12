<?php
require_once "../../../../config/local_db.php";

$Region      = $_POST['Region'];
$response   = array();

try {
    $fetch_branch = $conn->prepare("EXEC dbo.[RMBRANCH_PROCEDURE] ?;");
    $fetch_branch->execute([$Region]);
    $get_branch = $fetch_branch->fetchAll(PDO::FETCH_ASSOC);
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
