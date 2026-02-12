<?php
  require_once "../../../config/local_db.php";

  $Bnkid     = $_POST['Bnkid'];

  function reil_decrypt(?string $encryptedData): string {
      if (!$encryptedData) return '';

      $key  = hash('sha256', 'Greek2001', true);
      $data = base64_decode(trim($encryptedData));
      if ($data === false || strlen($data) < 17) return '';

      $iv     = substr($data, 0, 16);
      $cipher = substr($data, 16);

      $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
      return $plain === false ? '' : $plain;
  }
  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_bank = $conn->prepare("
      SELECT Bnkid, Bank, AccName, AccNumber, Branch
      FROM BNK 
      WHERE Bnkid = ?
    ");
    $fetch_bank->execute([ $Bnkid ]);
    $get_bank = $fetch_bank->fetch(PDO::FETCH_ASSOC);

    if ($get_bank) {
            $get_bank['AccName']   = reil_decrypt($get_bank['AccName'] ?? '');
            $get_bank['AccNumber'] = reil_decrypt($get_bank['AccNumber'] ?? '');
        }

  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_bank
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

