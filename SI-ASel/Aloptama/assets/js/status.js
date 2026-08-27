$.ajax({
  url: 'getDataFromAloptama.php',
  method: 'GET',
  success: function(response) {
    var data = JSON.parse(response);

    // Menghitung jumlah status "green" dan "red"
    var totalGreen = data.filter(item => item.status === 'green').length;
    var totalRed = data.filter(item => item.status === 'red').length;
    var totalData = data.length;

    // Menghitung presentase status
    var percentGreen = (totalGreen / totalData) * 100;
    var percentRed = (totalRed / totalData) * 100;

    // Pie Chart Example
    var ctx = document.getElementById("statusChart");
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["On", "Off"],
        datasets: [{
          data: [percentGreen, percentRed],
          backgroundColor: ['#2db92d', '#e74a3b'],
          hoverBackgroundColor: ['#196719', '#c23e1e'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        title: {
          display: true,
          text: 'Presentase Status On/Off',
          fontSize: 16,
        },
        maintainAspectRatio: false,
        // ...opsi lainnya...
      },
    });
  },
  error: function(xhr, status, error) {
    console.error(error);
  }
});
