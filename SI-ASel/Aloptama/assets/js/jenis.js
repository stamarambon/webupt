$.ajax({
    url: 'getJenisFromAloptama.php',
    method: 'GET',
    success: function(response) {
      var data = JSON.parse(response);
  
      // Menghitung jumlah jenis "Seismograph" dan "Accelerograph"
      var totalSeismograph = data.filter(item => item.jenis === 'Seismograph').length;
      var totalAccelerograph = data.filter(item => item.jenis === 'Accelerograph').length;
      var totalData = data.length;
  
      // Menghitung presentase jenis "Seismograph" dan "Accelerograph"
      var percentSeismograph = (totalSeismograph / totalData) * 100;
      var percentAccelerograph = (totalAccelerograph / totalData) * 100;
  
      // Pie Chart Example
      var ctx = document.getElementById("jenisChart"); // Ganti "jenisChart" sesuai dengan id elemen di HTML
      var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ["Seismograph", "Accelerograph"],
          datasets: [{
            data: [percentSeismograph, percentAccelerograph],
            backgroundColor: ['#4e73df', '#e74a3b'],
            hoverBackgroundColor: ['#2e59d9', '#c23e1e'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }],
        },
        options: {
          maintainAspectRatio: false,
          // ...opsi lainnya...
        },
      });
    },
    error: function(xhr, status, error) {
      console.error(error);
    }
  });
  