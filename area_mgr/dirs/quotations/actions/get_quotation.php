<?php
require_once "../../../../config/local_db.php";
session_start();

$UserName       = $_SESSION['UserName'];
$CurrentPage = $_POST['CurrentPage'];
$PageSize    = $_POST['PageSize'];

$response = [];

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("EXEC dbo.[QUOTATIONPAGINATIONREGIONALMANAGER_PROCEDURE] ?,?,?;");
    $stmt->execute([$UserName, $CurrentPage, $PageSize]);
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
