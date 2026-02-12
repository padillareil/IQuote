<?php
  require_once "../../../config/local_db.php";

  $RowNum     = $_POST['RowNum'];
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

try {
  $conn->beginTransaction();

    $fetch_banktrasnfer = $conn->prepare("
      SELECT RowNum, BankAccountName, Bank, BankAccountNumber, Corporation, BankOwnership, Corpcode
      FROM CORPBNK
      WHERE RowNum = ?
    ");
    $fetch_banktrasnfer->execute([ $RowNum ]);
    $get_bank = $fetch_banktrasnfer->fetch(PDO::FETCH_ASSOC);

    if ($get_bank) {
      $get_bank['BankAccountName']   = reil_decrypt($get_bank['BankAccountName'] ?? '');
      $get_bank['BankAccountNumber'] = reil_decrypt($get_bank['BankAccountNumber'] ?? '');
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