<?php
  session_start();
  require_once "../../../../config/connection.php";

  $Admin = $_SESSION['Username'];
  $Admindtls = $conn->prepare("SELECT Corporation FROM USR WHERE Username = ?");
  $Admindtls->execute([$Admin]);
  $row = $Admindtls->fetch(PDO::FETCH_ASSOC);

  $Corporation = $row['Corporation'];

  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_student = $conn->prepare("
      SELECT a.`StudentName`, a.`Address`, a.`Age`,a.`Status`
      FROM tbl_students a 
      WHERE a.`StudentID`=?
    ");
    $fetch_student->execute([ $StudentID ]);
    $get_student = $fetch_student->fetch(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_student
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