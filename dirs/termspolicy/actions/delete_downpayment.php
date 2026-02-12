<?php
  require_once "../../../config/local_db.php";

  $DP_id  = $_POST['DP_id'];

try {
  $conn->beginTransaction();

    $del_bank= $conn->prepare("DELETE FROM dwnpyment WHERE DP_id=?");
    $del_bank->execute([ $DP_id ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>
