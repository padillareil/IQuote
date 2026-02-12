<?php
	session_start();
	require_once "../../../config/local_db.php";

	$Admin 		= 	$_SESSION['UserName'];
	$Fullname 	=	$_POST['Fullname'];
	$UPosition 	=	$_POST['UPosition'];
	$Landline 	=	$_POST['Landline'];
	$Mobile 	=	$_POST['Mobile'];
	$Username 	=	$_POST['Username'];
	$Password 	=	$_POST['Password'];
	$Position  	= 	$_POST['Position'];
	$Bcode  	=   'VIAC';
	$Region  	=   'PANAY';
	$Role  		=   'BOSS';
	$AccountStatus  		=   'ENABLE';
	$IDMAccess  = 1;

	$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

	try{

		$conn->beginTransaction();
		$ins_account = $conn->prepare("INSERT INTO usr
			(Username, Password, Position, Createdby, Name, Landline, Mobile, Bcode, Region, Role, UPosition,AccountStatus,IDMAccess
				)VALUES(?,?,?, ?, ?,?,?,?,?, ?, ?,?,?)");
		$ins_account->execute([$Username, $hashedPassword, $Position, $Admin, $Fullname, $Landline, $Mobile, $Bcode, $Region, $Role, $UPosition, $AccountStatus, $IDMAccess]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>