<?php
require_once "../../../../config/local_db.php";

try {
  $conn->beginTransaction();

    $stmt = $conn->prepare("EXEC dbo.[AUTODETECTEXPIREQUOTATION]"); 
    $stmt->execute();
    $quotations = $stmt->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $row
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