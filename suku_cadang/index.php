<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Monitoring Peralatan Stamar Amon</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/BMKG.svg" rel="icon">
  <link href="assets/img/BMKG.svg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Leaflet CSS and JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <!-- Leaflet MarkerCluster CSS and JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.0/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.0/dist/MarkerCluster.Default.css" />
  <script src="https://unpkg.com/leaflet.markercluster@1.5.0/dist/leaflet.markercluster.js"></script>


  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    
/* CSS untuk memusatkan konten di setiap swiper slide */
.testimonials-slider .swiper-slide {
  display: flex;
  justify-content: center;
  align-items: center;
}

.iframe-wrapper {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 aspect ratio */
  height: 0;
}

/* Gaya untuk iframe agar responsif dan full layar */
.responsive-iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.logo {
  /* Set tata letak flex untuk mengatur logo dan teks berdampingan */
  display: flex;
}

.logo h1 {
  /* Margin kiri untuk memisahkan logo dan teks */
  margin-left: 15px;
}

.font-weight-bold {
  font-weight: bold;
}

#hero .container {
  background-color: rgba(0, 0, 0, 0.6); /* Atur transparansi latar belakang */
  padding: 20px;
  border-radius: 10px;
  color: white;
}

.services .img-fluid {
    max-width: 100%;
    height: auto;
    transition: transform 0.3s ease;
  }

  .services .img-fluid:hover {
    transform: scale(1.1);
  }

  .section-bg {
    background-color: #f9f9f9;
    padding: 20px 0;
  }
  .services .row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.services .col-lg-3 {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}

.services .image-wrapper {
  width: 100%;
  height: 150px;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  margin-bottom: 10px;
}

.services .image-wrapper img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.services .info-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

.services .info-table td {
  padding: 5px;
  text-align: left;
  border: 1px solid #ddd;
}

.services .info-table td:first-child {
  font-weight: bold;
  width: 30%;
}

.services .info-table td:nth-child(2) {
  width: 5%;
}

.services .status-on {
  color: green;
  font-weight: bold;
}

.services .status-off {
  color: red;
  font-weight: bold;
}


</style>

  
  <!-- =======================================================
  * Template Name: Maxim
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/maxim-free-onepage-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between">

    <div class="logo d-flex align-items-center">
      <!-- Uncomment below if you prefer to use an image logo -->
      <a href="index.html"><img src="assets/img/BMKG.png" alt="" class="img-fluid"></a>
      <h6 class="ml-5 text-white font-weight-bold mt-2"> &nbsp;&nbsp;&nbsp;MONITORING PERALATAN</h6>
    </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero"><i class="fa fa-home text-white" aria-hidden="true"></i> &nbsp;&nbsp;Home</a></li>
          <li><a class="nav-link scrollto" href="#about">Link Terkait</a></li>
          <li><a class="nav-link scrollto" href="#services">Peta Sebaran</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>

    
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
    <div class="container text-center text-md-left" data-aos="fade-up">
      <h1>Selamat Datang</h1>
      <h2>Web Monitoring Peralatan Stasiun Meteorologi Maritim Ambon</h2>
      <a href="#about" class="btn-get-started scrollto">Mulai</a>
    </div>
  </section><!-- End Hero -->

  <main id="main"> 
    <!-- ======= Steps Section ======= -->
    <section id="about" class="steps about">
      <div class="container">

        <div class="row no-gutters">

          <div class="section-title" data-aos="fade-up">
            <h4 class="font-weight-bold">Link Monitoring</h4>
          </div>
          <div class="col-lg-4 col-md-6 content-item" data-aos="fade-in">
            <a href="https://mms.bmkg.go.id/seecharts/app/canvas/workpad/workpad-a7253550-3b8b-4e28-a7a0-a87d862c2a27/page/1"><img class="img-fluid mx-auto my-5" style="height:60px; display:block" src="https://mms.bmkg.go.id/img/mms1_bmkg-transparent.png" alt="Logo BMKG">
            <br>
            <h5 class="text-center poppins text-primary">AWS MARITIM</h5>
            <h6 class="text-center">Monitoring AWS <br>MARITIM</h6></a>
          </div>

          <div class="col-lg-4 col-md-6 content-item" data-aos="fade-in" data-aos-delay="100">
            <a href="http://202.90.199.132/aws-new/monitoring/3000000028"><img class="img-fluid px-auto mx-auto my-5" style="height:60px; display:block" src="	https://upload.wikimedia.org/wikipedia/commons/1/12/Logo_BMKG_%282010%29.png" alt="Logo BMKG">
            <br>
            <h5 class="text-center poppins text-primary">AWS</h5>
            <h6 class="text-center">Monitoring AWS<br>Pelabuhan</h6></a>
          </div>


        </div>

      </div>
    </section><!-- End Steps Section -->
  
    <section id="about" class="steps bg-section about">
      <div class="container">

        <div class="row no-gutters">

          <div class="section-title" data-aos="fade-up">
            <h4 class="font-weight-bold">Link Lainnya</h4>
          </div>

          <div class="col-lg-4 col-md-6 content-item" data-aos="fade-in" data-aos-delay="100">            
            <a href="https://sibatik.bmkg.go.id/"><img class="img-fluid px-auto mx-auto my-4" style="height:140px; display:block" src="https://sibatik.bmkg.go.id/images/sibatik/Logo-sibatik-03.png" alt="Logo BMKG">
            <h5 class="text-center poppins text-primary">SIBATIK</h5>
            <h6 class="text-center">Pengaduan dan Pelaoporan <br>Pusar Jaringan Komunikasi</a>
          </div>

        </div>

      </div>  
    </section><!-- End Steps Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h4 class="font-weight-bold">Peta Sebaran Aloptama</h4>
          <p class="text-center">Stasiun Meteorologi Maritim Ambon memiliki 2 AWS dan 4 Display Cuaca yang menjadi tanggung jawab stasiun.</p>
        </div>

        <?php
        include "koneksi.php";

        $query_aloptama = "SELECT * FROM aloptama";
        $result_aloptama = mysqli_query($koneksi, $query_aloptama);

        $locations = array();

        if ($result_aloptama) {
            while ($row_aloptama = mysqli_fetch_assoc($result_aloptama)) {
                $location = array(
                    "latitude" => $row_aloptama["lintang"],
                    "longitude" => $row_aloptama["bujur"],
                    "kode" => $row_aloptama["kode"],
                    "jenis" => $row_aloptama["jenis"],
                    "status" => $row_aloptama["status"] // Assuming the status column is in the aloptama table
                );

                $locations[] = $location;
            }
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }

        mysqli_close($koneksi);
        ?>
        
        <!--  <div class="card-body p-1"><canvas id="jenisChart" width="100%" height="170px"></canvas></div>
        Create the map container -->

        <div class="row"><h5 data-aos="fade-up" data-aos-delay="100" class="text-center font-weight-bold pb-2">Presentase On/Off :</h5>
          <div id="map" class="rounded col-lg-8 col-sm-12" data-aos="fade-up" data-aos-delay="100" style="height: 350px;"></div>
          <div class="col-lg-1"></div>
          <div class="col-lg-3 p-4 card col-sm-12 bg-light" data-aos="fade-up" data-aos-delay="100" ><canvas id="statusChart" height="250px"></canvas></div>
        </div>

        <?php
        include "koneksi.php";

       

        mysqli_close($koneksi);
        ?>

      </div>

   <!-- ======= Services Section ======= -->
<section id="services" class="services section-bg">
  <div class="container">
    <div class="section-title" data-aos="fade-up">
      <h4 class="font-weight-bold">Live Monitoring</h4>
    </div>

    <div class="row justify-content-center" id="image-container">
      <?php
      include "koneksi.php";

      // Query untuk mendapatkan data termasuk status
      $query = "SELECT kode, gambar, timestamp, jenis, status FROM aloptama";
      $result = mysqli_query($koneksi, $query);

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          // Skip items of type "AWS"
          if ($row['jenis'] === 'AWS') continue;
          
          // Menampilkan gambar dan informasi
          echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4 text-center">';
          echo '<h5>' . htmlspecialchars($row['kode']) . '</h5>';
          echo '<div class="image-wrapper">';
          echo '<img src="data:image/png;base64,' . base64_encode($row['gambar']) . '" class="img-fluid rounded" alt="Gambar Perangkat">';
          echo '</div>';
          
          // Memisahkan tanggal dan waktu
          $timestamp = new DateTime($row['timestamp']);
          $date = $timestamp->format('d-m-Y');
          $time = $timestamp->format('H:i:s');
          
          // Menentukan status berdasarkan nilai dari database
          $status = ($row['status'] == 'green') ? 'ON' : 'OFF';
          $statusClass = ($row['status'] == 'green') ? 'status-on' : 'status-off';
          
          // Membuat tabel informasi
          echo '<table class="info-table">';
          echo '<tr><td>Tanggal</td><td>:</td><td>' . $date . '</td></tr>';
          echo '<tr><td>Jam</td><td>:</td><td>' . $time . '</td></tr>';
          echo '<tr><td>Status</td><td>:</td><td class="' . $statusClass . '">' . $status . '</td></tr>';
          echo '<tr><td>Keterangan</td><td>:</td><td>-</td></tr>';
          echo '</table>';
          
          echo '</div>';
        }
      } else {
        echo '<p class="text-center">Tidak ada data perangkat ditemukan.</p>';
      }

      mysqli_close($koneksi);
      ?>
    </div>
  </div>
</section>




  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-5 col-md-5">
            <div class="footer-info">
              <img src="assets/img/BMKGputih.jpg" style="max-height:70px" alt="" class="img-fluid rounded mb-2">
              <h5>Stamet Maritim Ambon</h5>
              <p>
              Jl. Amanlanite, Waimahu, Latuhalat
              Nusaniwe, <br>Ambon 97118 <br><br>
              </p>
            </div>
          </div>

          <div class="col-lg-4 col-md-4 footer-links">  
              <h4>Kontak</h4>    
              <ul>
                <li><i class="bx bx-chevron-right"></i><strong>WA :</strong> &nbsp;+62 812-9626-5822</li>
              </ul>
              <br>
              <h4>Email</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i>stamar.ambon@bmkg.go.id</li>
                <li><i class="bx bx-chevron-right"></i>stamar.ambon@gmail.com</li>
              </ul>
          </div>

          <div class="col-lg-3 col-md-3 footer-links">
            <h4>Link Terkait</h4>
              <ul>
                <li><i class="bx bx-chevron-right"></i> <a href="#">BMKG</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">InaTEWS</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">Data Online BMKG</a></li>
                <li><i class="bx bx-chevron-right"></i> <a href="#">Inspektorat BMKG</a></li>
              </ul>
            <div class="social-links mt-3">
                <a href="https://x.com/infoBMKGMaluku?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="https://www.facebook.com/BMKG.Maluku/?locale=id_ID" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="https://www.instagram.com/stamar.ambon/" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=stmar.ambon@gmail.com" class="gmail"><i class="bx bxl-gmail"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="credits">
        <br>
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/maxim-free-onepage-bootstrap-theme/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
  
  <!-- JavaScript to initialize the map and add markers -->
  <script>
  // Initialize the map
  var map = L.map('map').setView([-3.78, 128.100], 10.2);

  // Add a tile layer to the map
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  <?php foreach ($locations as $location): ?>
      var status = "<?php echo $location["status"]; ?>"; // Assuming the status column holds color values like "green" or "red"
      var color = status === "green" ? "green" : "red"; // Set color based on status
      
      var marker = L.marker([<?php echo $location["latitude"]; ?>, <?php echo $location["longitude"]; ?>], {
          icon: L.icon({
              iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-' + color + '.png',
              shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
              iconSize: [25, 41],
              iconAnchor: [12, 41],
              popupAnchor: [1, -34],
              shadowSize: [41, 41]
          })
      });

      marker.bindPopup("<?php echo $location["kode"]; ?>");
      marker.addTo(map);
  <?php endforeach; ?>

  </script>


  <!-- Vendor JS Files -->
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/status.js"></script>
  <script src="assets/js/jenis.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  
</body>

</html>