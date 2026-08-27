<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sistem Informasi Stamar Ambon</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="css/4.6.2bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    var offset = 0;

        function calcOffset() {
            var xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            xmlhttp.open("HEAD", "http://jam.bmkg.go.id/", false);
            xmlhttp.send();

            var dateStr = xmlhttp.getResponseHeader('Date');
            var serverTimeMillisGMT = Date.parse(new Date(Date.parse(dateStr)).toUTCString());
            var localMillisUTC = (new Date()).getTime();

            offset = serverTimeMillisGMT - localMillisUTC;
        }

        function getServerTime() {
            var date = new Date();
            date.setTime(date.getTime() + offset);
            return date;
        }

        function showLocalTime(a, b, c, d) {
            if (document.getElementById && document.getElementById(a)) {
                this.container = document.getElementById(a), this.displayversion = d;
                this.localtime = this.serverdate = getServerTime(), this.localtime.setTime(this.serverdate.getTime() +
                    60 * c * 1e3), this.updateTime(), this.updateContainer()
            }
        }

        function formatField(a, b) {
            if ("undefined" != typeof b) {
                var c = a > 12 ? a - 12 : a;
                return 0 == c ? 12 : c
            }
            return a <= 9 ? "0" + a : a
        }
        var minggutxt = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            weekdaystxt = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            bulantxt = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ],
            monthstxt = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                "October", "November", "December"
            ];
        showLocalTime.prototype.updateTime = function() {
            var a = this;
            this.localtime.setSeconds(this.localtime.getSeconds() + 1), setTimeout(function() {
                a.updateTime()
            }, 1e3)
        }, showLocalTime.prototype.updateContainer = function() {
            var a = this;
            if ("long" == this.displayversion) this.container.innerHTML = this.localtime.toLocaleString();
            else {
                var b = this.localtime.getHours(),
                    c = this.localtime.getMinutes(),
                    d = this.localtime.getSeconds(),
                    k = (this.localtime.getDate(), this.localtime.getUTCDate(), minggutxt[this.localtime.getDay()],
                        bulantxt[this.localtime.getMonth()], weekdaystxt[this.localtime.getUTCDay()], monthstxt[this
                            .localtime.getUTCMonth()], b + 1);
                k >= 24 && (k -= 24);
                var l = b + 2;
                l >= 24 && (l -= 24);
                var m = b - 7;
                m < 0 && (m += 24);
                this.container.innerHTML =
                    "<span class='hari-digit hidden-xs'><a target='_blank'>Standar Waktu Indonesia  </a></span> <span class='FontDigit'>" +
                    formatField(b) + ":" + formatField(c) + ":" + formatField(d) +
                    " WIB / </span><span class='FontDigit'>" + formatField(m) + ":" + formatField(c) + ":" +
                    formatField(d) + " UTC</span>"
            }
            setTimeout(function() {
                a.updateContainer()
            }, 1e3)
        };

        // Fix untuk button yang tidak dapat diklik saat zoom
        document.addEventListener('DOMContentLoaded', function() {
            // Pastikan semua button dapat diklik
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(function(button) {
                button.style.pointerEvents = 'auto';
                button.style.cursor = 'pointer';
                button.style.position = 'relative';
                button.style.zIndex = '20';
                
                // Tambahkan event listener untuk memastikan click event berfungsi
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const link = this.closest('a');
                    if (link && link.href) {
                        window.open(link.href, link.target || '_self');
                    }
                });
            });
            
            // Fix untuk link yang membungkus button
            const btnLinks = document.querySelectorAll('.btn-link');
            btnLinks.forEach(function(link) {
                link.style.pointerEvents = 'auto';
                link.style.cursor = 'pointer';
                link.style.position = 'relative';
                link.style.zIndex = '25';
            });
        });
  </script>
  
<style>
.hero-image {
  background-image: url("image/login.svg");
  background-attachment: fixed;
  min-height: 100vh;
  background-repeat: repeat;
  background-position: center;
  background-size: cover;
  position: relative;  
}

@media only screen and (min-width: 1200px) {
  .bottomnavbar {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    z-index: 1;
  }
}

/* Fix untuk button yang tidak dapat diklik saat zoom */
.btn {
  position: relative;
  z-index: 10;
  pointer-events: auto;
}

/* Pastikan button tetap dapat diklik di semua zoom level */
a.btn, button.btn {
  display: inline-block;
  text-decoration: none;
  cursor: pointer;
  user-select: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}

/* Fix untuk container button */
.container .row .col-md-6 .container {
  position: relative;
  z-index: 5;
}

/* Pastikan tidak ada elemen yang menutupi button */
.hero-image {
  position: relative;
  z-index: 1;
}

/* Fix untuk button container */
.button-container {
  position: relative;
  z-index: 10;
  padding: 10px;
}

.btn-link {
  display: block;
  text-decoration: none;
  position: relative;
  z-index: 15;
  margin-bottom: 10px;
}

.btn-link:hover {
  text-decoration: none;
}

/* Pastikan button dapat diklik di semua zoom level */
@media (min-width: 768px) {
  .button-container .btn {
    min-height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    line-height: 1.2;
  }
}

/* Fix untuk zoom level tinggi */
@media (min-resolution: 2dppx) {
  .btn {
    transform: translateZ(0);
    -webkit-transform: translateZ(0);
  }
} 
</style>

</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" type="image/png" href="image/BMKGMini.png">

<body>
<!--HERO IMAGES-->
<div class="hero-image fluid-container">
  <div class="d-flex justify-content-between p-2 text-black font-weight-bold">
    <div class="p-2">
          <script type='text/javascript'>
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                    var date = new Date();
                    var day = date.getDate();
                    var month = date.getMonth();
                    var thisDay = date.getDay(),
                      thisDay = myDays[thisDay];
                    var yy = date.getYear();
                    var year = (yy < 1000) ? yy + 1900 : yy;
                    document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
          </script>	
    </div>
    <div id="timecontainer" class="p-2 font-weight-bold">
          <script type="text/javascript">
            new showLocalTime("timecontainer", "server-php", 0, "short")
          </script>
    </div>
  </div>
	<div class="container mb-0">
		<div class="row justify-content-around mt-5 pt-5 mb-5 pb-4">
		  <div class="col-md-6 row container align-content-center">
		  	<div class="col-sm-12 text-center" style="color: black;">
				  <img class="img-fluid mb-2 mx-auto d-block" style="height:100px" src="image/BMKG.svg" alt="Logo BMKG">
		  		<div><h1 class="h4 font-weight-bold mb-0 text-gray-800">SISTEM INFORMASI</h1></div>
		  		<div><h1 class="h4 font-weight-bold mb-0 text-gray-800">STAMET MARITIM AMBON</h1></div>
		  	</div>
		  </div>
		  <div class="col-md-6 row container align-content-center">
		  	<div class="container button-container">
            <a href="https://forms.gle/aXJtJtNxfG4hFUEu9" target="_blank" class="btn-link">
              <button class="col-sm-12 btn btn-outline-primary font-weight-bold m-2" style="height:70px; width:100%;">Logbook Forecaster</button>
            </a>
            <a href="https://forms.gle/x4xrXjpuuhpVW7nM8" target="_blank" class="btn-link">
              <button type="button" class="col-sm-12 btn btn-outline-danger font-weight-bold m-2" style="height:70px; width:100%;">Logbook Observer</button>
            </a>
            <a href="https://forms.gle/koBxkKsxjYCCS4BY8" target="_blank" class="btn-link">
              <button type="button" class="col-sm-12 btn btn-outline-success font-weight-bold m-2" style="height:70px; width:100%;">Logbook Teknisi</button>
            </a>
            <a href="https://docs.google.com/forms/u/0/?tgif=d" target="_blank" class="btn-link">
              <button type="button" class="col-sm-12 btn btn-outline-success font-weight-bold m-2" style="height:70px; width:100%;">Data Logbook</button>
            </a>
            <a href="Aloptama/index.php" target="_blank" class="btn-link">
              <button type="button" class="col-sm-12 btn btn-outline-warning font-weight-bold m-2" style="height:70px; width:100%;">Monitoring Peralatan</button>
            </a>
            <a href="Aloptama/sukucadang.php" target="_blank" class="btn-link">
              <button type="button" class="col-sm-12 btn btn-outline-info font-weight-bold m-2" style="height:70px; width:100%;">Suku cadang</button>
            </a>
		  	</div>
		  </div>
		</div>
	</div>
  <div class="bottomnavbar">
	<div class="d-flex justify-content-center pt-5 mt-5">
	</div>
  <div class="d-flex justify-content-center font-weight-bold pt-2 mt-2 pb-1">
    <div>© 2023-Stasiun Meteorologi Maritim Ambon</div>
  </div>
  </div>
</div>
</body>


</html>