<?php
  session_start();
  require_once "../config/local_db.php";

  $Admin     = $_SESSION['UserName'] ?? null;
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_user = $conn->prepare("
      SELECT AccountStatus, Role
      FROM usr 
      WHERE UserName= ?
    ");
    $fetch_user->execute([ $Admin ]);
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

