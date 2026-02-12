<?php
require_once "../../../../config/VIAC_ISERVE.php";

$response = array();

try {
  $conn->beginTransaction();

  $fetch_branch = $conn->prepare("EXECUTE dbo.SEARCH_BRANCHLIST;");
  $fetch_branch->execute([]);

  $get_branch = $fetch_branch->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_branch
  );
  echo json_encode($response);

} catch (PDOException $e) {
  $conn->rollback();
  $response = array(
    "isSuccess" => 'Failed',
    "Data" => "<b>Error. Please Contact System Developer. <br/></b>" . $e->getMessage()
  );
  echo json_encode($response);
}
?>
