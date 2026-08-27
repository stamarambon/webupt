<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'webadmin');
	define('DB_PASSWORD', 'stamarAMBON@))^@@');
	define('DB_DATABASE', 'dbbelajar');
	$koneksi = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
	$database = mysqli_select_db($koneksi, DB_DATABASE);
?>