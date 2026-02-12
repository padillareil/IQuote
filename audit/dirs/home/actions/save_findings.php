<?php
	session_start();
	require_once "../../../../config/local_db.php";

	$Admin		= $_SESSION['UserName'];
	$QNumber 	=	$_POST['QNumber'];
	$Status     = 'NEW';

	$FingindsApplied  = 'Y';
	try{

		date_default_timezone_set('Asia/Manila');
		$CommitDate = date('Y-m-d');


		$conn->beginTransaction();


		/*Validation*/
		$validation = $conn->prepare("
		    SELECT COUNT(*) 
		    FROM FINDINGS_LOGS 
		    WHERE QNumber = ?
		");
		$validation->execute([$QNumber]);

		if ((int)$validation->fetchColumn() > 0) {
		    exit('Already saved.');
		}



		$fetch_qtaion = $conn->prepare("
		  SELECT QNumber, Branch, CSTMER, CMPNY,Attachment
		  FROM QTATION 
		  WHERE QNumber=?
		");
		$fetch_qtaion->execute([ $QNumber ]);
		$row = $fetch_qtaion->fetch(PDO::FETCH_ASSOC);

		$QNUMBER 		= $row['QNumber'];
		$BRANCH 		= $row['Branch'];
		$CUSTOMER 		= $row['CSTMER'];
		$COMPANY 		= $row['CMPNY'];
		$ATTACHMENT 	= $row['Attachment'];


		$ins_findings = $conn->prepare("INSERT INTO FINDINGS_LOGS
			(QNumber, Branch, Customer, Attachment, Company,Status, DocDate, Username)VALUES(?,?,?,?,?,?,?,?)");
		$ins_findings->execute([$QNumber,$BRANCH, $CUSTOMER, $ATTACHMENT, $COMPANY, $Status,$CommitDate, $Admin]);

		/*Update the findings status*/
		$upd_findings = $conn->prepare("UPDATE QTATION SET FindingStatus=? WHERE QNumber=?");
		$upd_findings->execute([$FingindsApplied,$QNumber]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>