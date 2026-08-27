<?php
//Menggabungkan dengan file koneksi yang telah kita buat
include 'koneksi.php';
include 'auth.php';
?>

<?php

error_reporting(0);
include_once 'te-starter/setting/database.php';
include_once 'te-starter/setting/status_session.php';
$id_member = $_SESSION['id_member'];

$nama_member = mysqli_query($koneksi, "SELECT nama_lengkap FROM member WHERE id_member='$id_member'");
$data=mysqli_fetch_array($nama_member);

?>

<?php

require 'dbcon.php';




if(isset($_POST['save_student']))
{
$t=time();   

if (isset($_FILES["pnbpktp"]) && !empty($_FILES["pnbpktp"]["name"])) {
        $file_name = $_FILES["pnbpktp"]["name"];
        $file_tmp = $_FILES["pnbpktp"]["tmp_name"];

        // Move the first temporary file to a permanent location
        $destination1 = "te-starter/securedfile/" . $t . $file_name;
        move_uploaded_file($file_tmp, $destination1);
    }

if (isset($_FILES["pnbpsurat"]) && !empty($_FILES["pnbpsurat"]["name"])) {
        $file_name = $_FILES["pnbpsurat"]["name"];
        $file_tmp = $_FILES["pnbpsurat"]["tmp_name"];

        // Move the second temporary file to a permanent location
        $destination2 = "te-starter/securedfile/" . $t . $file_name;
        move_uploaded_file($file_tmp, $destination2);
    }

if (isset($_FILES["gratisktp"]) && !empty($_FILES["gratisktp"]["name"])) {
        $file_name = $_FILES["gratisktp"]["name"];
        $file_tmp = $_FILES["gratisktp"]["tmp_name"];

        // Move the first temporary file to a permanent location
        $destination3 = "te-starter/securedfile/" . $t . $file_name;
        move_uploaded_file($file_tmp, $destination3);
    }

if (isset($_FILES["gratissurat"]) && !empty($_FILES["gratissurat"]["name"])) {
        $file_name = $_FILES["gratissurat"]["name"];
        $file_tmp = $_FILES["gratissurat"]["tmp_name"];

        // Move the second temporary file to a permanent location
        $destination4 = "te-starter/securedfile/" . $t . $file_name;
        move_uploaded_file($file_tmp, $destination4);
    }

if (isset($_FILES["gratisproposal"]) && !empty($_FILES["gratisproposal"]["name"])) {
        $file_name = $_FILES["gratisproposal"]["name"];
        $file_tmp = $_FILES["gratisproposal"]["tmp_name"];

        // Move the first temporary file to a permanent location
        $destination5 = "te-starter/securedfile/" . $t . $file_name;
        move_uploaded_file($file_tmp, $destination5);
    }

if (isset($_FILES["gratispernyataan"]) && !empty($_FILES["gratispernyataan"]["name"])) {
        $file_name = $_FILES["gratispernyataan"]["name"];
        $file_tmp = $_FILES["gratispernyataan"]["tmp_name"];

        // Move the second temporary file to a permanent location
        $destination6 = "te-starter/securedfile/" . $t . $file_name;
        move_uploaded_file($file_tmp, $destination6);
    }

if (isset($_FILES["gratispermohonan"]) && !empty($_FILES["gratispermohonan"]["name"])) {
        $file_name = $_FILES["gratispermohonan"]["name"];
        $file_tmp = $_FILES["gratispermohonan"]["tmp_name"];

        // Move the first temporary file to a permanent location
        $destination7 = "te-starter/securedfile/" . $t . $file_name;
        move_uploaded_file($file_tmp, $destination7);
    }

    $name = mysqli_real_escape_string($con, $_POST['formatdata']);
    $email = mysqli_real_escape_string($con, $_POST['lokasidata']);
    $waktu = mysqli_real_escape_string($con, $_POST['waktudata']);
    $phone = mysqli_real_escape_string($con, $_POST['tujuandata']);
switch ($phone) {
  case "1":
    $phone = "Penanggulangan Bencana";
    break;
  case "2":
    $phone = "Klaim Asuransi";
    break;
  case "3":
    $phone = "Pendidikan dan Penelitian Non-Komersial";
    break;
  case "4":
    $phone = "Non-Komersial";
    break;
  case "5":
    $phone = "Komersial";
    break;
  case "6":
    $phone = "Lainnya";
    break;
  default:
    $phone = "-";
}

if ($phone != "Pendidikan dan Penelitian Non-Komersial")
{
$statusbiaya = "biayapnbp";
}
else
{
$statusbiaya = "biayagratis";
}

    $course = $data['nama_lengkap'];

    if($name == NULL || $email == NULL || $waktu == NULL || $phone == NULL || $phone == "-" || $course == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Semua Field wajib diisi'
        ];
        echo json_encode($res);
        return;
    }

    $query = "INSERT INTO `students` (name,email,waktu,phone,course,pnbpktp,pnbpsurat,gratisktp,gratissurat,gratisproposal,gratispernyataan,gratispermohonan,status,biaya,kodebillingpnbp,hasildata,buktibayarpnbp) VALUES ('$name','$email','$waktu','$phone','$course', '$destination1', '$destination2', '$destination3', '$destination4', '$destination5', '$destination6', '$destination7', 'statuspermintaanditerima', '$statusbiaya', '', '', '')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Order Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Order Not Created'
        ];
        echo json_encode($res);
        return;
    }
}



if(isset($_POST['save_student1']))
{


$student_id = mysqli_real_escape_string($con, $_POST['student_id1']);

    $query = "SELECT course FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($con, $query);
    $datauntukget=mysqli_fetch_array($query_run);

    if($data['nama_lengkap'] != $datauntukget['course'])
    {

$res = [
            'status' => 422,
            'message' => 'order not found'
        ];
        echo json_encode($res);
        return;
}


if (isset($_FILES["buktibayarpnbp"]) && !empty($_FILES["buktibayarpnbp"]["name"])) {
        $file_name = $_FILES["buktibayarpnbp"]["name"];
        $file_tmp = $_FILES["buktibayarpnbp"]["tmp_name"];

        // Move the first temporary file to a permanent location
        $destination8 = "te-starter/securedfile/" . $file_name;
        move_uploaded_file($file_tmp, $destination8);
    }



    if($destination8 == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'Semua Field wajib diisi'
        ];
        echo json_encode($res);
        return;
    }
    
    
   
   $query = "UPDATE students SET buktibayarpnbp='$destination8' WHERE id='$student_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Uploaded Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Bukti Bayar Not Uploaded'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_POST['update_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $course = mysqli_real_escape_string($con, $_POST['course']);

    if($name == NULL || $email == NULL || $phone == NULL || $course == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE students SET name='$name', email='$email', phone='$phone', course='$course' 
                WHERE id='$student_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Student Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['student_id']))
{
    $student_id = mysqli_real_escape_string($con, $_GET['student_id']);

    $query = "SELECT course FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($con, $query);
    $datauntukget=mysqli_fetch_array($query_run);

    if($data['nama_lengkap'] == "sembarang")
    {

$res = [
            'status' => 404,
            'message' => 'order not found'
        ];
        echo json_encode($res);
        return;
}

    $query = "SELECT * FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $student = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Order Fetch Successfully by id',
            'data' => $student
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Order Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);

    $query = "DELETE FROM students WHERE id='$student_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Student Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>