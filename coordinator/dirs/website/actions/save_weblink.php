<?php
	session_start();
	require_once "../../../../config/local_db.php";

	$Admin 				= $_SESSION['UserName'];
	$Web_url 			=	$_POST['Web_url'];
	
	try{
		/*Insert Audit Logs*/
		$clientIP = $_SERVER['REMOTE_ADDR'];
		$fullHost = gethostbyaddr($clientIP);
		$Hostname = explode('.', $fullHost)[0];
		$Software = 'IQUOTE';
		$Action = 'Save Wesite URL - ' . $Admin;
		$CommitDate = date('Y-m-d');
		$CreatedTime = date('H:i:s');

		$auditlogs = $conn->prepare("
		    INSERT INTO [192.168.101.62].IAP_MSRP.dbo.USRLOG (PcName, TimeStrt, TransDate, Software, UserName, Action)
		    VALUES (?, ?, ?, ?, ?, ?)
		");
		$auditlogs->execute([$Hostname, $CreatedTime, $CommitDate, $Software, $Admin, $Action]);
		$conn->beginTransaction();

		$validate = $conn->prepare("
		    SELECT Web_url
		    FROM WEBSITE_CONTROL
		    WHERE Web_url = ?
		");
		$validate->execute([$Web_url]);

		if ($validate->fetchColumn()) {
		    exit('Web URL already exists, please update to change.');
		}



		$ins_expiry = $conn->prepare("INSERT INTO WEBSITE_CONTROL
			(Web_url, Username, DocDate
				)VALUES(?,?,?)");
		$ins_expiry->execute([$Web_url,$Admin, $CommitDate]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact Software Developer.<br/></b>".$e;getMessage();
	}

?>