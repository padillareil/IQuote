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

	$User           =	$_SESSION['UserName'];
	$Bank           = strtoupper($_POST['Bank']);
	$Accountname    = reil_encrypt(strtoupper($_POST['Accountname']));
	$Accountnumber  = reil_encrypt(strtoupper($_POST['Accountnumber']));
	$BankOwnership  = strtoupper($_POST['BankOwnership']);
	$Corporation    = strtoupper($_POST['Corporation']);
	$Corpcode       = strtoupper($_POST['Corpcode']);
	$Bankmode 		=	$_POST['Bankmode'];

	try{

		$conn->beginTransaction();

		/*Validate Branch to prevent duplicate*/
		// $validate_branch = $conn->prepare("
	    //     SELECT *
	    //     FROM BNK 
	    //     WHERE Bank = ? OR  AccNumber = ? OR  AccName = ?
	    // ");
	    // $validate_branch->execute([$Bank, $Accountnumber, $Accountname]);
	    // $branch = $validate_branch->fetch(PDO::FETCH_ASSOC);

	    // if ($branch) {
	    //     $conn->rollBack();
	    //     exit('This bank already exists.');
	    // }

		$ins_bank = $conn->prepare("INSERT INTO BNK
			(Bank,
			 AccName,
			 AccNumber,
			 BnkMode,
			 BnkOwnership,
			 Corpo,
			 Corpcode,
			 UserName
				)VALUES(?,?,?,?,?,?,?,?)");
		$ins_bank->execute([$Bank,$Accountname, $Accountnumber, $Bankmode, $BankOwnership, $Corporation, $Corpcode, $User]);
		
		$conn->commit();
		echo "OK";

	}catch(PDOException $e){
		$conn->rollback();
		echo "<b>Warning. Please Contact System Developer.<br/></b>".$e;getMessage();
	}


?>
