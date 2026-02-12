<?php
  session_start();
  require_once "../../../../config/local_db.php";

  $Admin     = $_SESSION['UserName'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_code = $conn->prepare("
      SELECT Bcode AS Branchcode
      FROM USR
      WHERE UserName= ?
    ");
    $fetch_code->execute([ $Admin ]);
    $get_code = $fetch_code->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_code
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

