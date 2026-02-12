<?php
require_once "../../../config/local_db.php";

$Branch      = strtoupper($_POST['Branch']);
$Branchcode  = $_POST['Branchcode'];
$Area        = strtoupper($_POST['Area']);
$Address     = $_POST['Address'];
$Company     = $_POST['Company'];
$Companycode = $_POST['Companycode'];

try {
    $conn->beginTransaction();

    $ins_branch = $conn->prepare("INSERT INTO Branches
        (Branch, BranchCode, Area, Address, Company, CompanyCode)
        VALUES (?, ?, ?, ?, ?, ?)"
    );
    $ins_branch->execute([$Branch, $Branchcode, $Area, $Address, $Company, $Companycode]);

    $conn->commit();
    echo "success";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
