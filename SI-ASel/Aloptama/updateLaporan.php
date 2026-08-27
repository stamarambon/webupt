<?php
// Sertakan file koneksi ke database
include "koneksi.php";

if (isset($_POST['input'])) {
    // Get the current date
    $currentDate = date("Y-m-d");

    // Fungsi untuk membersihkan dan menghindari SQL Injection
    function cleanInput($data) {
        global $koneksi;
        return mysqli_real_escape_string($koneksi, htmlspecialchars($data));
    }

    foreach ($_POST['site_status'] as $siteCode => $status) {
        // Bersihkan nilai dari $_POST sebelum digunakan dalam query
        $siteCode = cleanInput($siteCode);
        $status = cleanInput($status);

        // Query untuk mengupdate status di aloptama
        $updateQuery = "UPDATE aloptama SET status = ? WHERE kode = ?";
        $stmt = mysqli_prepare($koneksi, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ss", $status, $siteCode);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            echo "Error updating status for site code $siteCode: " . mysqli_error($koneksi);
        } else {
            // Query untuk menyisipkan baris baru ke dalam data_log
            $insertLogQuery = "INSERT INTO data_log (kode, tanggal, status) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $insertLogQuery);
            mysqli_stmt_bind_param($stmt, "sss", $siteCode, $currentDate, $status);
            $insertLogResult = mysqli_stmt_execute($stmt);

            if (!$insertLogResult) {
                echo "Error inserting log for site code $siteCode: " . mysqli_error($koneksi);
            }
        }
    }

    echo "<script>alert('Data Berhasil Disimpan')</script>";
    echo '<script type="text/javascript">window.location = "index.php"</script>';
    exit();
}
?>

