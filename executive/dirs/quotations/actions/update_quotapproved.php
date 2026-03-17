<?php
session_start();
require_once "../../../../config/local_db.php";

$Admin = $_SESSION['UserName'];
$Approver = $conn->prepare("SELECT Signature, Name, UPosition FROM USR WHERE UserName = ?");
$Approver->execute([$Admin]);
$row = $Approver->fetch(PDO::FETCH_ASSOC);

$Signature = $row['Signature'];
$Name      = $row['Name'];
$Position  = $row['UPosition'];

/* ✅ Helper to clean numeric values */
function cleanNumeric($val) {
    $val = preg_replace("/[^0-9.]/", "", $val);
    return $val === "" ? null : $val; // use 0 if you want instead of null
}
$CustomerName   = $_POST['CustomerName'] ?? '';
$ContactNumber  = $_POST['ContactNumber'] ?? '';
$TinNumber      = $_POST['TinNumber'] ?? '';
$GrandTotal     = cleanNumeric($_POST['GrandTotal']);
$DeliveryCharge = cleanNumeric($_POST['DeliveryCharge']);
$Orders         = json_decode($_POST['Orders'], true);
$Terms          = json_decode($_POST['Terms'], true);
$Warranty       = json_decode($_POST['Warranty'], true);
$Status         = $_POST['Status'];
$PreparedUser   = $_POST['PreparedUser'];
$QNumber        = $_POST['QNumber'];

$Notifystatus = 'New';

try {

    date_default_timezone_set('Asia/Manila');
    $CommitDate  = date('Y-m-d');
    $CreatedTime = date('H:i:s');
    $Software    = 'IQUOTE';
    $Action      = "Approved - $QNumber";
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $fullHost = gethostbyaddr($clientIP);
    $Hostname = explode('.', $fullHost)[0];
    
    $auditlogs = $conn->prepare("
        INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
    
    $conn->beginTransaction();

    $approvedDate = date('Y-m-d H:i:s');

    /* Quotation Update */
    $upd_quotation = $conn->prepare("
        EXEC dbo.UPDATE_QUOTATION ?, ?, ?, ?, ?,?,?,?
    ");
    $upd_quotation->execute([
        $CustomerName,
        $ContactNumber,
        $TinNumber,
        $DeliveryCharge,
        $GrandTotal,
        $Status,
        $Admin,
        $QNumber
    ]);


    /* Item Orders */
    if (!empty($Orders)) {
        $upd_order = $conn->prepare("UPDATE ordr 
            SET ManualDiscount=?, DSCNT=?, TAMOUNT=?, AMNT=? 
            WHERE ORDR_ID=?");
        foreach ($Orders as $order) {
            $upd_order->execute([
                cleanNumeric($order['manualDiscount']),
                cleanNumeric($order['discount']),
                cleanNumeric($order['grossTotal']),
                cleanNumeric($order['discountedamountperunit']),
                $order['id']
            ]);
        }
    }

    /* Terms and Condition */
    if (!empty($Terms)) {
        $upd_termscondition = $conn->prepare("UPDATE terms SET TRMS=? WHERE TRMS_ID=?");
        foreach ($Terms as $term) {
            $upd_termscondition->execute([$term['value'], $term['id']]);
        }
    }

    /* Warranty */
    if (!empty($Warranty)) {
        $upd_warranty = $conn->prepare("UPDATE warranty SET WRRNTY=? WHERE WRRNTY_ID=?");
        foreach ($Warranty as $wrnty) {
            $upd_warranty->execute([$wrnty['value'], $wrnty['id']]);
        }
    }

    /* Insert Data for approved */
    $ins_approve = $conn->prepare("INSERT INTO notify
        (Approver, UserName, Status, QNumber) VALUES (?,?,?,?)");
    $ins_approve->execute([$Name, $PreparedUser, $Notifystatus, $QNumber]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
