<?php
require_once "../../../config/local_db.php";

$BranchID   = $_POST['BranchID'];
$BranchCode = strtoupper($_POST['BranchCode']);
$Branch     = strtoupper($_POST['Branch']);
$Region     = strtoupper($_POST['Region']);
$Address    = $_POST['Address'];

try {
    $conn->beginTransaction();

    $upd_branch = $conn->prepare("UPDATE BRANCHES SET BranchCode=?,Branch=?,Area=?,Address=? WHERE Branch_id=?");
    $upd_branch->execute([$BranchCode,$Branch,$Region,$Address,$BranchID]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
    