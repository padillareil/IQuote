<?php
require_once "../../../../config/local_db.php";

$municipalityCode = $_POST['Code'] ?? null;
$response = array();

try {
    if (!$municipalityCode) {
        throw new Exception("Missing Municipality Code");
    }

    $conn->beginTransaction();

    $fetch_barangay = $conn->prepare("
        SELECT TCCode, Name
        FROM PHR3  
        WHERE TCCode = :municipalityCode  ORDER BY Name COLLATE Latin1_General_CI_AS ASC
    ");
    $fetch_barangay->execute(['municipalityCode' => $municipalityCode]);
    $get_barangay = $fetch_barangay->fetchAll(PDO::FETCH_ASSOC);

    $conn->commit();

    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_barangay
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
