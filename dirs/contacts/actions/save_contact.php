<?php
	require_once "../../../config/local_db.php";

	$Branch 		=	strtoupper($_POST['Branch']);
	$Telephone 		=	$_POST['Telephone'];
	$Mobile 		=	$_POST['Mobile'];
	$Network 		=	$_POST['Network'];

	try{

		$conn->beginTransaction();

		$ins_contact = $conn->prepare("INSERT INTO contacts
			(Branch, Telephone, Mobile, Network)VALUES(?,?,?,?)");
		$ins_contact->execute([$Branch, $Telephone, $Mobile, $Network]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}
?>