<?php
session_start();
require_once "../config/local_db.php";

$Username = $_POST['Username'];
$Password = $_POST['Password'];

try {
    $ua = $conn->prepare("
        SELECT Userid, Username, Role
        FROM user
        WHERE Username = ? AND Password = ?
    ");
    $ua->execute([$Username, $Password]);
    $get_account = $ua->fetch(PDO::FETCH_ASSOC);

    if ($get_account) {
        $_SESSION['Userid']   = $get_account['Userid'];
        $_SESSION['Username']  = $get_account['Username'];
        $_SESSION['Role']      = $get_account['Role'];

        $response = array(
            "isSuccess" => "OK",
            "Data" => $get_account
        );
    } else {
        $response = array(
            "isSuccess" => "Failed",
            "Message" => "Invalid username or password."
        );
    }

    echo json_encode($response);

} catch (PDOException $e) {
    $response = array(
        "isSuccess" => "Failed",
        "Message" => "Error. Please contact system developer. " . $e->getMessage()
    );
    echo json_encode($response);
}
?>
