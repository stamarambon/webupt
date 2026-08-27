<?php
session_start();

// --- CONFIGURATION ---
$admin_user = "forecasterambon";
$password = "aksesterbatasstamarambon"; // CHANGE THIS
$uploadDir  = 'uploads/';
$outputDir  = 'converted/';
$ffmpegPath = 'ffmpeg'; 
$maxFileSize = 5 * 1024 * 1024; // 5MB

// --- AUTHENTICATION LOGIC ---
if (isset($_POST['login'])) {
    
    if ($_POST['auth_user'] === $admin_user && $_POST['auth_pass'] === $password) {
        $_SESSION['authenticated'] = true;
    } else {
        $error = "Invalid username or password.";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$isAuthenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;


// --- FILE PROCESSING ---
$message = "";
$downloadLink = "";
$statusType = "info"; 

if ($isAuthenticated) {
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    if (!is_dir($outputDir)) mkdir($outputDir, 0755, true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['gif_file'])) {
        $file = $_FILES['gif_file'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $detectedType = $finfo->file($file['tmp_name']);

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $message = "Upload failed.";
            $statusType = "error";
        } elseif ($file['size'] > $maxFileSize) {
            $message = "File too large (Max 5MB).";
            $statusType = "error";
        } elseif ($detectedType !== 'image/gif') {
            $message = "Only GIF files allowed.";
            $statusType = "error";
        } else {
            $safeName = bin2hex(random_bytes(10)); 
            $targetGif = $uploadDir . $safeName . '.gif';
            $outputMp4 = $outputDir . $safeName . '.mp4';

            if (move_uploaded_file($file['tmp_name'], $targetGif)) {
                $cmd = sprintf(
                    "%s -ignore_loop 0 -i %s -t 7 -pix_fmt yuv420p -vf \"scale=trunc(iw/2)*2:trunc(ih/2)*2\" -y %s 2>&1",
                    escapeshellcmd($ffmpegPath),
                    escapeshellarg($targetGif),
                    escapeshellarg($outputMp4)
                );
                exec($cmd, $output, $returnCode);

                if ($returnCode === 0) {
                    $message = "Conversion successful!";
                    $statusType = "success";
                    $downloadLink = $outputMp4;
                } else {
                    $message = "FFmpeg processing error.";
                    $statusType = "error";
                }
            }
        }
    }

    if (isset($_POST['delete_all'])) {
        array_map('unlink', array_merge(glob($uploadDir . "*"), glob($outputDir . "*")));
        $message = "All files purged.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GiffyConvert Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: white; border-radius: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); width: 100%; max-width: 440px; padding: 40px; }
        .loader { border: 3px solid #f1f5f9; border-top: 3px solid #6366f1; animation: spin 1s linear infinite; border-radius: 50%; width: 24px; height: 24px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        video { border-radius: 1rem; width: 100%; background: #000; margin-bottom: 1.5rem; }
    </style>
</head>
<body>

<div class="card">
    <?php if (!$isAuthenticated): ?>
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Access Locked</h1>
            <p class="text-slate-500 text-sm mt-1">Provide credentials to use the converter</p>
        </div>
        <form action="" method="POST" class="space-y-4">
        <input type="text" name="auth_user" placeholder="Username" required class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
            <input type="password" name="auth_pass" placeholder="Enter Password" class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all text-center">
            <button type="submit" name="login" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">Unlock System</button>
            <?php if (isset($error)): ?><p class="text-rose-500 text-xs text-center font-bold"><?php echo $error; ?></p><?php endif; ?>
        </form>

    <?php else: ?>
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight italic">GiffyConvert</h1>
            <a href="?logout=1" class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-[10px] font-bold uppercase hover:bg-rose-50 hover:text-rose-500 transition-all">Logout</a>
        </header>

        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-2xl text-[11px] font-bold border <?php echo $statusType === 'success' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'bg-rose-50 border-rose-100 text-rose-600'; ?>">
                <?php echo strtoupper($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($downloadLink): ?>
            <div class="animate-in fade-in zoom-in duration-300">
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1 tracking-widest">6second Loop Preview</p>
                <video autoplay loop muted playsinline controls>
                    <source src="<?php echo $downloadLink; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <a href="<?php echo $downloadLink; ?>" download class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-bold py-4 rounded-2xl flex items-center justify-center gap-3 transition-all mb-8 shadow-xl shadow-slate-200">
                    Download Video
                </a>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
    <div class="group border-2 border-dashed border-slate-200 rounded-3xl p-10 text-center hover:border-indigo-400 hover:bg-indigo-50/50 transition-all cursor-pointer mb-8" 
         onclick="document.getElementById('gif_file').click()"
         ondragover="handleDragOver(event)" 
         ondragleave="handleDragLeave(event)" 
         ondrop="handleDrop(event)">
        
        <input type="file" name="gif_file" id="gif_file" accept=".gif" class="hidden" onchange="handleFileSelect(this)">
        
        <div id="upload-prompt">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <p class="text-slate-700 font-bold text-sm tracking-tight">Convert New GIF</p>
            <p class="text-slate-400 text-[10px] mt-1">Upload or Drag & Drop verified GIF up to 5MB</p>
        </div>

        <div id="loading-state" class="hidden flex flex-col items-center py-2">
            <div class="loader mb-4"></div>
            <p class="text-indigo-600 font-bold text-[10px] uppercase tracking-widest">Converting Stream...</p>
        </div>
    </div>
</form>

        <form action="" method="POST" onsubmit="return confirm('Purge all server cache?');">
            <button type="submit" name="delete_all" class="w-full text-slate-300 hover:text-rose-500 text-[10px] font-bold uppercase tracking-[0.3em] transition-colors">
                Purge Storage
            </button>
        </form>
    <?php endif; ?>
</div>

<script>
    function showLoading() {
        const prompt = document.getElementById('upload-prompt');
        const loader = document.getElementById('loading-state');
        if(prompt && loader) {
            prompt.classList.add('hidden');
            loader.classList.remove('hidden');
        }
    }
    const form = document.getElementById('uploadForm');
    const fileInput = document.getElementById('gif_file');

    function handleDragOver(e) {
        e.preventDefault();
        e.currentTarget.classList.add('border-indigo-400', 'bg-indigo-50/50');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        e.currentTarget.classList.remove('border-indigo-400', 'bg-indigo-50/50');
    }

    function handleDrop(e) {
        e.preventDefault();
        e.currentTarget.classList.remove('border-indigo-400', 'bg-indigo-50/50');
        
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files; // Assign dropped file to input
            handleFileSelect(fileInput);
        }
    }

    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            showLoading();
            form.submit();
        }
    }

    function showLoading() {
        document.getElementById('upload-prompt').classList.add('hidden');
        document.getElementById('loading-state').classList.remove('hidden');
    }
</script>

</body>
</html>
