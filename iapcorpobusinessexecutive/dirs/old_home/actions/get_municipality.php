<?php
require_once "../../../../config/VIAC_QUOTATION.php";

$Regioncode = $_POST['Code'] ?? null;
$response = array();

try {
    if (!$Regioncode) {
        throw new Exception("Missing Region Code");
    }

    $conn->beginTransaction();

    $fetch_municipality = $conn->prepare("
        SELECT Code, PRVCode, Name
        FROM PHR2  
        WHERE PRVCode = :regionCode ORDER BY Name COLLATE Latin1_General_CI_AS ASC 
    ");
    $fetch_municipality->execute(['regionCode' => $Regioncode]);
    $get_municipality = $fetch_municipality->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_municipality
    );
    echo json_encode($response);

} catch (Exception $e) {
    $conn->rollBack();
    $response = array(
        "isSuccess" => 'failed',
        "Data" => "<b>Error:</b> " . $e->getMessage()
    );
    echo json_encode($response);
}
?>
