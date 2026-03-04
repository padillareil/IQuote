<?php
require_once "../../../../config/local_db.php";
session_start();

if (!isset($_SESSION['UserName'])) {
    echo "Unauthorized access.";
    exit;
}

$Username = $_SESSION['UserName'];

// Match the key "Profile" from the JavaScript FormData
if (!isset($_FILES['user-profile']) || $_FILES['user-profile']['error'] !== UPLOAD_ERR_OK) {
    echo "No file uploaded or upload error.";
    exit;
}

// Convert to Base64
$tmpPath = $_FILES['user-profile']['tmp_name'];
$Attachment = base64_encode(file_get_contents($tmpPath));

try {
    $conn->beginTransaction();

    // Ensure your SP matches these parameter names
    $stmt = $conn->prepare("
        EXEC dbo.[UPLOAD_PROFILE] 
            @mUsername = ?, 
            @mSignature = ?
    ");
    
    $stmt->execute([$Username, $Attachment]);

    $conn->commit();
    echo "OK";

} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo "Database Error: " . $e->getMessage();
}
?>