<?php
	require_once "../../../config/local_db.php";

	function reil_encrypt(string $data): string {
	    $key = hash('sha256', 'Greek2001', true); // 32-byte key
	    $iv  = random_bytes(16);

	    $encrypted = openssl_encrypt(
	        $data,
	        'AES-256-CBC',
	        $key,
	        OPENSSL_RAW_DATA,
	        $iv
	    );
	    return base64_encode($iv . $encrypted);
	}


	$Bank 				=	strtoupper($_POST['Bank']);
	$AccountName 		=	reil_encrypt(strtoupper($_POST['AccountName']));
	$AccountNumber 		=	reil_encrypt($_POST['AccountNumber']);
	$Corporation 		=	$_POST['Corporation'];
	$Bankownership 		=	$_POST['Bankownership'];
	$Corpcode 			=	$_POST['Corpcode'];


	try{

		$conn->beginTransaction();

		$ins_branchbank = $conn->prepare("INSERT INTO bnk
			(Bank, AccName, AccNumber, Corpo, BnkOwnership, Corpcode)VALUES(?,?,?,?,?,?)");
		$ins_branchbank->execute([$Bank, $AccountName, $AccountNumber, $Corporation, $Bankownership, $Corpcode]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}
?>