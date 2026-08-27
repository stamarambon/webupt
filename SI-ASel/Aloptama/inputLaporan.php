<?php
include "koneksi.php";

if (isset($_POST['input'])) {
    $radioButtons = array("BESM", "MLSI", "KCSI", "TPTI", "KUSI", "KLSM", "SSSI", "SDSM", "SPSM", "KASAI", "SNSI", "SKSN", "ASSR", "STSR", "TASN", "BASN", "BLSN", "SASN");
    $values = array();

    foreach ($radioButtons as $button) {
        if (isset($_POST[$button])) {
            $values[] = $_POST[$button];
        } else {
            $values[] = 'off';
        }
    }

    $tanggal = date("Ymd"); // Format: Tahun-Bulan-Tanggal

    $placeholders = implode(',', array_fill(0, count($values) + 1, '?'));
    $types = str_repeat('s', count($values) + 1);

    $insertQuery = "INSERT INTO laporan (BESM, MLSI, KCSI, TPTI, KUSI, KLSM, SSSI, SDSM, SPSM, KASAI, SNSI, SKSN, ASSR, STSR, TASN, BASN, BLSN, SASN, tanggal) 
                    VALUES ($placeholders)";

    $stmt = mysqli_prepare($koneksi, $insertQuery);

    // Prepare parameters array
    $params = array_merge([$types], $values, [$tanggal]);
    $refParams = [];
    foreach ($params as $key => $value) {
        $refParams[$key] = &$params[$key];
    }

    // Bind parameters using call_user_func_array
    call_user_func_array(array($stmt, 'bind_param'), $refParams);

    try {
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>alert('Data Berhasil Disimpan')</script>";
            echo '<script type="text/javascript">window.location = "index.php"</script>';
            exit();
        } else {
            echo "<script>alert('Terjadi kesalahan dalam menyimpan data')</script>";
            echo '<script type="text/javascript">window.location = "index.php"</script>';
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Terjadi kesalahan dalam menyimpan data')</script>";
        echo '<script type="text/javascript">window.location = "index.php"</script>';
    }

    mysqli_stmt_close($stmt);
}
?>

<!-- Your HTML form here -->
