<?php
  require_once "../../../../config/local_db.php";

  $Branchid  = $_POST['Branchid'];

try {
  $conn->beginTransaction();

    $del_branch= $conn->prepare("DELETE FROM BRANCHES WHERE Branch_id=?");
    $del_branch->execute([ $Branchid ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>