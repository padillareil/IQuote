<?php
  require_once "../../../../config/local_db.php";

  $UserName     = $_POST['UserName'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_useraccount = $conn->prepare("
      SELECT UserName,Name 
      FROM usr 
      WHERE UserName = ?
    ");
    $fetch_useraccount->execute([ $UserName ]);
    $get_user = $fetch_useraccount->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_user
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

