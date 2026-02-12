<?php
require_once "../../../../config/local_db.php";

$Branchcode     =   strtoupper($_POST['Branchcode']);
$Branch         =   strtoupper($_POST['Branch']);
$Branchid         =   $_POST['Branchid'];
$Address        =   $_POST['Address'];
$Area           =   strtoupper($_POST['Area']);
$Corporation    =   $_POST['Corporation'];
$Corpcode       =   strtoupper($_POST['Corpcode']);


try {
    $conn->beginTransaction();

    $upd_branch = $conn->prepare("UPDATE BRANCHES SET Branchcode=?,Branch=?,Address=?,Area=?,Company=?,CompanyCode=? WHERE Branch_id=?");
    $upd_branch->execute([$Branchcode,$Branch,$Address,$Area,$Corporation,$Corpcode,$Branchid]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    