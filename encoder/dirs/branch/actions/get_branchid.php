<?php
  require_once "../../../../config/local_db.php";

  $Branch_id     = $_POST['Branch_id'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_branch = $conn->prepare("
      SELECT Branch_id, BranchCode, Branch, Area, Company, CompanyCode, Address
      FROM BRANCHES 
      WHERE Branch_id = ?
    ");
    $fetch_branch->execute([ $Branch_id ]);
    $get_branch = $fetch_branch->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_branch
  );
  echo json_encode($response);

}catch (PDOException $e){
  $conn->rollback();
  $response = array(
    "isSuccess" => 'Failed',
    "Data" => "<b>Error. Please Contact System Developer. <br/></b>".$e->getMessage()
  );
  echo json_encode($response);
}
?>