<?php
  require_once "../../../config/local_db.php";

  $Header_id  = $_POST['Header_id'];

try {
  $conn->beginTransaction();

    $del_header= $conn->prepare("DELETE FROM crpheader WHERE Header_id=?");
    $del_header->execute([ $Header_id ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>