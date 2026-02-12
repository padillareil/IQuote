<?php
  require_once "../../../config/local_db.php";

  $UserName     = $_POST['UserName'];
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_user = $conn->prepare("
      SELECT UserName, Name, Landline, Mobile, UPosition
      FROM usr 
      WHERE UserName = ?
    ");
    $fetch_user->execute([ $UserName ]);
    $get_user = $fetch_user->fetch(PDO::FETCH_ASSOC);

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

