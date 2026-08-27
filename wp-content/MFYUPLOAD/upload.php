<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if form is submitted and files are uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
    $uploadDir = "../../content/MFY/";
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
$indicatorFile = '../../content/MFY/indicator.txt';

// Get today's date in DDMMYYYY format
$dateSuffix = date("dmY", strtotime("+1 day"));


    // Loop through the uploaded files
    $uploadedFiles = [];
    $failedFiles = [];
    foreach ($_FILES['files']['name'] as $key => $fileName) {
        $tmpName = $_FILES['files']['tmp_name'][$key];
        $fileType = mime_content_type($tmpName);
        $allowedTypes = ['application/json', 'application/pdf', 'image/png'];
        $maxFileSize = 100 * 1024 * 1024; // 100MB limit (adjust as needed)

        // Validate the file type and size
        if (in_array($fileType, $allowedTypes) && $_FILES['files']['size'][$key] <= $maxFileSize) {
            
            
            // Extract file extension
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME);
        // Sanitize the base file name
        $safeBaseName = preg_replace("/[^a-zA-Z0-9.-]/", "_", $fileBaseName);

        // Append date suffix
        $safeFileName = "{$safeBaseName}_{$dateSuffix}.{$fileExt}";

        $targetPath = $uploadDir . $safeFileName;

            // Move the file to the target directory
            if (move_uploaded_file($tmpName, $targetPath)) {
                $uploadedFiles[] = $safeFileName;
                
                
            } else {
                $failedFiles[] = $fileName;
            }
        } else {
            $failedFiles[] = $fileName;
        }
    }

    // Prepare response
    if (count($uploadedFiles) > 0) {
    touch($indicatorFile);
        echo json_encode([
            "title" => "Success!",
            "message" => count($uploadedFiles) . " file(s) uploaded successfully!",
            "status" => "success",
            "uploadedFiles" => $uploadedFiles
        ]);
    } else {
        echo json_encode([
            "title" => "Error!",
            "message" => "No files were uploaded or all files failed to upload.",
            "status" => "error",
            "failedFiles" => $failedFiles
        ]);
    }

    exit();
} else {
    // No files were uploaded
    echo json_encode([
        "title" => "Error!",
        "message" => "No files were uploaded.",
        "status" => "error"
    ]);
    exit();
}
?>