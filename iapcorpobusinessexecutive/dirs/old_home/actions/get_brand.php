<?php
  require_once "../../../../config/VIAC_PROD_NEW.php";

try {
  $conn->beginTransaction();

    $fetch_brand = $conn->prepare("
      SELECT FirmName AS Brand FROM OMRC
      GROUP BY FirmName
      ORDER BY FirmName
    ");
    $fetch_brand->execute();
    $get_brand = $fetch_brand->fetchAll(PDO::FETCH_ASSOC);

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_brand
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