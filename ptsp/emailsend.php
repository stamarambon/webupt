<?php
// Define the path to the secure folder
$secureFolder = '/path/to/secure/folder/';

// Define the path to the temporary folder
$tempFolder = '/path/to/temporary/folder/';

// File to be downloaded (change this to your file's name)
$filename = 'example.pdf';

// Construct the full paths
$secureFilePath = $secureFolder . $filename;
$tempFilePath = $tempFolder . $filename;

if (file_exists($secureFilePath)) {
    // Copy the file to the temporary folder
    if (copy($secureFilePath, $tempFilePath)) {
        // Set appropriate headers for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($tempFilePath));

        // Read and output the copied file to the browser
        readfile($tempFilePath);

        // Optionally, you can delete the temporary file after download
        // unlink($tempFilePath);
    } else {
        // File copy failed
        echo "Failed to copy the file.";
    }
} else {
    // File not found in the secure folder
    echo "File not found.";
}
?>

