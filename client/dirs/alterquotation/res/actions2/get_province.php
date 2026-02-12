<?php
require_once "../../../../config/VIAC_QUOTATION.php";
try {
    $conn->beginTransaction();

    $fetch_region = $conn->prepare("
        SELECT Code, Name 
        FROM PHR1 
        ORDER BY Name COLLATE Latin1_General_CI_AS ASC
    ");
    $fetch_region->execute();
    $get_region = $fetch_region->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_region
    );
    echo json_encode($response);

} catch (PDOException $e) {
    $conn->rollback();
    $response = array(
        "isSuccess" => 'Failed',
        "Data" => "<b>Error. Please Contact System Developer. <br/></b>" . $e->getMessage()
    );
    echo json_encode($response);
}
?>
