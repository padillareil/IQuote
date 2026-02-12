<?php
  require_once "../../../config/local_db.php";

  $RowNum  = $_POST['RowNum'];

try {
  $conn->beginTransaction();

    $del_number= $conn->prepare("DELETE FROM CORPBNK WHERE RowNum=?");
    $del_number->execute([ $RowNum ]);

  $conn->commit();
  echo "success";

}catch (PDOException $e){
  $conn->rollback();
  echo "<b>Warning. Please Contact System Developer. <br/></b>".$e->getMessage();
}

?>