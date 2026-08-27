<?php
// ==========================================
// 1. SYSTEM INITIALIZATION & SECURE HEADERS
// ==========================================
error_reporting(E_ALL);
ini_set('display_errors', 0); // Sembunyikan pesan error mentah dari publik

// Security Headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' https://stamar-ambon.bmkg.go.id data:; script-src 'self' 'unsafe-inline';");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Start isolated session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 0,
        'cookie_secure'   => true, // Mengasumsikan web berjalan di protokol HTTPS
        'cookie_httponly' => true,
        'cookie_samesite' => 'Strict'
    ]);
}

// Session Expiration Handler (30 Minute Timeout)
$timeout_duration = 1800;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout_duration)) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Generate unique dynamic CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ==========================================
// 2. CONFIGURATION & CREDENTIALS
// ==========================================
define('AUTH_USER', 'forecasterambon');
define('AUTH_PASSWORD', 'aksesterbatasstamarambon'); // Ganti password Anda langsung di sini!

// Jalur Executable FFmpeg Server
$ffmpegPath = 'ffmpeg';

$target_dir = __DIR__ . "/uploads/2021/10/";
$file_mapping = [
    "fileToUpload1" => ["path" => $target_dir . "Peringatan-Dini-1harian.png", "mime" => "image/png"],
    "fileToUpload2" => ["path" => $target_dir . "Peringatan-Dini-Gelombang-Tinggi-1harian.pdf", "mime" => "application/pdf"],
    "fileToUpload3" => ["path" => $target_dir . "Peringatan-Dini.png", "mime" => "image/png"],
    "fileToUpload35"=> ["path" => $target_dir . "Peringatan-Dini2.png", "mime" => "image/png"],
    "fileToUpload4" => ["path" => $target_dir . "Peringatan-Dini-Gelombang-Tinggi.pdf", "mime" => "application/pdf"],
    "fileToUpload5" => [
        "path" => realpath(__DIR__ . "/../content/uploads") ? realpath(__DIR__ . "/../content/uploads") . "/test.mp4" : __DIR__ . "/../content/uploads/test.mp4", 
        "mime" => "video/mp4" // Standar default target, validasi khusus GIF diatur di controller bawah
    ]
];

function getStatusIcon($filepath) {
    if (!file_exists($filepath) || (time() - filemtime($filepath) > 18 * 3600)) {
        return "https://stamar-ambon.bmkg.go.id/content/no%20update.png";
    }
    return "https://stamar-ambon.bmkg.go.id/content/update.png";
}

// ==========================================
// 3. ROUTING & CONTROLLER ACTIONS
// ==========================================
$login_error = '';

// ACTION: Handle Manual Logout Request
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// ACTION: Handle Form Login Request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login_submit'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === AUTH_USER && $password === AUTH_PASSWORD) {
        $_SESSION['authenticated'] = true;
        $_SESSION['LAST_ACTIVITY'] = time();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = "Username atau password salah.";
    }
}

// ACTION: Handle File Removal AJAX Endpoint
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajax_remove'])) {
    header('Content-Type: application/json');

    if (empty($_SESSION['authenticated'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Sesi habis. Silakan login kembali.']);
        exit;
    }

    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Validasi token CSRF gagal.']);
        exit;
    }

    $targetField = $_POST['file_field'] ?? '';

    if ($targetField === 'fileToUpload35') {
        $filePath = $file_mapping['fileToUpload35']['path'];
        
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                clearstatcache();
                echo json_encode([
                    'success' => true, 
                    'message' => 'Gambar Peringatan-Dini2.png berhasil dihapus.',
                    'new_status' => getStatusIcon($filePath)
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menghapus file di server. Periksa izin folder.']);
            }
        } else {
            echo json_encode(['success' => true, 'message' => 'File memang sudah tidak ada.', 'new_status' => getStatusIcon($filePath)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Aksi ilegal atau kolom tidak diizinkan dihapus.']);
    }
    exit;
}

// ACTION: Handle AJAX File Upload Payload
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajax_upload'])) {
    header('Content-Type: application/json');

    if (empty($_SESSION['authenticated'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'messages' => ['Sesi habis. Silakan refresh halaman dan login kembali.']]);
        exit;
    }

    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        http_response_code(403);
        echo json_encode(['success' => false, 'messages' => ['Error: Validasi token CSRF gagal.']]);
        exit;
    }

    $response = ['success' => true, 'messages' => [], 'statuses' => []];
    $uploaded_any = false;
    $finfo = new finfo(FILEINFO_MIME_TYPE);

    foreach ($file_mapping as $inputName => $config) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $uploaded_any = true;
            $tmpPath = $_FILES[$inputName]['tmp_name'];
            $detectedMime = $finfo->file($tmpPath);

            // Penanganan Khusus untuk Kolom Video/GIF (fileToUpload5)
            if ($inputName === "fileToUpload5" && $detectedMime === "image/gif") {
                // Jika berkas berupa GIF, izinkan lewat bypass untuk diproses oleh FFmpeg nanti
                $isGifSource = true;
            } else {
                $isGifSource = false;
                // Validasi Mime standar untuk kolom lainnya
                if ($detectedMime !== $config['mime']) {
                    $response['success'] = false;
                    $response['messages'][] = "Tipe berkas tidak cocok untuk field: " . htmlspecialchars($inputName);
                    continue;
                }
            }

            $dir = dirname($config['path']);
            if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
                $response['success'] = false;
                $response['messages'][] = "Gagal memproses struktur direktori server.";
                continue;
            }

            clearstatcache();

            if ($isGifSource) {
                // Jalur sementara untuk menampung file GIF asli di server sebelum diconvert
                $tempGifPath = $dir . "/temp_upload_" . time() . ".gif";
                
                if (move_uploaded_file($tmpPath, $tempGifPath)) {
                    $outputPath = $config['path']; // ini merujuk ke .../test.mp4
                    
                    // Hapus file target lama jika ada agar tidak bentrok
                    if (file_exists($outputPath)) {
                        unlink($outputPath);
                    }

                    // Command FFmpeg untuk konversi GIF ke MP4 (H.264 codec, format YUV420p agar universal kompatibel)
                    $shellCmd = sprintf(
    '%s -stream_loop -1 -i %s -t 6 -movflags faststart -pix_fmt yuv420p -vf "scale=trunc(iw/2)*2:trunc(ih/2)*2" %s 2>&1',
    escapeshellcmd($ffmpegPath),
    escapeshellarg($tempGifPath),
    escapeshellarg($outputPath)
);

                    exec($shellCmd, $outputLines, $returnCode);

                    // Hapus file mentahan GIF setelah proses selesai
                    if (file_exists($tempGifPath)) {
                        unlink($tempGifPath);
                    }

                    if ($returnCode === 0) {
                        chmod($outputPath, 0644);
                        $response['messages'][] = "Berkas GIF sukses dikonversi ke MP4 dan diperbarui.";
                    } else {
                        $response['success'] = false;
                        $response['messages'][] = "Gagal mengonversi GIF ke MP4 menggunakan FFmpeg.";
                    }
                } else {
                    $response['success'] = false;
                    $response['messages'][] = "Gagal memproses unggahan file GIF sementara.";
                }
            } else {
                // Alur proses unggahan file normal (bukan konversi GIF)
                if (move_uploaded_file($tmpPath, $config['path'])) {
                    chmod($config['path'], 0644);
                    $response['messages'][] = "Berkas [" . htmlspecialchars($inputName) . "] sukses diperbarui.";
                } else {
                    $response['success'] = false;
                    $response['messages'][] = "Gagal memindahkan file: " . htmlspecialchars($inputName);
                }
            }
        }
    }

    if (!$uploaded_any) {
        $response['success'] = false;
        $response['messages'][] = "Tidak ada berkas valid terpilih untuk diunggah.";
    }

    clearstatcache();
    foreach ($file_mapping as $inputName => $config) {
        $response['statuses'][$inputName] = getStatusIcon($config['path']);
    }

    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Portal BMKG</title>
    <style>
        :root {
            --primary-purple: #470e7a;
            --bg-canvas: #eef4f9;
            --slate-dark: #1e293b;
            --slate-muted: #64748b;
            --accent-blue: #0d6efd;
            --alert-green: #15803d;
            --alert-red: #b91c1c;
        }

        body {
            background: var(--bg-canvas);
            font-size: 16px;
            font-family: system-ui, -apple-system, sans-serif;
            margin: 0; padding: 0;
        }

        /* LOGIN SCREEN INTERFACE LAYOUT */
        .login-wrapper { display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-card {
            background: #ffffff; padding: 40px; border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 400px;
        }
        .login-card h2 { margin-top: 0; color: var(--slate-dark); font-size: 24px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; color: var(--slate-dark); }
        .form-group input {
            width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px;
            box-sizing: border-box; font-size: 15px; transition: border 0.2s;
        }
        .form-group input:focus { border-color: var(--accent-blue); outline: none; }
        .auth-btn {
            background: var(--accent-blue); color: #fff; border: none; width: 100%;
            padding: 12px; border-radius: 8px; font-size: 16px; font-weight: bold;
            cursor: pointer; transition: background 0.2s;
        }
        .auth-btn:hover { background: #0b5ed7; }
        .login-error-msg { background: #f8d7da; color: #842029; padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; text-align: center; }

        /* DASHBOARD WORKSPACE INTERFACE */
        .nav {
            position: fixed; top: 10px; left: 50%; transform: translateX(-50%);
            width: 92%; max-width: 820px; height: 50px; border-radius: 16px;
            background: rgba(71, 14, 122, 0.2); backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: space-around; z-index: 10;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .nav a { color: #111; font-size: 14px; text-decoration: none; padding: 8px 14px; font-weight: bold; }
        .nav a:hover { background: #fff; border-radius: 8px; }
        .nav a.logout-link { color: var(--alert-red); }

        #main { padding: 16px; max-width: 850px; margin: 90px auto 0 auto; }
        .upload-row {
            background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
        }
        .status-img { width: 70px; height: 50px; object-fit: contain; flex-shrink: 0; }
        .upload-info { flex: 1; min-width: 250px; }
        .upload-info label { display: block; font-weight: bold; margin-bottom: 5px; color: var(--slate-dark); }
        .upload-info span { font-size: 13px; color: var(--slate-muted); }
        .upload-info a { color: var(--accent-blue); text-decoration: none; }

        .remove-file-btn {
            background: none; border: none; color: var(--alert-red); 
            font-size: 13px; font-weight: bold; cursor: pointer; padding: 0; 
            text-decoration: underline; margin-left: 5px; transition: color 0.2s;
        }
        .remove-file-btn:hover { color: #7f1d1d; text-decoration: none; }

        .drop-zone {
            width: 370px; height: 55px; border: 2px dashed var(--accent-blue); border-radius: 8px;
            background: #f8fafc; display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 5px 10px; cursor: pointer; transition: all 0.2s; font-size: 14px;
        }
        .drop-zone:hover, .drop-zone--over { background: #f0f7ff; color: #0b5ed7; border-color: #0b5ed7; }
        .drop-zone input { display: none; }
        .file-loaded-text { font-weight: bold; color: var(--alert-green); word-break: break-all; }

        .submit-btn {
            color: #fff; background-color: var(--accent-blue); border: none;
            padding: 0.75rem 2rem; font-size: 1.1rem; border-radius: 50px; cursor: pointer;
            font-weight: bold; width: 100%; transition: background 0.2s; margin-top: 10px;
        }
        .submit-btn:hover { background-color: #0b5ed7; }
        .submit-btn:disabled { background-color: #a0aec0; cursor: not-allowed; }
        
        #log-container { margin: 20px 0; padding: 15px; border-radius: 8px; display: none; font-size: 14px; }
        .success-logs { background: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .error-logs { background: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
    </style>
</head>
<body>

<?php if (empty($_SESSION['authenticated'])): ?>
<div class="login-wrapper">
    <div class="login-card">
        <h2>Dashboard BMKG Login</h2>
        <?php if (!empty($login_error)): ?>
            <div class="login-error-msg"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" name="login_submit" class="auth-btn">Masuk</button>
        </form>
    </div>
</div>

<?php else: ?>
<div class="nav">
    <a href="https://stamar-ambon.bmkg.go.id/wp-content/File%20Upload.php">PD Upload</a>
    <a href="https://stamar-ambon.bmkg.go.id/wp-content/MFYUPLOAD/upload_page.php">MFY Upload</a>
    <a href="https://stamar-ambon.bmkg.go.id/wp-content/BahariUpload/upload.php">Bahari Upload</a>
    <a href="https://stamar-ambon.bmkg.go.id/wp-content/tools_selector.html">Tools</a>
    <a href="?action=logout" class="logout-link">Keluar (Logout)</a>
</div>

<div id="main">
    

    <form id="individualDropForm">
        <input type="hidden" id="dashboard_csrf" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        
        <div class="upload-row">
            <img class="status-img" data-input="fileToUpload1" src="<?php echo htmlspecialchars(getStatusIcon($file_mapping['fileToUpload1']['path'])); ?>" alt="status">
            <div class="upload-info">
                <label>Peringatan Dini 1harian (Infografis)</label>
                <span>Jika tidak ada PD, gambar dapat di screenshot <a href="nopd.html" target="_blank" rel="noopener">disini</a></span>
            </div>
            <div class="drop-zone">
                <span class="zone-prompt">Drop gambar disini / Klik</span>
                <input type="file" name="fileToUpload1" accept="image/png, image/jpeg">
            </div>
        </div>

        <div class="upload-row">
            <img class="status-img" data-input="fileToUpload2" src="<?php echo htmlspecialchars(getStatusIcon($file_mapping['fileToUpload2']['path'])); ?>" alt="status">
            <div class="upload-info">
                <label>Peringatan Dini 1harian (PDF)</label>
                <span>Jika tidak ada PD, download dokumen <a href="nopd.pdf" target="_blank" rel="noopener">disini</a></span>
            </div>
            <div class="drop-zone">
                <span class="zone-prompt">Drop PDF disini / Klik</span>
                <input type="file" name="fileToUpload2" accept="application/pdf">
            </div>
        </div>

        <div class="upload-row">
            <img class="status-img" data-input="fileToUpload3" src="<?php echo htmlspecialchars(getStatusIcon($file_mapping['fileToUpload3']['path'])); ?>" alt="status">
            <div class="upload-info">
                <label>Peringatan Dini 3 harian (Infografis)</label>
                <span>Jika tidak ada PD, gambar dapat di screenshot <a href="nopd.html" target="_blank" rel="noopener">disini</a></span>
            </div>
            <div class="drop-zone">
                <span class="zone-prompt">Drop gambar disini / Klik</span>
                <input type="file" name="fileToUpload3" accept="image/png, image/jpeg">
            </div>
        </div>
        
        <div class="upload-row">
    <img class="status-img" data-input="fileToUpload35" src="<?php echo htmlspecialchars(getStatusIcon($file_mapping['fileToUpload35']['path'])); ?>" alt="status">
    <div class="upload-info">
        <label>Peringatan Dini 3 harian (Infografis) (Gambar kedua)</label>
        
        <div id="status-container-35">
            <?php if (file_exists($file_mapping['fileToUpload35']['path'])): ?>
                <div style="margin-top: 5px; margin-bottom: 5px;">
                    <span style="color: var(--alert-green); font-weight: bold; background: #d1e7dd; padding: 2px 6px; border-radius: 4px;">
                        ?? File Tersedia di Server
                    </span>
                </div>
                <span style="color: var(--alert-red); font-weight: bold; display: block; margin-bottom: 5px;">
                    ?? PENTING: Jangan lupa hapus gambar ini jika peringatan dini tidak ada Gambar kedua!
                </span>
                <span>Aksi: <button type="button" class="remove-file-btn" onclick="handleFileRemoval('fileToUpload35')">Hapus Gambar Sekarang</button></span>
            <?php else: ?>
                <div style="margin-top: 5px;">
                    <span style="color: var(--slate-muted); font-weight: bold; background: #e2e8f0; padding: 2px 6px; border-radius: 4px;">
                        ? File Kosong (Tidak Ada)
                    </span>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
    <div class="drop-zone">
        <span class="zone-prompt">Drop gambar disini / Klik</span>
        <input type="file" name="fileToUpload35" accept="image/png, image/jpeg">
    </div>
</div>

        <div class="upload-row">
            <img class="status-img" data-input="fileToUpload4" src="<?php echo htmlspecialchars(getStatusIcon($file_mapping['fileToUpload4']['path'])); ?>" alt="status">
            <div class="upload-info">
                <label>Peringatan Dini 3 harian (PDF)</label>
                <span>Jika tidak ada PD, download dokumen <a href="nopd.pdf" target="_blank" rel="noopener">disini</a></span>
            </div>
            <div class="drop-zone">
                <span class="zone-prompt">Drop PDF disini / Klik</span>
                <input type="file" name="fileToUpload4" accept="application/pdf">
            </div>
        </div>

        <div class="upload-row">
            <img class="status-img" data-input="fileToUpload5" src="<?php echo htmlspecialchars(getStatusIcon($file_mapping['fileToUpload5']['path'])); ?>" alt="status">
            <div class="upload-info">
                <label>Peringatan Dini (GIF)</label>
                <span>Mendukung upload langsung file `` TIPE `.gif` (Otomatis diconvert ke MP4)</span>
            </div>
            <div class="drop-zone">
                <span class="zone-prompt">Drop GIF / Klik</span>
                <input type="file" name="fileToUpload5" accept="video/mp4, image/gif">
            </div>
        </div>
 <div id="log-container"></div>
        <button type="submit" class="submit-btn" id="submitBtn">Kirim Semua File Terpilih</button>
    </form>
    
   
</div>

<script>
    function handleFileRemoval(inputFieldName) {
        //if (!confirm("Apakah Anda ingin menghapus file gambar kedua dari server?")) {
        //    return;
        //}

        const logContainer = document.getElementById("log-container");
        const csrfToken = document.getElementById("dashboard_csrf").value;

        const removeData = new FormData();
        removeData.append("ajax_remove", "1");
        removeData.append("file_field", inputFieldName);
        removeData.append("csrf_token", csrfToken);

        fetch(window.location.href, {
            method: "POST",
            body: removeData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => {
            if (res.status === 401 || res.status === 403) {
                window.location.reload();
                throw new Error("Sesi login berakhir.");
            }
            if (!res.ok) throw new Error("Gagal menghubungi server.");
            return res.json();
        })
        .then(data => {
    logContainer.style.display = "block";
    logContainer.className = data.success ? "success-logs" : "error-logs";
    logContainer.innerHTML = `<strong>Status Penghapusan:</strong> ${escapeHTML(data.message)}`;

    if (data.success) {
        // UPDATE AJAX: Mengubah status teks menjadi Kosong secara Real-time
        const statusContainer = document.getElementById("status-container-35");
        if (statusContainer) {
            statusContainer.innerHTML = `
                <div style="margin-top: 5px;">
                    <span style="color: var(--slate-muted); font-weight: bold; background: #e2e8f0; padding: 2px 6px; border-radius: 4px;">
                        ? File Kosong (Tidak Ada)
                    </span>
                </div>`;
        }

        if (data.new_status) {
            const imgElement = document.querySelector(`.status-img[data-input="${inputFieldName}"]`);
            if (imgElement) {
                imgElement.src = data.new_status + "?t=" + new Date().getTime();
            }
        }
    }
})
        .catch(err => {
            logContainer.style.display = "block";
            logContainer.className = "error-logs";
            logContainer.innerHTML = `<strong>Terjadi Kendala:</strong> ${escapeHTML(err.message)}`;
        });
    }

    // Drag & Drop Interactions Loop
    document.querySelectorAll(".drop-zone").forEach(zone => {
        const input = zone.querySelector("input[type='file']");
        const prompt = zone.querySelector(".zone-prompt");

        zone.addEventListener("click", () => input.click());
        input.addEventListener("change", () => {
            if (input.files.length) updateZoneText(prompt, input.files[0].name);
        });

        ["dragenter", "dragover"].forEach(ev => {
            zone.addEventListener(ev, (e) => {
                e.preventDefault();
                zone.classList.add("drop-zone--over");
            });
        });

        ["dragleave", "drop"].forEach(ev => {
            zone.addEventListener(ev, () => zone.classList.remove("drop-zone--over"));
        });

        zone.addEventListener("drop", (e) => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                updateZoneText(prompt, e.dataTransfer.files[0].name);
            }
        });
    });

    function updateZoneText(promptElement, filename) {
        promptElement.innerHTML = `?? <span class="file-loaded-text">${escapeHTML(filename)}</span>`;
    }

    function escapeHTML(str) {
        return str.replace(/[&<>'"]/g, tag => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;' }[tag] || tag));
    }

    // Secure Document AJAX Submission Engine
    document.getElementById("individualDropForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById("submitBtn");
        const logContainer = document.getElementById("log-container");

        logContainer.style.display = "none";
        logContainer.className = "";
        submitBtn.disabled = true;
        submitBtn.innerText = "Sedang Mengunggah Dokumen...";

        const formData = new FormData(form);
        formData.append("ajax_upload", "1");

        fetch(window.location.href, {
            method: "POST",
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => {
            if (res.status === 401 || res.status === 403) {
                window.location.reload(); 
                throw new Error("Sesi login berakhir.");
            }
            if (!res.ok) throw new Error("Koneksi ke server terputus.");
            return res.json();
        })
        .then(data => {
            logContainer.style.display = "block";
            logContainer.classList.add(data.success ? "success-logs" : "error-logs");

            let logList = "<ul>";
            data.messages.forEach(msg => logList += `<li>${escapeHTML(msg)}</li>`);
            logList += "</ul>";
            logContainer.innerHTML = logList;

            if (data.statuses) {
                Object.keys(data.statuses).forEach(inputName => {
                    const imgElement = document.querySelector(`.status-img[data-input="${inputName}"]`);
                    if (imgElement) {
                        imgElement.src = data.statuses[inputName] + "?t=" + new Date().getTime();
                    }
                });
            }

            if (data.success) {
    
    
    // UPDATE AJAX: Jika fileToUpload35 ikut diunggah, ubah status teks secara Real-time
    const file35Input = document.querySelector("input[name='fileToUpload35']");
    if (file35Input && file35Input.files.length > 0) {
        const statusContainer = document.getElementById("status-container-35");
        if (statusContainer) {
            statusContainer.innerHTML = `
                <div style="margin-top: 5px; margin-bottom: 5px;">
                    <span style="color: var(--alert-green); font-weight: bold; background: #d1e7dd; padding: 2px 6px; border-radius: 4px;">
                        ?? File Tersedia di Server
                    </span>
                </div>
                <span style="color: var(--alert-red); font-weight: bold; display: block; margin-bottom: 5px;">
                    ?? PENTING: Jangan lupa hapus gambar ini jika peringatan dini tidak ada Gambar kedua!
                </span>
                <span>Aksi: <button type="button" class="remove-file-btn" onclick="handleFileRemoval('fileToUpload35')">Hapus Gambar Sekarang</button></span>`;
        }
    }
form.reset();
    document.querySelectorAll("input[type='file']").forEach(input => {
        const prompt = input.closest('.drop-zone').querySelector('.zone-prompt');
        if(input.accept.includes("pdf")) prompt.innerText = "Drop PDF disini / Klik";
        else if(input.accept.includes("gif")) prompt.innerText = "Drop GIF / Klik";
        else prompt.innerText = "Drop gambar disini / Klik";
    });
}
        })
        .catch(err => {
            logContainer.style.display = "block";
            logContainer.classList.add("error-logs");
            logContainer.innerHTML = `<strong>Terjadi Kendala:</strong> ${escapeHTML(err.message)}`;
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerText = "Kirim Semua File Terpilih";
        });
    });
</script>
<?php endif; ?>
</body>
</html>