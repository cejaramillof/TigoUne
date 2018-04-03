// Chart.js scripts
// -- Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
// -- Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    datasets: [{
      label: "Sessions",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 20,
      pointBorderWidth: 2,
      data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          //min: 0,
          max: 150,
          //maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
// -- Bar Chart Matriz
var ctx = document.getElementById("matrizBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Móvil C', 'Home C', 'Empresas', 'Móvil S', 'Home S', 'Instaladores', 'General'],
    datasets: [{
      label: "Cobertura General",
      backgroundColor: "red",
      borderColor: "rgb(0,32,96)",
      data: arr,
    },
		{
      label: "Cumplimiento Matriz",
      backgroundColor: "rgb(0,32,96)",
      borderColor: "red",
      data: arr2,
    }],		
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 150,
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: true
    }
  }
});

// -- Bar Chart Digital
var ctx = document.getElementById("digitalBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Móvil C', 'Home C', 'Empresas', 'Móvil S', 'Home S', 'Instaladores'],
    datasets: [{
      label: "Cobertura Matriz / Otros Temas",
      backgroundColor: "rgb(0,32,96)",
      borderColor: "red",			
      data: arrd,
    },
		{
      label: "Temas Matriz",
      backgroundColor: "red",
      borderColor: "rgb(0,32,96)",
      data: arrdi,
    }],		
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 150,					
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: true
    }
  }
});

// Define a plugin to provide data labels
Chart.plugins.register({
	afterDatasetsDraw: function(chart, easing) {
		// To only draw at the end of animation, check for easing === 1
		var ctx = chart.ctx;
		chart.data.datasets.forEach(function(dataset, i) {
			var meta = chart.getDatasetMeta(i);
			if (!meta.hidden) {
				meta.data.forEach(function(element, index) {
					// Draw the text in black, with the specified font
					ctx.fillStyle = 'rgb(0, 0, 0)';
					var fontSize = 12;
					var fontStyle = 'normal';
					var fontFamily = 'Helvetica Neue';
					ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
					// Just naively convert to string for now
					var dataString = dataset.data[index].toString().concat("%");
					// Make sure alignment settings are correct
					ctx.textAlign = 'center';
					ctx.textBaseline = 'middle';
					var padding = 5;
					var position = element.tooltipPosition();
					ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
				});
			}
		});
	}
});
