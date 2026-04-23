<?php
  require_once "../../../../config/local_db.php";
  session_start();

  $User = $_SESSION['UserName'];
  $CurrentPage  = $_POST['CurrentPage'] ?? 1;
  $PageSize     = $_POST['PageSize'] ?? 20;
  $Search       = $_POST['Search'];

try {
  $conn->beginTransaction();

    $fetch_quotations = $conn->prepare("EXEC dbo.[QuotationList_Pagination] ?,?,?,?");
    $fetch_quotations->execute([$User, $CurrentPage,$PageSize,$Search]);
    $get_quotations = $fetch_quotations->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_quotations
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