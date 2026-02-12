<?php
require_once "../../../../config/local_db.php";

$Branch     = $_POST['Branch'];
$ItemCode    = $_POST['ItemCode'];
$response = array();

try {
    $fetch_pricebranch = $conn->prepare("
        EXEC [GET_UPDATEDPRICE] @mBranch_ = ?, @mItemCode_ = ?
    ");
    $fetch_pricebranch->execute([$Branch, $ItemCode]);
    $get_price = $fetch_pricebranch->fetchAll(PDO::FETCH_ASSOC);

    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_price
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
