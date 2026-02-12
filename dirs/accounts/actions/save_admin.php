<?php
	session_start();
	require_once "../../../config/local_db.php";

	$Admin = $_SESSION['UserName'];
	$Fullname 	=	$_POST['Fullname'];
	$Username 	=	$_POST['Username'];
	$Password 	=	$_POST['Password'];
	$Position  		= $_POST['Position'];
	$IDMAccess  = 1;

	$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

	try{

		$conn->beginTransaction();
		$ins_account = $conn->prepare("INSERT INTO usr
			(Username, Password, Position, Createdby, Name, IDMAccess
				)VALUES(?,?,?, ?, ?, ?)");
		$ins_account->execute([$Username, $hashedPassword, $Position, $Admin, $Fullname, $IDMAccess]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>