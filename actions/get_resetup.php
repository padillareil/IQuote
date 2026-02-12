<?php
  session_start();
  require_once "../config/local_db.php";

  $Admin = $_SESSION['UserName']?? null;

try {
  $conn->beginTransaction();

    $fetchaccess = $conn->prepare("
      SELECT IDMAccess
      FROM USR 
      WHERE UserName = ?
    ");
    $fetchaccess->execute([ $Admin ]);
    $get_access = $fetchaccess->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_access
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

