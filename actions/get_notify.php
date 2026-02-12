<?php
session_start();
require_once "../config/local_db.php";
$Admin = $_SESSION['UserName'] ?? null;
$response   = array();

try {
    $fetch_usernotify = $conn->prepare("EXEC dbo.[NOTIFY_PROCEDURE] @mUserName = ?");
    $fetch_usernotify->execute([$Admin]);
    $get_notiy = $fetch_usernotify->fetch(PDO::FETCH_ASSOC);

    // no commit needed for SELECT
    $response = [
        "isSuccess" => "success",
        "Data" => $get_notiy
    ];
    echo json_encode($response);

} catch (PDOException $e) {
    $response = [
        "isSuccess" => "Failed",
        "Data" => "<b>Error. Please Contact System Developer. <br/></b>" . $e->getMessage()
    ];
    echo json_encode($response);
}

?>
