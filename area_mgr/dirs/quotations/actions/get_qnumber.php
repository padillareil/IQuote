<?php
session_start();
require_once "../../../../config/local_db.php";

$QNUMBER  = $_POST['QNUMBER'];
$response = array();

try {

    date_default_timezone_set('Asia/Manila');
    $CommitDate  = date('Y-m-d');
    $CreatedTime = date('H:i:s');
    $Software    = 'IQUOTE';
    $Action      = "Print Quotation - $QNUMBER";
    $Admin    = $_SESSION['UserName']; 
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];
    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);



    // fetch data for PDF
    $fetch_qtforpdf = $conn->prepare("EXEC dbo.[QNUMBER_PROCEDURE] ?;");
    $fetch_qtforpdf->execute([$QNUMBER]);
    $get_quote = $fetch_qtforpdf->fetch(PDO::FETCH_ASSOC);
    $fetch_qtforpdf->closeCursor();
    // update print counter (+1 every print)
    $upd_print = $conn->prepare("UPDATE qtation SET PrintStatus = PrintStatus + 1 WHERE QNumber = ?");
    $upd_print->execute([$QNUMBER]);

    $response = array(
        "isSuccess" => 'success',
        "Data" => $get_quote
    );
    echo json_encode($response);

} catch (PDOException $e) {
    $response = array(
        "isSuccess" => 'Failed',
        "Data" => "<b>Error. Please Contact System Developer. <br/></b>".$e->getMessage()
    );
    echo json_encode($response);
}
?>
