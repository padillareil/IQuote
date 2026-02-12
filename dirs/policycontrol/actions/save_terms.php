<?php
	require_once "../../../config/local_db.php";

	$Termscondition 		=	$_POST['Termscondition'];

	try{

		$conn->beginTransaction();

		$ins_terms = $conn->prepare("INSERT INTO trmscondition
			(TRMSCON)VALUES(?)");
		$ins_terms->execute([$Termscondition]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>