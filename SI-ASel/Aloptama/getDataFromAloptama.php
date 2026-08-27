<?php
include "koneksi.php"; // Ubah sesuai dengan konfigurasi koneksi Anda

$query_aloptama = "SELECT status FROM aloptama"; // Query untuk mengambil data status dari tabel aloptama
$result_aloptama = mysqli_query($koneksi, $query_aloptama);

$data = array(); // Array untuk menyimpan data status

if ($result_aloptama) {
    while ($row = mysqli_fetch_assoc($result_aloptama)) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo "Error: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>
