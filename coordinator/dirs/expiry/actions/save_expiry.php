<?php
	session_start();
	require_once "../../../../config/local_db.php";

	$Admin 				= $_SESSION['UserName'];
	$CustomerType 		=	$_POST['CustomerType'];
	$Type 				=	$_POST['Type'];
	$ExpiryDays 		=	$_POST['ExpiryDays'];
	
	try{
		/*Insert Audit Logs*/
		$clientIP = $_SERVER['REMOTE_ADDR'];
		$fullHost = gethostbyaddr($clientIP);
		$Hostname = explode('.', $fullHost)[0];
		$Software = 'IQUOTE';
		$Action = 'Create Expiry Control - ' . $Admin;
		$CommitDate = date('Y-m-d');
		$CreatedTime = date('H:i:s');

		$auditlogs = $conn->prepare("
		    INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
		    VALUES (?, ?, ?, ?, ?, ?)
		");
		$auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
		$conn->beginTransaction();

		$validate = $conn->prepare("
		    SELECT CustomerType
		    FROM EXPIRATION_CONTROL
		    WHERE CustomerType = ?
		");
		$validate->execute([$CustomerType]);

		if ($validate->fetchColumn()) {
		    exit('Customer type already exists, please update to change.');
		}



		$ins_expiry = $conn->prepare("INSERT INTO EXPIRATION_CONTROL
			(CustomerType, Type, ExpiryDays
				)VALUES(?,?,?)");
		$ins_expiry->execute([$CustomerType,$Type, $ExpiryDays]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact Software Developer.<br/></b>".$e;getMessage();
	}

?>