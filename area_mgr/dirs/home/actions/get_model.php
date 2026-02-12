<?php
require_once "../../../../config/local_db.php";

$Brand    = $_POST['Brand'];
$response = array();

try {
    $fetch_model = $conn->prepare("
        EXEC [GET_ITEMMODEL] @mBrand_ = ?
    ");
    $fetch_model->execute([$Brand]);
    $get_model = $fetch_model->fetchAll(PDO::FETCH_ASSOC);

    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_model
    );
    echo json_encode($response);

} catch (PDOException $e) {
    $response = array(
        "isSuccess" => 'Failed',
        "Data" => "<b>Error. Please contact system developer.</b>"
    );
    echo json_encode($response);
}
?>
