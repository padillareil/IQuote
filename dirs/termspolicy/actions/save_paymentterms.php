<?php
	require_once "../../../config/local_db.php";

	$PaymentTerm 		=	$_POST['PaymentTerm'];
	$PaymentPeriod 		=	$_POST['PaymentPeriod'];


	try{

		$conn->beginTransaction();

		$ins_installment = $conn->prepare("INSERT INTO instlment
			(PayTerm, PayPeriod)VALUES(?,?)");
		$ins_installment->execute([$PaymentTerm, $PaymentPeriod]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}
?>