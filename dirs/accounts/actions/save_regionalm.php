<?php
	session_start();
	require_once "../../../config/local_db.php";

	$Admin 		= $_SESSION['UserName'];
	$Fullname 	=	strtoupper($_POST['Fullname']);
	$UPosition 	=	$_POST['UPosition'];
	$Region 	=	strtoupper($_POST['Region']);
	$Landline 	=	$_POST['Landline'];
	$Mobile 	=	$_POST['Mobile'];
	$Username 	=	$_POST['Username'];
	$Password 	=	$_POST['Password'];
	$Position  	= $_POST['Position'];
	$Role  	= 'RM';
	$IDMAccess  = 1;

	
	$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

	try{

		$conn->beginTransaction();
		$ins_account = $conn->prepare("INSERT INTO usr
			(Username, Password, Position, Createdby, Name, UPosition, Region, Landline, Mobile, Role, IDMAccess
				)VALUES(?,?,?, ?, ?,?,?,?, ?, ?,?)");
		$ins_account->execute([$Username, $hashedPassword, $Position, $Admin, $Fullname, $UPosition, $Region, $Landline, $Mobile, $Role, $IDMAccess]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>