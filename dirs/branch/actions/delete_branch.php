<?php
  require_once "../../../config/local_db.php";

  $Branch_id  = $_POST['Branch_id'];

try {
  $conn->beginTransaction();

    $del_branch= $conn->prepare("DELETE FROM branches WHERE Branch_id=?");
    $del_branch->execute([ $Branch_id ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>