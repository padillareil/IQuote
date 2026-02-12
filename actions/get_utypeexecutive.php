<?php
  session_start();
  require_once "../config/local_db.php";

  $Admin = $_SESSION['UserName'] ?? null;

try {
  $conn->beginTransaction();

    $fetch_utype = $conn->prepare("
      SELECT Position
      FROM usr 
      WHERE UserName = ?
    ");
    $fetch_utype->execute([ $Admin ]);
    $get_ustype = $fetch_utype->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_ustype
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

