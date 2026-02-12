<?php
	require_once "../../../config/local_db.php";

	$Downpayment 		=	$_POST['Downpayment'];

	try{

		$conn->beginTransaction();

		$ins_terms = $conn->prepare("INSERT INTO dwnpyment
			(DPayment)VALUES(?)");
		$ins_terms->execute([$Downpayment]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}
?>