<?php
  require_once "../../../../config/local_db.php";

  function reil_decrypt(?string $encryptedData): string {
      if (!$encryptedData) return '';

      $key  = hash('sha256', 'Greek2001', true);
      $data = base64_decode($encryptedData);
      if ($data === false || strlen($data) < 17) return '';

      $iv     = substr($data, 0, 16);
      $cipher = substr($data, 16);

      $plain = openssl_decrypt($cipher, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
      return $plain === false ? '' : $plain;
  }


  $Branch     = $_POST['Branch'];

  $response    = array();

try {
  $conn->beginTransaction();

    $fetch_branchbank = $conn->prepare("
      EXEC GET_PERSONALBANKACCOUNT @mBranch_ = ?
    ");
    $fetch_branchbank->execute([ $Branch ]);
    $get_branchbank = $fetch_branchbank->fetchAll(PDO::FETCH_ASSOC);

    // decrypt per row
    foreach ($get_branchbank as &$r) {
        if (isset($r['AccountName'])) {
            $r['AccountName'] = reil_decrypt($r['AccountName']);
        }
        if (isset($r['AccountNumber'])) {
            $r['AccountNumber'] = reil_decrypt($r['AccountNumber']);
        }
    }


  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_branchbank
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
