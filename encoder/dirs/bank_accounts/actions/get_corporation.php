<?php
  require_once "../../../../config/local_db.php";

  $Branch = $_POST['Branch'];

  try {
    $conn->beginTransaction();

      $fetch_branches = $conn->prepare("
        SELECT Company
        FROM BRANCHES 
        WHERE Branch = ?
        
      ");
      $fetch_branches->execute([$Branch]);
      $get_branches = $fetch_branches->fetch(PDO::FETCH_ASSOC);

    $conn->commit();

    $response = array(
      "isSuccess" => 'success',
      "Data" => $get_branches
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