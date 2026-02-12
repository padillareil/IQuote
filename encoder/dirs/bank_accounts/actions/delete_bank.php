<?php
  require_once "../../../../config/local_db.php";

  $Bnkid  = $_POST['Bnkid'];

try {
  $conn->beginTransaction();

    $del_bank= $conn->prepare("DELETE FROM BNK WHERE Bnkid=?");
    $del_bank->execute([ $Bnkid ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>