<?php
session_start();

if(!isset($_SESSION['logged_in'])){
    header("Location: login.php");
    exit;
}

$folder = "../../content/Prakiraan_Wisata_Bahari_BMKG_Maluku/gambar/";
if(!is_dir($folder)){
    die("Folder tidak ditemukan: " . $folder);
}

/* DELETE FILE */
if(isset($_GET['delete'])){
    $file = basename($_GET['delete']);
    $path = $folder.$file;
    if(file_exists($path)){
        unlink($path);
    }
    header("Location: upload.php");
    exit;
}

/* UPLOAD FILES */
if(isset($_FILES['files'])){
    foreach ($_FILES['files']['name'] as $i => $name) {

        $tmp = $_FILES['files']['tmp_name'][$i];
        $size = $_FILES['files']['size'][$i];
        $error = $_FILES['files']['error'][$i];

        if($error == 0){
            if($size > 10*1024*1024) continue; // Max 10MB
            $safeName = preg_replace("/[^A-Z0-9._-]/i", "_", $name);
            $safeName = strtolower($safeName);
            move_uploaded_file($tmp, $folder.$safeName);
        }
    }
    exit;
}

/* LIST FILES */
$files = array_diff(scandir($folder), array('.', '..'));
?>
<!DOCTYPE html>
<html>
<head>
<title>Upload Files</title>
<style>
body{font-family:arial;background:#f2f2f2;padding:20px}
h2{text-align:center}
.drop-zone{
    border:3px dashed #2b78e4;
    padding:40px;
    text-align:center;
    background:#fff;
    cursor:pointer;
}
.progress{width:100%;background:#ddd;margin-top:10px}
.bar{width:0;height:20px;background:#2b78e4}

.preview{display:flex;flex-wrap:wrap;margin-top:20px}
.card{
    background:white;
    padding:10px;
    margin:10px;
    border-radius:8px;
    width:150px;
    box-shadow:0 0 5px #ccc;
}
img{width:100%;height:120px;object-fit:cover}
a{color:red;text-decoration:none;font-size:12px}
button.logout{
    float:right;
    background:red;
    border:0;
    color:white;
    padding:8px 14px;
}



.nav {
  position: fixed;
  top: 10;
  left: 50%;
  transform: translateX(-50%);
  width: 92%;
  max-width: 820px;
  height: 50px;
  border-radius: 16px;
  background: #470e7a3b;
  
  box-shadow: 0 2px 10px rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: space-around;
  overflow: hidden;
}



@keyframes shine {
  0% { transform: translateX(-30%) translateY(-30%); }
  50% { transform: translateX(30%) translateY(30%); }
  100% { transform: translateX(-30%) translateY(-30%); }
}

.nav a {
  color: #111;
  font-size: 15px;
  text-decoration: none;
  padding: 8px 18px;
  border-radius: 8px;
  transition: 0.18s ease;
  font-weight: 500;: 0.25s ease;
  font-weight: bold;
  opacity: 0.9;: 0.25s ease;
}

.nav a:hover {
  background: #ffffff;
  box-shadow: inset 0 0 0 1px #333;
}



@keyframes glow {
  0% { transform: scale(1) rotate(0deg); opacity: 0.4; }
  100% { transform: scale(1.3) rotate(25deg); opacity: 0.75; }
}

.nav a.active {
  background: rgba(255,255,255,0.25);
  box-shadow: 0 0 12px rgba(255,255,255,0.4);
}

.nav a {
  letter-spacing: 0.5px;
  position: relative;
}

.nav a:hover::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -3px;
  width: 100%;
  height: 2px;
  background: #470e7a;
  animation: underline 0.5s forwards;
}

@keyframes underline {
  from { width: 0%; }
  to { width: 100%; }
}
</style>
</head>
<body>

<div class="nav">
  <a href="https://stamar-ambon.bmkg.go.id/wp-content/File%20Upload.php">PD Upload</a>
  <a href="https://stamar-ambon.bmkg.go.id/wp-content/MFYUPLOAD/upload_page.php">MFY Upload</a>
  <a href="https://stamar-ambon.bmkg.go.id/wp-content/BahariUpload/upload.php">Bahari Upload</a>
  <a href="https://stamar-ambon.bmkg.go.id/wp-content/tools_selector.html">Tools</a>
</div>

<br>
<br>
<br>
<br>
<form action="logout.php" method="post">
<button class="logout">Logout</button>
</form>

<h2>Wisata Bahari Upload Page</h2>

<div class="drop-zone" id="drop">
<h3>Drop gambar PNG  here or click  (gambar png bukan jpg)</h3>
<input type="file" id="fileInput" multiple hidden>
</div>

<div class="progress">
<div class="bar" id="bar"></div>
</div>

<div class="preview" id="preview"></div>

<h2>Files in folder Wisata Bahari</h2>
<div class="preview">
<?php foreach($files as $f): ?>
<div class="card">
<?php if(preg_match('/jpg|jpeg|png|gif/i',$f)): ?>
<img src="<?= $folder.$f ?>">
<?php else: ?>
<p><?= $f ?></p>
<?php endif; ?>
<a href="?delete=<?= $f ?>" onclick="return confirm('Delete file?');">DELETE</a>
</div>
<?php endforeach; ?>
</div>

<script>
const drop = document.getElementById('drop');
const input = document.getElementById('fileInput');
const bar = document.getElementById('bar');
const preview = document.getElementById('preview');

drop.onclick = ()=> input.click();

drop.ondragover = (e)=>{
    e.preventDefault();
    drop.style.background="#e7f0ff";
}
drop.ondragleave = ()=> drop.style.background="#fff";
drop.ondrop = (e)=>{
    e.preventDefault();
    upload(e.dataTransfer.files);
}

input.onchange = ()=> upload(input.files);

function upload(files){

    preview.innerHTML = "";
    let formData = new FormData();

    for(let i=0;i<files.length;i++){
        formData.append("files[]", files[i]);

        let div = document.createElement("div");
        div.className="card";
        if(files[i].type.includes("image")){
            let img = document.createElement("img");
            img.src = URL.createObjectURL(files[i]);
            div.appendChild(img);
        } else {
            div.innerHTML = "<p>"+files[i].name+"</p>";
        }
        preview.appendChild(div);
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST","",true);

    xhr.upload.onprogress = function(e){
        if(e.lengthComputable){
            let percent = (e.loaded/e.total)*100;
            bar.style.width = percent + "%";
        }
    }

    xhr.onload = function(){
        bar.style.width="0%";
        location.reload();
    }

    xhr.send(formData);
}
</script>

</body>
</html>
