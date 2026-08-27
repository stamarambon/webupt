<?php 
session_start();
include_once "setting/database.php";
include_once "setting/status_depan.php";




if(isset($_POST['submit_login'])) {


// Get the reCAPTCHA response token from the POST request.
$response_token = $_POST['g-recaptcha-response'];

// Get the secret key from Google.
$secret_key = '6LcCRIonAAAAAJyeYbiuXZxt6xOsnMZSSJfpTRQz';

// Make the API request to verify the response token.
$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $response_token;
$response = file_get_contents($url);

// Decode the JSON response.
$response = json_decode($response, true);

// Check if the response is successful.
if ($response['success'] === true) {
    $username_login=htmlentities((trim($_POST['username_login'])));
  $password_login=htmlentities(md5($_POST['password_login']));
  $seleksi = mysqli_query($koneksi, "SELECT id_member FROM member WHERE username = '$username_login' and password='$password_login'");
  $data_member = mysqli_fetch_array($seleksi);
  $jumlah_baris = mysqli_num_rows($seleksi);
	if ($jumlah_baris == 1){
		$_SESSION['id_member'] = $data_member['id_member'];
		header("location: ../");
  }
	else{
	?>
	  <script language="javascript">
			alert("Maaf, Username atau Password Anda salah..");
			document.location="";
		</script>
  <?php  
	}  
    
    
} else if ($response['success'] === false){
    ?>
	  <script language="javascript">
			alert("Maaf, Verifikasi Captcha belum ada");
			document.location="";
		</script>
  <?php 
}

  
	
}


?>




<!DOCTYPE html>
<html lang="en" >
  <head>
<script type="text/javascript" src="js/daftar.js"></script>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Login PTSP</title>
    <!-- Favicon -->
    <link
      rel="icon"
      href="https://stamar-ambon.bmkg.go.id/wp-content/uploads/2021/09/logo-bmkg-Copy.png"
      type="image/x-icon" />
    <!-- Roboto font -->
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
      rel="stylesheet" />
    <!-- Tailwind -->
    
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          fontFamily: {
            sans: ["Roboto", "sans-serif"],
            body: ["Roboto", "sans-serif"],
            mono: ["ui-monospace", "monospace"],
          },
        },
        corePlugins: {
          preflight: false,
        },
      };
    </script>
    <!-- Tailwind Elements CSS -->
    <link rel="stylesheet" href="css/tw-elements.min.css" />
    <!-- Custom styles -->
    <style>
@media screen and (max-width: 500px) {
  
            #accorddionExample5 {
                width: 70%;
            }
</style>
  </head>

  <body class="bg-white">
    <!-- Start your project here-->

<div class="wrapper" style="
    max-width: 1140px;
    margin: auto;

">

  

<section class="">
  <div class="container h-full px-6 py-24" style="
    margin: auto;
">
    <div
      class="g-6 flex h-full flex-wrap items-center justify-center lg:justify-between">
      <!-- Left column container with background-->
      <div class="mb-12 md:mb-0 md:w-8/12 lg:w-6/12">
        <img
          src="simpel logo.png"
          class="w-full"
          alt="Phone image" />
      </div>

      <!-- Right column container with form -->
      <div class="md:w-8/12 lg:ml-6 lg:w-5/12">
<h2 class="text-4xl font-medium leading-tight" style="font-size: 28px;">
  
  <span
    class="inline-block whitespace-nowrap rounded-[0.27rem] bg-primary-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-primary-700"
    >LOGIN UPT PTSP STAMAR AMBON</span
  >
</h2>
<BR>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <form id="formlogin" method="post">
          <!-- Email input -->

          <select data-te-select-init data-te-select-filter="true" id="username_login" name="username_login">
  <option value="1">Stasiun Geofisika Kelas I Karang Panjang - Ambon</option>
  <option value="2">Stasiun Meteorologi Kelas II Pattimura - Ambon</option>
  <option value="3">Stasiun Meteorologi Kelas III Namlea - Buru</option>
  <option value="4">Stasiun Geofisika Kelas III Saumlaki - Maluku Tenggara Barat</option>
  <option value="5">Stasiun Meteorologi Kelas III Mathilda Batlayeri - Maluku Tenggara Barat</option>
  <option value="6">Stasiun Meteorologi Kelas III Amahai - Maluku Tengah</option>
  <option value="7">Stasiun Meteorologi Kelas III Geser - Seram Bagian Timur</option>
  <option value="8">Stasiun Meteorologi Kelas III Bandaneira - Maluku Tengah</option>
  <option value="9">Stasiun Meteorologi Kelas III Dumatubun - Tual</option>
  <option value="10">Stasiun Klimatologi Kelas III Seram Bagian Barat</option>
</select>
<br>
          <!-- Password input -->
          <div class="relative mb-6" data-te-input-wrapper-init>
            <input
              type="password"
              class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
              id="password_login" name="password_login"
              placeholder="Password" />
            <label
              for="exampleFormControlInput33"
              class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
              >Password
            </label>
          </div>
<div class="g-recaptcha" data-sitekey="6LcCRIonAAAAAACErNYXvZOzMZN50GV4FdTwwrza"></div>
<br/>
          <!-- Remember me checkbox -->
          <div class="mb-6 flex items-center justify-between" style="
    display: none;
">
            <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
              <input
                class="relative float-left -ml-[1.5rem] mr-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent dark:border-neutral-600 dark:checked:border-primary dark:checked:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                type="checkbox"
                value=""
                id="exampleCheck3"
                checked />
              <label
                class="inline-block pl-[0.15rem] hover:cursor-pointer"
                for="exampleCheck3">
                Remember me
              </label>
            </div>

            <!-- Forgot password link -->
            <a
              href="#!"
              class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600"
              >Forgot password?</a
            >
          </div>

          <!-- Submit button -->
          <button
            type="submit"
            class="inline-block w-full rounded bg-primary px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
            data-te-ripple-init
            data-te-ripple-color="light" id="submit_login" name="submit_login">
            Sign in
          </button>

          <!-- Divider -->
          <div
            class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-neutral-300 after:mt-0.5 after:flex-1 after:border-t after:border-neutral-300" style="
    display: none;
">
            <p
              class="mx-4 mb-0 text-center font-semibold dark:text-neutral-200">
              OR
            </p>
          </div>

          <!-- Social login buttons -->
          <a
            class="mb-3 flex w-full items-center justify-center rounded bg-primary px-7 pb-2.5 pt-3 text-center text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
            style="display: none;background-color: #3b5998"
            href="#!"
            role="button"
            data-te-ripple-init
            data-te-ripple-color="light">
            <!-- Facebook -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="mr-2 h-3.5 w-3.5"
              fill="currentColor"
              viewBox="0 0 24 24">
              <path
                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
            </svg>
            Continue with Facebook
          </a>
          <a
            class="mb-3 flex w-full items-center justify-center rounded bg-info px-7 pb-2.5 pt-3 text-center text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#54b4d3] transition duration-150 ease-in-out hover:bg-info-600 hover:shadow-[0_8px_9px_-4px_rgba(84,180,211,0.3),0_4px_18px_0_rgba(84,180,211,0.2)] focus:bg-info-600 focus:shadow-[0_8px_9px_-4px_rgba(84,180,211,0.3),0_4px_18px_0_rgba(84,180,211,0.2)] focus:outline-none focus:ring-0 active:bg-info-700 active:shadow-[0_8px_9px_-4px_rgba(84,180,211,0.3),0_4px_18px_0_rgba(84,180,211,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(84,180,211,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(84,180,211,0.2),0_4px_18px_0_rgba(84,180,211,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(84,180,211,0.2),0_4px_18px_0_rgba(84,180,211,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(84,180,211,0.2),0_4px_18px_0_rgba(84,180,211,0.1)]"
            style="display: none;background-color: #55acee"
            href="#!"
            role="button"
            data-te-ripple-init
            data-te-ripple-color="light">
            <!-- Twitter -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="mr-2 h-3.5 w-3.5"
              fill="currentColor"
              viewBox="0 0 24 24">
              <path
                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
            </svg>
            Continue with Twitter
          </a>
        </form>
      </div>
    </div>
  </div>
</section>



    </div>
  </body>
  <!-- Tailwind Elements JS -->
  <script type="text/javascript" src="js/tw-elements.umd.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript"></script>
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
</html>
