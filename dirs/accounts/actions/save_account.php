<?php
	session_start();
	require_once "../../../config/local_db.php";

	$Admin = $_SESSION['UserName'];

	$Bcode 		=	$_POST['Bcode'];
	$Name 		=	$_POST['Name'];
	$UPosition 	=	$_POST['UPosition'];
	$Landline 	=	$_POST['Landline'];
	$Mobile 	=	$_POST['Mobile'];
	$Username 	=	$_POST['Username'];
	$Password 	=	$_POST['Password'];
	$Role  		= 	$_POST['Role'];
	$IDMAccess  = 	1;
	$Headoffice  	= 'HEAD OFFICE';
	$Corpo       	= 'VIAC';
	$Region  		= 'PANAY';
	$AccountStatus  = 'ENABLE';
	$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

	try{

		$conn->beginTransaction();

		$ins_account = $conn->prepare("EXEC dbo.[CREATE_ACCOUNT] 
			@mBcode = ?,
			@mFullname = ?,
			@mPosition = ?,
			@mLandline = ?,
			@mMobile = ?,
			@mUsername = ?,
			@mPassword = ?,
			@mCorpo = ?,
			@mRegion = ?,
			@mRole = ?,
			@mAccStatus = ?,
			@mIDMAccess = ?");
		$ins_account->execute([$Bcode, $Name, $UPosition, $Landline, $Mobile, $Username, $hashedPassword, $Corpo, $Region, $Role, $AccountStatus, $IDMAccess]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>