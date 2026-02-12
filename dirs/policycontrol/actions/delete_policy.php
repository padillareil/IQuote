<?php
  require_once "../../../config/local_db.php";

  $Termdid  = $_POST['Termdid'];

try {
  $conn->beginTransaction();

    $del_policy= $conn->prepare("DELETE FROM trmscondition WHERE Termdid=?");
    $del_policy->execute([ $Termdid ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>