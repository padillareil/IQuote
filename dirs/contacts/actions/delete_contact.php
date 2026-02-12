<?php
  require_once "../../../config/local_db.php";

  $TID  = $_POST['TID'];

try {
  $conn->beginTransaction();

    $del_contact= $conn->prepare("DELETE FROM contacts WHERE TID=?");
    $del_contact->execute([ $TID ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>