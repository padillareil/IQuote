<?php
  require_once "../../../config/local_db.php";


try {
  $conn->beginTransaction();

    $regions = $conn->prepare("
      SELECT Area AS Region
      FROM branches 
      GROUP BY Area
      ORDER BY Area ASC
    ");
    $regions->execute();
    $get_regions = $regions->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_regions
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

