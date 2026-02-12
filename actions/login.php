<?php
session_start();
require_once "../config/local_db.php";

$Username = $_POST['Username'] ?? '';
$Password = $_POST['Password'] ?? '';

try {
    // ✅ Fetch user record
    $stmt = $conn->prepare("
        SELECT UserName, PassWord, Role, AccountStatus 
        FROM usr 
        WHERE UserName = ?
    ");
    $stmt->execute([$Username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($Password, $user['PassWord'])) {
        // ✅ Successful login
        $_SESSION['UserName'] = $user['UserName'];
        $_SESSION['Role'] = $user['Role'];
        $_SESSION['AccountStatus'] = $user['AccountStatus'];

        // ✅ Insert Audit Log
        $clientIP = $_SERVER['REMOTE_ADDR'];
        $fullHost = gethostbyaddr($clientIP);
        $Hostname = explode('.', $fullHost)[0];
        $Software = 'IQUOTE';
        $Action = 'LOGIN - ' . $user['UserName'];

        // ✅ Set timezone once
        date_default_timezone_set('Asia/Manila');
        $CommitDate = date('Y-m-d');
        $CreatedTime = date('H:i:s');

/*        SEleCT *
From [192.168.101.62].IAP_MSRP.dbo.USRLOG*/ 

        $auditlogs = $conn->prepare("
            INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG 
            (PcName, TimeStrt, TransDate, Software, UserName, Action)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $auditlogs->execute([
            $Hostname, 
            $CreatedTime, 
            $CommitDate, 
            $Software, 
            $user['UserName'], 
            $Action
        ]);


        echo json_encode([
            "isSuccess" => "OK",
            "Data" => $user
        ]);
    } else {
        // ❌ Invalid credentials
        echo json_encode([
            "isSuccess" => "Failed",
            "Message" => "Invalid username or password."
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "isSuccess" => "Error",
        "Message" => $e->getMessage()
    ]);
}
?>
