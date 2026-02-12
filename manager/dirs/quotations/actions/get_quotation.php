<?php
require_once "../../../../config/local_db.php";
session_start();

$User        = $_SESSION['UserName'];
$Bcode       = $_POST['Bcode'];
$CurrentPage = $_POST['CurrentPage'];
$PageSize    = $_POST['PageSize'];

$response = [];

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("EXEC dbo.[QUOTATIONPAGINATIONMANAGER_PROCEDURE] ?,?,?,?");
    $stmt->execute([$Bcode, $CurrentPage, $PageSize, $User]);
    $quotations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    while ($stmt->nextRowset()) {}

    $conn->commit();

    $response = [
        "isSuccess" => "success",
        "Data"      => $quotations
    ];
    echo json_encode($response);

} catch (PDOException $e) {
    $conn->rollback();
    $response = [
        "isSuccess" => "Failed",
        "Data"      => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    ];
    echo json_encode($response);
}
?>
