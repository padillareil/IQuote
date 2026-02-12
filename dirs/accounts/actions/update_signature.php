<?php
require_once "../../../config/local_db.php";

// Get username
$Username = $_POST['UserName'] ?? '';

// Read uploaded file as Base64
$Attachment = isset($_FILES['upload-signature']) 
    ? base64_encode(file_get_contents($_FILES['upload-signature']['tmp_name'])) 
    : null;

if (!$Attachment) {
    echo "No file uploaded.";
    exit;
}

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("
        EXEC dbo.[UPLOAD_SIGNATURE] 
            @mUsername = ?, 
            @mSignature = ?
    ");
    $stmt->execute([$Username, $Attachment]);

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
