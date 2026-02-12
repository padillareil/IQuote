<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin    = $_SESSION['UserName'] ?? null;
$response = [];

try {
    // Use positional placeholder only
    $stmt = $conn->prepare("EXEC dbo.[CUSTOMER_PROCEDURE] ?");
    $stmt->execute([$Admin]);

    $get_customer = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        "isSuccess" => "success",
        "Data"      => $get_customer
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    $response = [
        "isSuccess" => "Failed",
        "Data"      => "<b>Error. Please Contact System Developer.<br/></b>" . $e->getMessage()
    ];
    echo json_encode($response);
}
?>
