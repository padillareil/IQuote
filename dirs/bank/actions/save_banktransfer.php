<?php
	require_once "../../../config/local_db.php";

	/*Function for Encyryption Data*/
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

	$Corporation 	=	$_POST['Corporation'];
	$Bank 			=	$_POST['Bank'];
	$Accountname 	=	reil_encrypt($_POST['Accountname']);
	$Accountnumber 	=	reil_encrypt($_POST['Accountnumber']);
	$Corpcode 		=	$_POST['Corpcode'];
	
	try{

		$conn->beginTransaction();

		$ins_bank = $conn->prepare("INSERT INTO CORPBNK
			(Corporation, Bank,BankAccountname,BankAccountnumber,Corpcode
				)VALUES(?,?,?,?,?)");
		$ins_bank->execute([$Corporation,$Bank, $Accountname, $Accountnumber, $Corpcode]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}
?>

