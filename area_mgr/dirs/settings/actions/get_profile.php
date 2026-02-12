<?php
  require_once "../../../../config/local_db.php";
  session_start();

  $User     = $_SESSION['UserName'];

try {
  $conn->beginTransaction();

    $get_userinfo = $conn->prepare("EXEC dbo.[SESSION_ACCOUNTUSER] @mUsername = ?");
    $get_userinfo->execute([ $User ]);
    $get_info = $get_userinfo->fetch(PDO::FETCH_ASSOC);


    if ($get_info && isset($get_info['Profile'])) {
        $get_info['Profile'] = base64_encode($get_info['Profile']);
    }


  $conn->commit();

  $response = array(
    "isSuccess" => 'success',
    "Data" => $get_info
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

