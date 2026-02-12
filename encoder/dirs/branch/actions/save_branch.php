<?php
	require_once "../../../../config/local_db.php";

	$Branchcode 	=	strtoupper($_POST['Branchcode']);
	$Branch 		=	strtoupper($_POST['Branch']);
	$Address 		=	$_POST['Address'];
	$Area 			=	strtoupper($_POST['Area']);
	$Corporation 	=	$_POST['Corporation'];
	$Corpcode 		=	strtoupper($_POST['Corpcode']);

	
	try{

		$conn->beginTransaction();

		/*Validate Branch to prevent duplicate*/
		$validate_branch = $conn->prepare("
	        SELECT  1
	        FROM BRANCHES 
	        WHERE Branchcode = ?
	           OR Branch = ?
	           OR Address = ?
	    ");
	    $validate_branch->execute([$Branchcode, $Branch, $Address]);
	    $branch = $validate_branch->fetch(PDO::FETCH_ASSOC);

	    if ($branch) {
	        $conn->rollBack();
	        exit('This branch already exists.');
	    }


		$ins_branch = $conn->prepare("INSERT INTO BRANCHES
			(Branchcode, Branch,Address,Area,Company,CompanyCode
				)VALUES(?,?,?,?,?,?)");
		$ins_branch->execute([$Branchcode,$Branch, $Address, $Area, $Corporation, $Corpcode]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>


