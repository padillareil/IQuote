<?php
	require_once "../../../../config/local_db.php";
	session_start();

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

	$User               =	$_SESSION['UserName'];
	$Branch 			=	strtoupper($_POST['Branch']);
	$Bank 				=	$_POST['Bank'];
	$Bankmode 			=	$_POST['Bankmode'];
	$Bankownership 		=	strtoupper($_POST['Bankownership']);
	$Accountname 		=	reil_encrypt(strtoupper($_POST['Accountname']));
	$Accountnumber 		=	reil_encrypt($_POST['Accountnumber']);
	$Corporation 		=	strtoupper($_POST['Corporation']);
	$Corpcode 			=	strtoupper($_POST['Corpcode']);
	
	try{

		$conn->beginTransaction();

		/*Validate Branch to prevent duplicate*/
		$validate_branch = $conn->prepare("
	        SELECT *
	        FROM BNK 
	        WHERE Bank = ? AND  Branch = ?
	    ");
	    $validate_branch->execute([$Bank, $Branch]);
	    $branch = $validate_branch->fetch(PDO::FETCH_ASSOC);

	    if ($branch) {
	        $conn->rollBack();
	        exit('This bank already exists.');
	    }

		$ins_bank = $conn->prepare("INSERT INTO BNK
			(Branch,
			 Bank,
			 AccName,
			 AccNumber,
			 BnkMode,
			 BnkOwnership,
			 Corpo,
			 Corpcode,
			 UserName
				)VALUES(?,?,?,?,?,?,?,?,?)");
		$ins_bank->execute([$Branch,$Bank, $Accountname, $Accountnumber, $Bankmode, $Bankownership, $Corporation, $Corpcode, $User]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>
