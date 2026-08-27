<?php
// Security Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Start secure session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Security Functions
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function validate_input($data, $type = 'string', $max_length = 255) {
    if (empty($data)) {
        return false;
    }
    
    switch ($type) {
        case 'string':
            return strlen($data) <= $max_length && preg_match('/^[a-zA-Z0-9\s\-_\.]+$/', $data);
        case 'number':
            return is_numeric($data) && $data >= 0;
        case 'date':
            return preg_match('/^\d{4}-\d{2}-\d{2}$/', $data) && strtotime($data) !== false;
        case 'text':
            return strlen($data) <= $max_length;
        default:
            return false;
    }
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Koneksi ke database
$host ="localhost";
$username ="webadmin";
$password ="stamarAMBON@))^@@";
$database = 'suku_cadang';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset untuk mencegah SQL injection
$conn->set_charset('utf8mb4');

// Buat database dan tabel jika belum ada
$create_db = "CREATE DATABASE IF NOT EXISTS $database";
$conn->query($create_db);
$conn->select_db($database);

$create_table = "CREATE TABLE IF NOT EXISTS parts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    jumlah INT NOT NULL,
    keterangan TEXT,
    tanggal DATE NOT NULL
)";

$conn->query($create_table);

// Tambahkan kolom tanggal jika tabel sudah ada tapi belum ada kolom tanggal
$check_column = "SHOW COLUMNS FROM parts LIKE 'tanggal'";
$result = $conn->query($check_column);
if ($result->num_rows == 0) {
    $alter_table = "ALTER TABLE parts ADD COLUMN tanggal DATE NOT NULL DEFAULT (CURDATE())";
    $conn->query($alter_table);
}

// Proses form input dengan validasi keamanan
if ($_POST && isset($_POST['action'])) {
    // Verifikasi CSRF token
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        die('CSRF token tidak valid!');
    }
    
    if ($_POST['action'] == 'add') {
        // Sanitasi dan validasi input
        $nama = sanitize_input($_POST['nama']);
        $kategori = sanitize_input($_POST['kategori']);
        $jumlah = sanitize_input($_POST['jumlah']);
        $keterangan = sanitize_input($_POST['keterangan']);
        $tanggal = sanitize_input($_POST['tanggal']);
        
        // Validasi input
        $errors = [];
        if (!validate_input($nama, 'string', 100)) {
            $errors[] = 'Nama suku cadang tidak valid (maksimal 100 karakter, hanya huruf, angka, spasi, dan tanda hubung)';
        }
        if (!in_array($kategori, ['AWS', 'MAWS', 'Komputer', 'Lainnya'])) {
            $errors[] = 'Kategori tidak valid';
        }
        if (!validate_input($jumlah, 'number')) {
            $errors[] = 'Jumlah stok harus berupa angka positif';
        }
        if (!validate_input($tanggal, 'date')) {
            $errors[] = 'Format tanggal tidak valid';
        }
        if (!validate_input($keterangan, 'text', 1000)) {
            $errors[] = 'Keterangan terlalu panjang (maksimal 1000 karakter)';
        }
        
        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO parts (nama, kategori, jumlah, keterangan, tanggal) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiss", $nama, $kategori, $jumlah, $keterangan, $tanggal);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = 'Data berhasil ditambahkan!';
            } else {
                $_SESSION['error_message'] = 'Gagal menambahkan data: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = implode('<br>', $errors);
        }
        
        // Redirect untuk mencegah resubmission
        header('Location: index.php');
        exit();
    }
}

// Proses delete dengan validasi keamanan
if (isset($_GET['delete']) && isset($_GET['token'])) {
    // Verifikasi CSRF token
    if (!verify_csrf_token($_GET['token'])) {
        die('CSRF token tidak valid!');
    }
    
    $id = filter_var($_GET['delete'], FILTER_VALIDATE_INT);
    if ($id === false || $id <= 0) {
        $_SESSION['error_message'] = 'ID tidak valid!';
    } else {
        $stmt = $conn->prepare("DELETE FROM parts WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Data berhasil dihapus!';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus data: ' . $stmt->error;
        }
        $stmt->close();
    }
    
    // Redirect untuk mencegah resubmission
    header('Location: index.php');
    exit();
}

// Ambil data dengan filter kategori (menggunakan prepared statement)
$filter_kategori = isset($_GET['kategori']) ? sanitize_input($_GET['kategori']) : '';

if ($filter_kategori && in_array($filter_kategori, ['AWS', 'MAWS', 'Komputer', 'Lainnya'])) {
    $stmt = $conn->prepare("SELECT * FROM parts WHERE kategori = ? ORDER BY id DESC");
    $stmt->bind_param("s", $filter_kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $query = "SELECT * FROM parts ORDER BY id DESC";
    $result = $conn->query($query);
}

// Ambil daftar kategori untuk filter (menggunakan prepared statement)
$kategori_query = "SELECT DISTINCT kategori FROM parts ORDER BY kategori";
$kategori_result = $conn->query($kategori_query);

// Display session messages
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Clear session messages
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Managemen Suku Cadang Stasiun Meteorologi Maritim Ambon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .filter-section {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Display Messages -->
        <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">
                    <i class="fas fa-cogs text-primary"></i>
                    Managemen Suku Cadang Meteorologi Maritim Ambon
                </h1>
            </div>
        </div>

        <!-- Form Input Data -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle"></i> Tambah Data Suku Cadang
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Suku Cadang</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="AWS">AWS</option>
                                        <option value="MAWS">MAWS</option>
                                        <option value="Komputer">Komputer</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Stok</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" min="0" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter dan Tabel Data -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> Daftar Suku Cadang
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Filter Kategori -->
                        <div class="filter-section">
                            <form method="GET" action="" class="row align-items-end">
                                <div class="col-md-4">
                                    <label for="filter_kategori" class="form-label">Filter Kategori:</label>
                                    <select class="form-select" id="filter_kategori" name="kategori" onchange="this.form.submit()">
                                        <option value="">Semua Kategori</option>
                                        <?php
                                        $kategori_result->data_seek(0);
                                        while ($row = $kategori_result->fetch_assoc()) {
                                            $selected = ($filter_kategori == $row['kategori']) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($row['kategori']) . "' $selected>" . htmlspecialchars($row['kategori']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <a href="index.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-refresh"></i> Reset Filter
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- Tabel Data -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Suku Cadang</th>
                                        <th>Kategori</th>
                                        <th>Jumlah Stok</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                            echo "<td><span class='badge bg-info'>" . htmlspecialchars($row['kategori']) . "</span></td>";
                                            echo "<td><span class='badge bg-success'>" . htmlspecialchars($row['jumlah']) . "</span></td>";
                                            echo "<td><span class='badge bg-warning'>" . date('d/m/Y', strtotime($row['tanggal'])) . "</span></td>";
                                            echo "<td>" . ($row['keterangan'] ? htmlspecialchars($row['keterangan']) : '-') . "</td>";
                                            echo "<td>";
                                            $delete_url = "?delete=" . $row['id'] . "&token=" . $_SESSION['csrf_token'];
                                            echo "<a href='$delete_url' class='btn btn-danger btn-sm btn-action' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>";
                                            echo "<i class='fas fa-trash'></i> Hapus";
                                            echo "</a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center text-muted'>Tidak ada data suku cadang</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Statistik -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Total Data:</strong> 
                                    <?php
                                    if ($filter_kategori && in_array($filter_kategori, ['AWS', 'MAWS', 'Komputer', 'Lainnya'])) {
                                        $total_stmt = $conn->prepare("SELECT COUNT(*) as total FROM parts WHERE kategori = ?");
                                        $total_stmt->bind_param("s", $filter_kategori);
                                        $total_stmt->execute();
                                        $total_result = $total_stmt->get_result();
                                        $total = $total_result->fetch_assoc()['total'];
                                        $total_stmt->close();
                                    } else {
                                        $total_query = "SELECT COUNT(*) as total FROM parts";
                                        $total_result = $conn->query($total_query);
                                        $total = $total_result->fetch_assoc()['total'];
                                    }
                                    echo $total . " suku cadang";
                                    if ($filter_kategori) {
                                        echo " dalam kategori '" . htmlspecialchars($filter_kategori) . "'";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set tanggal hari ini sebagai default
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalInput = document.getElementById('tanggal');
            if (tanggalInput && !tanggalInput.value) {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                tanggalInput.value = `${year}-${month}-${day}`;
            }
        });

        // Auto-hide alert setelah 3 detik
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-danger')) {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            });
        }, 3000);

        // Konfirmasi sebelum hapus
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data ini?');
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>

