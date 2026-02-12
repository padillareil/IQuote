<?php
  require_once "../../../config/local_db.php";

  $Pay_id  = $_POST['Pay_id'];

try {
  $conn->beginTransaction();

    $del_bank= $conn->prepare("DELETE FROM instlment WHERE Pay_id=?");
    $del_bank->execute([ $Pay_id ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>