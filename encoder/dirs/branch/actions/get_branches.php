<?php
require_once "../../../../config/local_db.php";


$CurrentPage = $_POST['CurrentPage'];
$PageSize    = $_POST['PageSize'];
$Search      = $_POST['Search'];

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("EXEC dbo.[IAP_BRANCH_PAGINATION] ?,?,?");
    $stmt->execute([$Search, $CurrentPage, $PageSize]);
    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    while ($stmt->nextRowset()) {}

    $conn->commit();

    $response = [
        "isSuccess" => "success",
        "Data"      => $branches
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
