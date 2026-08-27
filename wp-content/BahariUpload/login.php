<?php
session_start();

$error = "";

/* GANTI USERNAME & PASSWORD DI SINI */
$valid_user = "forecasterambon";
$valid_pass = "aksesterbatasstamarambon";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    if ($user === $valid_user && $pass === $valid_pass) {
        $_SESSION['logged_in'] = true;
        header("Location: upload.php");
        exit;
    } else {
        $error = "Invalid login credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body{font-family:arial;background:#f2f2f2}
.box{width:350px;margin:120px auto;padding:30px;background:#fff;border-radius:10px;box-shadow:0 0 10px #ccc}
input,button{width:100%;padding:12px;margin:8px 0}
button{background:#2b78e4;color:#fff;border:none}
.error{color:red;text-align:center}
</style>
</head>
<body>

<div class="box">
<h2 align="center">Admin Login</h2>
<form method="post">
<input type="text" name="username" required placeholder="Username">
<input type="password" name="password" required placeholder="Password">
<button type="submit">LOGIN</button>
</form>
<p class="error"><?= $error ?></p>
</div>

</body>
</html>
