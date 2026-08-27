<?php
//Menggabungkan dengan file koneksi yang telah kita buat
include 'koneksi.php';
include 'auth.php';
?>

<?php

error_reporting(0);
include_once 'te-starter/setting/database.php';

$id_member = $_SESSION['id_member'];

$nama_member = mysqli_query($koneksi, "SELECT nama_lengkap FROM member WHERE id_member='$id_member'");
$data=mysqli_fetch_array($nama_member);

?>

<?php  
if (isset($_SESSION["id_member"])) {	

}
else {
	header("location:http://stamar-ambon.bmkg.go.id/ptsp/te-starter");
}
?>

<?php  
if ($_SESSION["id_member"] == 8) {	

}
else {
	header("location:http://stamar-ambon.bmkg.go.id/ptsp/te-starter");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>PTSP STAMAR AMBON</title>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<link rel="stylesheet" href="progress bar.css">
<!-- Theme -->
	<link rel="stylesheet" href="offline/themes/offline-theme-chrome-indicator.css" />

	<!-- Language -->
	<link rel="stylesheet" href="offline/themes/offline-language-english.css" />

	<!-- JS -->
	<script type="text/javascript" src="offline/offline.min.js"></script>
</head>


<style>
:root {
  --color-white: #fff;
  --color-black: #333;
  --color-gray: #75787b;
  --color-gray-light: #bbb;
  --color-gray-disabled: #8d8d8d;
  --color-green: #53a318;
  --color-green-dark: #383;
  --font-size-small: .75rem;
  --font-size-default: .875rem;
}

* {
  box-sizing: border-box;
}

body {
  margin: 2rem;
  font-family: 'Open Sans', sans-serif;
  color: var(--color-black);
background-color: aliceblue;
}

h2 {
  color: var(--color-gray);
  font-size: var(--font-size-small);
  line-height: 1.5;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 3px;
}
section {
  margin-bottom: 2rem;
}

.none {
  display: none;
}

.btnstamarambon:hover {
  box-shadow: rgb(0 51 204 / 30%) 0px 5px 15px!important;
}

</style>


<body>

<!-- Add Student -->
<div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Permintaan Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="saveStudent">
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>

                <div class="mb-3">
                    <label for="">Format Informasi dan Jasa</label>
                    <input type="text" name="formatdata" class="form-control" placeholder="Contoh: Informasi Tinggi Gelombang"/>
                </div>
                <div class="mb-3">
                    <label for="">Lokasi Informasi dan Jasa</label>
                    <input type="text" name="lokasidata" class="form-control" placeholder="Contoh: Perairan Buru"/>
                </div>
                <div class="mb-3">
                    <label for="">Waktu Informasi dan Jasa</label>
                    <input type="text" name="waktudata" class="form-control" placeholder="Contoh: Januari 2023"/>
                </div>                
                <div class="mb-3">
                    <label for="">Tujuan Permintaan Informasi dan Jasa</label>
<select class="form-select" size="7" aria-label="size 3 select example" name="tujuandata" class="form-control" onchange="myFunction()" id="mySelect">
  <option selected>-</option>
  <option value="1">Penanggulangan Bencana</option>
  <option value="2">Klaim Asuransi</option>
  <option value="3">Pendidikan dan Penelitian Non-Komersial</option>
<option value="4">Non-komersial</option>
<option value="5">Komersial</option>
<option value="6">Lainnya</option>
</select>
                    
                </div>
<div id="additionalform">
                
</div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </form>

<script>
function myFunction() {
  
  let p = document.getElementById("mySelect").value;
 
  if (p === "3")
  {
  var el = document.getElementById("additionalform");
        if (el != null) {
  document.getElementById("additionalform").remove();
  }
  
  
var element = document.getElementsByClassName("modal-body");
var x = document.createElement("div");
  x.setAttribute("id", "additionalform");
  element[0].appendChild(x);
  
  
var x = document.createElement("div");
  x.setAttribute("class", "mb-3");
  document.getElementById("additionalform").appendChild(x);
  
  
var para = document.createElement("label");
var node = document.createTextNode("Foto KTP");
para.appendChild(node);
  para.setAttribute("for", "");
  document.getElementsByClassName("mb-3")[4].appendChild(para);
  

var x = document.createElement("input");
  x.setAttribute("type", "file");
  x.setAttribute("name", "gratisktp");
  x.setAttribute("class", "form-control");
  document.getElementsByClassName("mb-3")[4].appendChild(x);
  
  
var x = document.createElement("div");
  x.setAttribute("class", "mb-3");
  document.getElementById("additionalform").appendChild(x);
  
  
var para = document.createElement("label");
var node = document.createTextNode("Surat Pengantar dari Kampus/Instansi");
para.appendChild(node);
  para.setAttribute("for", "");
  document.getElementsByClassName("mb-3")[5].appendChild(para);
  

var x = document.createElement("input");
  x.setAttribute("type", "file");
  x.setAttribute("name", "gratissurat");
  x.setAttribute("class", "form-control");
  document.getElementsByClassName("mb-3")[5].appendChild(x);  
  
  
var x = document.createElement("div");
  x.setAttribute("class", "mb-3");
  document.getElementById("additionalform").appendChild(x);
  
  
var para = document.createElement("label");
var node = document.createTextNode("Proposal Penelitian yang telah disetujui oleh pembimbing");
para.appendChild(node);
  para.setAttribute("for", "");
  document.getElementsByClassName("mb-3")[6].appendChild(para);
  

var x = document.createElement("input");
  x.setAttribute("type", "file");
  x.setAttribute("name", "gratisproposal");
  x.setAttribute("class", "form-control");
  document.getElementsByClassName("mb-3")[6].appendChild(x);  
  
    
var x = document.createElement("div");
  x.setAttribute("class", "mb-3");
  document.getElementById("additionalform").appendChild(x);
  
  
var para = document.createElement("label");
var node = document.createTextNode("Surat Pernyataan tidak digunakan untuk kepentingan lain");
para.appendChild(node);
  para.setAttribute("for", "");
  document.getElementsByClassName("mb-3")[7].appendChild(para);
  

var x = document.createElement("input");
  x.setAttribute("type", "file");
  x.setAttribute("name", "gratispernyataan");
  x.setAttribute("class", "form-control");
  document.getElementsByClassName("mb-3")[7].appendChild(x);  
  
  
    
var x = document.createElement("div");
  x.setAttribute("class", "mb-3");
  document.getElementById("additionalform").appendChild(x);
  
  
var para = document.createElement("label");
var node = document.createTextNode("Surat Permohonan Tarif Nol Rupiah");
para.appendChild(node);
  para.setAttribute("for", "");
  document.getElementsByClassName("mb-3")[8].appendChild(para);
  

var x = document.createElement("input");
  x.setAttribute("type", "file");
  x.setAttribute("name", "gratispermohonan");
  x.setAttribute("class", "form-control");
  document.getElementsByClassName("mb-3")[8].appendChild(x);  
  
  
  
  }
  else if (p === "-"){
  var el = document.getElementById("additionalform");
        if (el != null) {
  document.getElementById("additionalform").remove();
  }
  
  
  }
  else {
  
  var el = document.getElementById("additionalform");
  
        if (el != null) {
  document.getElementById("additionalform").remove();
  }
  
  
var element = document.getElementsByClassName("modal-body");
var x = document.createElement("div");
  x.setAttribute("id", "additionalform");
  element[0].appendChild(x);
  
  
var x = document.createElement("div");
  x.setAttribute("class", "mb-3");
  document.getElementById("additionalform").appendChild(x);
  

var para = document.createElement("label");
var node = document.createTextNode("Kode Billing PNBP Dibuat oleh Stamar Ambon");
para.appendChild(node);
  para.setAttribute("for", "");
  document.getElementsByClassName("mb-3")[4].appendChild(para);  

var x = document.createElement("input");
  x.setAttribute("type", "checkbox");
  x.setAttribute("name", "buatpnbpsendiri");
  x.setAttribute("class", "form-check-input");
  document.getElementsByClassName("mb-3")[4].appendChild(x);
  
  
var x = document.createElement("div");
  x.setAttribute("class", "mb-3");
  document.getElementById("additionalform").appendChild(x);
  
  
var para = document.createElement("label");
var node = document.createTextNode("Foto KTP");
para.appendChild(node);
  para.setAttribute("for", "");
  document.getElementsByClassName("mb-3")[5].appendChild(para);
  

var x = document.createElement("input");
  x.setAttribute("type", "file");
  x.setAttribute("name", "pnbpktp");
  x.setAttribute("class", "form-control");
  document.getElementsByClassName("mb-3")[5].appendChild(x);
  
  
var x = document.createElement("div");
  x.setAttribute("class", "mb-3");
  document.getElementById("additionalform").appendChild(x);
  
  
var para = document.createElement("label");
var node = document.createTextNode("Surat Permintaan Informasi dan Jasa");
para.appendChild(node);
  para.setAttribute("for", "");
  document.getElementsByClassName("mb-3")[6].appendChild(para);
  

var x = document.createElement("input");
  x.setAttribute("type", "file");
  x.setAttribute("name", "pnbpsurat");
  x.setAttribute("class", "form-control");
  document.getElementsByClassName("mb-3")[6].appendChild(x);
  
  
 
}  
  
}
</script>


        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateStudent">
            <div class="modal-body">

                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                <input type="hidden" name="student_id" id="student_id" >

                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Email</label>
                    <input type="text" name="email" id="email" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Course</label>
                    <input type="text" name="course" id="course" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Student</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- View Student Modal1 -->
<div class="modal fade" id="studentViewModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Permintaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">Format Informasi dan Jasa</label>
                    <p id="view_name1" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Lokasi Informasi dan Jasa</label>
                    <p id="view_email1" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                
                <div class="mb-3">
                    <label for="">Waktu Informasi dan Jasa</label>
                    <p id="view_waktu1" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Tujuan Permintaan Informasi dan Jasa</label>
                    <p id="view_phone1" class="form-control"></p>
                </div>
<br>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#">
                            Unduh Dokumen Permintaan
                        </button>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View Student Modal2 -->
<div class="modal fade" id="studentViewModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Permintaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">Format Informasi dan Jasa</label>
                    <p id="view_name2" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Lokasi Informasi dan Jasa</label>
                    <p id="view_email2" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Waktu Informasi dan Jasa</label>
                    <p id="view_waktu2" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Tujuan Permintaan Informasi dan Jasa</label>
                    <p id="view_phone2" class="form-control"></p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#">
                            Unduh Dokumen Permintaan
                        </button>
                <label for="">Kode Billing PNBP/Kode Bayar:</label><p id="view_kodebilling2" class="form-control"> </p>
                <form id="saveStudent1">
            <div id="errorMessage1" class="alert alert-warning d-none"></div>
            <input type="hidden" name="student_id1" id="student_id1" >
            <div class="mb-3">
                    <label for="">Upload Bukti Bayar</label>
                    <input type="file" name="buktibayarpnbp" class="form-control">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Kirim Bukti Bayar</button>
            </div>
            
            </form>
        </div>
    </div>
</div>


<!-- View Student Modal3 -->
<div class="modal fade" id="studentViewModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Permintaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">Format Informasi dan Jasa</label>
                    <p id="view_name3" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Lokasi Informasi dan Jasa</label>
                    <p id="view_email3" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Waktu Informasi dan Jasa</label>
                    <p id="view_waktu3" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Tujuan Permintaan Informasi dan Jasa</label>
                    <p id="view_phone3" class="form-control"></p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#">
                            Unduh Dokumen Permintaan
                        </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View Student Modal4 -->
<div class="modal fade" id="studentViewModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Permintaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">Format Informasi dan Jasa</label>
                    <p id="view_name4" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Lokasi Informasi dan Jasa</label>
                    <p id="view_email4" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Waktu Informasi dan Jasa</label>
                    <p id="view_waktu4" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Tujuan Permintaan Informasi dan Jasa</label>
                    <p id="view_phone4" class="form-control"></p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#">
                            Unduh Dokumen Permintaan
                        </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View Student Modal5 -->
<div class="modal fade" id="studentViewModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Permintaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">Format Informasi dan Jasa</label>
                    <p id="view_name5" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Lokasi Informasi dan Jasa</label>
                    <p id="view_email5" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Waktu Informasi dan Jasa</label>
                    <p id="view_waktu5" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Tujuan Permintaan Informasi dan Jasa</label>
                    <p id="view_phone5" class="form-control"></p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#">
                            Unduh Dokumen Permintaan
                        </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View Student Modal6 -->
<div class="modal fade" id="studentViewModal6" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Permintaan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">Format Informasi dan Jasa</label>
                    <p id="view_name6" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Lokasi Informasi dan Jasa</label>
                    <p id="view_email6" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Waktu Informasi dan Jasa</label>
                    <p id="view_waktu6" class="form-control" style="
    overflow: auto;
"></p>
                </div>
                <div class="mb-3">
                    <label for="">Tujuan Permintaan Informasi dan Jasa</label>
                    <p id="view_phone6" class="form-control"></p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#">
                            Unduh Dokumen Permintaan
                        </button>
<br>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#">
                            Unduh Dokumen
                        </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4" >

<img src="https://stamar-ambon.bmkg.go.id/wp-content/uploads/2021/09/logo-bmkg-transparent3.png" alt="Stasiun Meteorologi Maritim Ambon – Informasi Cuaca Maritim Maluku" style="width: inherit;max-width: 484px;">
<br><br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="
    
    padding: 20px;
    border: none;
    border-radius: 24px;

">

<div class="card-header1" style="
    border-radius: 10px;
">
                    <h4>Halo, Admin <?php echo $data['nama_lengkap'];?><a href="logout.php"><button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#" style="
    background-color: darkgray;
    border-color: #dbdbdb;
">Log Out</button></a>
                    </h4>
                </div>
<br>
<br>

                <div class="card-header" style="
    border-radius: 14px;
">
                    <h4 style="
    margin-bottom: 0;
    line-height: 36px;
">Daftar Permintaan Informasi dan Jasa
                        
                        
                    </h4>
                </div>
                <br>
                <div class="card-body">

                    
                        
                    
                            <?php
                            require 'dbcon.php';
                            $query = "SELECT * FROM students  ORDER BY id DESC";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $student)
                                {
                                    ?>
 <?php
switch ($student['status']) {
  case "statuspermintaanditerima":
    $statusprogress = array("progress-bar2", "is-active", "", "", "", "Ketersediaan Informasi Terverifikasi"); 
    break;
  case "statusketersediaanterverfikasi":
    $statusprogress = array("progress-bar2", "is-complete", "is-active", "", "", "Ketersediaan Informasi Terverifikasi");
    break;
  case "statusketersediaantakterverifikasi":
    $statusprogress = array("progress-bar1", "is-complete", "is-active", "", "", "Ketersediaan Informasi Tak Terverifikasi");
    break;
  case "statuspembayaranditerima":
    $statusprogress = array("progress-bar2", "is-complete", "is-complete", "is-active", "", "Ketersediaan Informasi Terverifikasi");
    break;
  case "statuspermintaanselesai":
    $statusprogress = array("progress-bar2", "is-complete", "is-complete", "is-complete", "is-active", "Ketersediaan Informasi Terverifikasi");
    break;
  default:
    $statusprogress = "-";
}

switch ($student['biaya']) {
  case "biayagratis":
    $statusbiaya = "none"; 
    break;
  case "biayapnbp":
    $statusbiaya = "";
    break;
  default:
    $statusbiaya = "-";
}
?>                                   
                      <div id="<?=$student['id'];?>" class="view<?=$student['status'];?><?=$statusbiaya;?>Btn btn  btn-sm btnstamarambon" style="
    
    display: block;
    color: #000;
    background-color: #ffffff;
    
    border-color: #77787b;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 24px;
    padding: 15px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    ">

<ol class="<?=$statusprogress[0];?>">
    <li class="<?=$statusprogress[1];?>"><span>Permintaan Terkirim</span></li>  
    <li class="<?=$statusprogress[2];?>"><span><?=$statusprogress[5];?></span></li>  
    <li class="<?=$statusprogress[3];?> <?=$statusbiaya;?>"><span>Pembayaran Diterima</span></li>
    <li class="<?=$statusprogress[4];?>"><span>Permintaan Selesai</span></li></ol>
Order ID: <?=$student['id'];?>   </div>
                               


<br>        
                                       
                                    <?php
                                }
                            }

if(mysqli_num_rows($query_run) == 0)
{
?>
<div class="btn  btn-sm" style="
    
    display: block;
    color: #000;
    background-color: #ffffff;
    
    border:1px solid rgba(0,0,0,.125);
    border-radius: 24px;
    padding: 15px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    ">Belum Ada Permintaan Informasi dan Jasa   </div>
<?php
}
                            ?>
                            
                        

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
		Offline.options = {
		  	// Should we check the connection status immediatly on page load.
		  	checkOnLoad: false,

		  	// Should we monitor AJAX requests to help decide if we have a connection.
		  	interceptRequests: true,

		  	// Should we store and attempt to remake requests which fail while the connection is down.
		  	requests: true,

			// Change default file check
			// checks: {image: {url: 'makitweb-logo.png'}, active: 'image'},
			checks: {xhr: {url: 'checkconnection.php'}},
			
			// Should we show a snake game while the connection is down?
			// game: true
		}

		var run = function(){
		  	if (Offline.state === 'up')
		    	Offline.check();

		}
		setInterval(run, 5000);

	</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        $(document).on('submit', '#saveStudent', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_student", true);

            $.ajax({
                type: "POST",
                url: "admincode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                        $('#errorMessage').removeClass('d-none');
                        $('#errorMessage').text(res.message);

                    }else if(res.status == 200){

                        $('#errorMessage').addClass('d-none');
                        $('#studentAddModal').modal('hide');
                        $('#saveStudent')[0].reset();

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable').load(location.href + " #myTable");
function delay(time) {
  return new Promise(resolve => setTimeout(resolve, time));
}

delay(2000).then(() => location.reload());

                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                
		}
            });

        });
        
        
        $(document).on('submit', '#saveStudent1', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("save_student1", true);

            $.ajax({
                type: "POST",
                url: "admincode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                        $('#errorMessage1').removeClass('d-none');
                        $('#errorMessage1').text(res.message);

                    }else if(res.status == 200){

                        $('#errorMessage1').addClass('d-none');
                        $('#studentViewModal2').modal('hide');
                        $('#saveStudent1')[0].reset();

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);

                        $('#myTable').load(location.href + " #myTable");
function delay(time) {
  return new Promise(resolve => setTimeout(resolve, time));
}

delay(2000).then(() => location.reload());

                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                
		}
            });

        });

        $(document).on('click', '.editStudentBtn', function () {

            var student_id = $(this).val();
            
            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#student_id').val(res.data.id);
                        $('#name').val(res.data.name);
                        $('#email').val(res.data.email);
                        $('#phone').val(res.data.phone);
                        $('#course').val(res.data.course);

                        $('#studentEditModal').modal('show');
                    }

                }
            });

        });

        $(document).on('submit', '#updateStudent', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            formData.append("update_student", true);

            $.ajax({
                type: "POST",
                url: "admincode.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    
                    var res = jQuery.parseJSON(response);
                    if(res.status == 422) {
                        $('#errorMessageUpdate').removeClass('d-none');
                        $('#errorMessageUpdate').text(res.message);

                    }else if(res.status == 200){

                        $('#errorMessageUpdate').addClass('d-none');

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(res.message);
                        
                        $('#studentEditModal').modal('hide');
                        $('#updateStudent')[0].reset();

                        $('#myTable').load(location.href + " #myTable");

                    }else if(res.status == 500) {
                        alert(res.message);
                    }
                }
            });

        });

        $(document).on('click', '.viewstatuspermintaanditerimaBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name1').text(res.data.name);
                        $('#view_email1').text(res.data.email);
                        $('#view_waktu1').text(res.data.waktu);
                        $('#view_phone1').text(res.data.phone);
                        

                        $('#studentViewModal1').modal('show');
                    }
                }
            });
        });



$(document).on('click', '.viewstatuspermintaanditerimanoneBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name1').text(res.data.name);
                        $('#view_email1').text(res.data.email);
                        $('#view_waktu1').text(res.data.waktu);
                        $('#view_phone1').text(res.data.phone);
                        

                        $('#studentViewModal1').modal('show');
                    }
                }
            });
        });


        $(document).on('click', '.viewstatusketersediaanterverfikasiBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name2').text(res.data.name);
                        $('#view_email2').text(res.data.email);
                        $('#view_waktu2').text(res.data.waktu);
                        $('#view_phone2').text(res.data.phone);
                        $('#view_kodebilling2').text(res.data.kodebillingpnbp);
                        $('#student_id1').val(res.data.id);
                        

                        $('#studentViewModal2').modal('show');
                    }
                }
            });
        });

$(document).on('click', '.viewstatusketersediaanterverfikasinoneBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name3').text(res.data.name);
                        $('#view_email3').text(res.data.email);
                        $('#view_waktu3').text(res.data.waktu);
                        $('#view_phone3').text(res.data.phone);
                        
                        $('#studentViewModal3').modal('show');
                    }
                }
            });
        });


$(document).on('click', '.viewstatusketersediaantakterverifikasiBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name4').text(res.data.name);
                        $('#view_email4').text(res.data.email);
                        $('#view_waktu4').text(res.data.waktu);
                        $('#view_phone4').text(res.data.phone);
                        
                        $('#studentViewModal4').modal('show');
                    }
                }
            });
        });

$(document).on('click', '.viewstatusketersediaantakterverifikasinoneBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name4').text(res.data.name);
                        $('#view_email4').text(res.data.email);
                        $('#view_waktu4').text(res.data.waktu);
                        $('#view_phone4').text(res.data.phone);
                        

                        $('#studentViewModal4').modal('show');
                    }
                }
            });
        });


$(document).on('click', '.viewstatuspembayaranditerimaBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name5').text(res.data.name);
                        $('#view_email5').text(res.data.email);
                        $('#view_waktu5').text(res.data.waktu);
                        $('#view_phone5').text(res.data.phone);
                        

                        $('#studentViewModal5').modal('show');
                    }
                }
            });
        });

$(document).on('click', '.viewstatuspermintaanselesaiBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name6').text(res.data.name);
                        $('#view_email6').text(res.data.email);
                        $('#view_waktu6').text(res.data.waktu);
                        $('#view_phone6').text(res.data.phone);
                        

                        $('#studentViewModal6').modal('show');
                    }
                }
            });
        });

$(document).on('click', '.viewstatuspermintaanselesainoneBtn', function () {

            var student_id = $(this).prop("id");

            $.ajax({
                type: "GET",
                url: "admincode.php?student_id=" + student_id,
                success: function (response) {

                    var res = jQuery.parseJSON(response);
                    if(res.status == 404) {

                        alert(res.message);
                    }else if(res.status == 200){

                        $('#view_name6').text(res.data.name);
                        $('#view_email6').text(res.data.email);
                        $('#view_waktu6').text(res.data.waktu);
                        $('#view_phone6').text(res.data.phone);
                        $('#view_course6').text(res.data.course);

                        $('#studentViewModal6').modal('show');
                    }
                }
            });
        });


$(document).on('click', '.deleteStudentBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this data?'))
            {
                var student_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "admincode.php",
                    data: {
                        'delete_student': true,
                        'student_id': student_id
                    },
                    success: function (response) {

                        var res = jQuery.parseJSON(response);
                        if(res.status == 500) {

                            alert(res.message);
                        }else{
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(res.message);

                            $('#myTable').load(location.href + " #myTable");
                        }
                    }
                });
            }
        });

    </script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/64ba512594cf5d49dc64f84b/1h5rspusk';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>