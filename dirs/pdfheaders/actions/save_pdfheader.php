<?php
require_once "../../../config/local_db.php";

$Corporation = $_POST['Corporation'];
$Corpocode = $_POST['Corpocode'];

try {
    if (empty($_FILES['Profile']['name'])) {
        echo "No file uploaded.";
        exit;
    }

    $uploadDir = "../../../assets/image/header/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Get file extension safely
    $fileExtension = pathinfo($_FILES['Profile']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid('profile_', true) . '.' . $fileExtension;
    $filePath = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES['Profile']['tmp_name'], $filePath)) {
        echo "Failed to save the file.";
        exit;
    }
    $relativePath = "assets/image/header/" . $fileName;
    $conn->beginTransaction();
    $ins_headers = $conn->prepare("INSERT INTO crpheader
        (ImageHeader,Corpo, CorpCode
            )VALUES(?,?,?)");
    $ins_headers->execute([$relativePath, $Corporation, $Corpocode]);

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "<b>Warning. Please Contact System Developer.<br/></b>" . $e->getMessage();
}
?>
