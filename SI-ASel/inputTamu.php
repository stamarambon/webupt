<?php
include "koneksi.php";
// Koneksi ke database dan proses lainnya

if (isset($_POST['input'])) {
    // Ambil data dari form
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $instansi = mysqli_real_escape_string($koneksi, $_POST['instansi']);
    $keperluan = mysqli_real_escape_string($koneksi, $_POST['keperluan']);
    $hp = mysqli_real_escape_string($koneksi, $_POST['hp']);
    $pesankesan = mysqli_real_escape_string($koneksi, $_POST['pesankesan']);
    $indeks = mysqli_real_escape_string($koneksi, $_POST['indeks']);
    $tanggal = date("Ymd"); // Format: TanggalBulanTahunJamMenitDetik
    
    if (!empty($_POST['foto'])) {
        // Proses data gambar
        $base64_image = $_POST['foto'];
        $file_extension = 'jpeg'; // Ganti sesuai format gambar yang diambil
        $fotoName = $nama . '_' . $tanggal . '.' . $file_extension; // Menggunakan kombinasi nama dan tanggal
        
        // Decode dan simpan gambar
        $decoded_image = base64_decode(str_replace('data:image/'.$file_extension.';base64,', '', $base64_image));
        $targetDirectory = "berkas/foto_tamu/"; // Ganti dengan path folder yang sesuai
        $fotoPath = $targetDirectory . $fotoName;
        
        if (file_put_contents($fotoPath, $decoded_image)) {
            // Simpan data ke database
            $insertQuery = "INSERT INTO data_tamu (nama, alamat, instansi, keperluan, hp, pesankesan, indeks, foto, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $insertQuery);
            mysqli_stmt_bind_param($stmt, "sssssssss", $nama, $alamat, $instansi, $keperluan, $hp, $pesankesan, $indeks, $fotoName, $tanggal);
            
            try {
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    // Insert was successful
                    echo "<script>alert('Data Berhasil Disimpan')</script>";
                    echo '<script type="text/javascript">window.location = "bukutamu.php"</script>';
                    exit();
                } else {
                    // Insert failed due to other reasons
                    echo "<script>alert('Terjadi kesalahan dalam menyimpan data')</script>";
                    echo '<script type="text/javascript">window.location = "bukutamu.php"</script>';
                }
            } catch (mysqli_sql_exception $e) {
                echo "<script>alert('Terjadi kesalahan dalam menyimpan data')</script>";
                echo '<script type="text/javascript">window.location = "bukutamu.php"</script>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Terjadi kesalahan dalam menyimpan gambar')</script>";
            echo '<script type="text/javascript">window.location = "bukutamu.php"</script>';
        }
    } else {
        echo "<script>alert('Foto tidak tersedia')</script>";
        echo '<script type="text/javascript">window.location = "bukutamu.php"</script>';
    }
}
// ... kode lainnya ...
?>
