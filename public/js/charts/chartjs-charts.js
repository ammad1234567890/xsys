    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */


$(function () {



	
	
   /*---------------------
    ----- DOUGHNUT CHART -----
    ---------------------*/
	if($('#doughnutChart')[0]){
		// Get context with jQuery - using jQuery's .get() method.
		var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");

		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						7500,
						5896
					],
					backgroundColor: [
						"#4BC0C0",
						"#36A2EB"
					],
					label: 'My Warehouse' // for legend

					
				}],
				labels: [
					"Karachi Saddar Warehouse",
					"Lahore Bharia warehouse"
				]
			},
			options: {
				responsive: true,
				legend: {
					display: false
				}
			}
		};
		
	   var myDoughnutChart = new Chart(doughnutChartCanvas, config);

	}	



	if($('#lineChart')[0]){
		var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
		var lineChart = new Chart(lineChartCanvas, config);

	}

	
	
   /*---------------------
    ----- BAR CHART -----
    ---------------------*/
    
    
	var barChartData = {
		labels: ["January", "February", "March", "April", "May", "June", "July"],
		datasets: [{
			label: 'Nova ',
			backgroundColor: "#FF6384",
			borderColor: "#FF6384",
			borderWidth: 1,
			data: [
					45, 
					75, 
					26, 
					23, 
					60, 
					48, 
					9
			]
		}, {
			label: 'Nova Plus',
			backgroundColor: "#36A2EB",
			borderColor: "#36A2EB",
			borderWidth: 1,
			data: [
					10, 
					16, 
					72, 
					93, 
					29, 
					74, 
					64
			]
		}]

	};
    
    
	var config = {
					type: 'bar',
					data: barChartData,
					options: {
						responsive: true,
						legend: {
							position: 'top',
						},
						title: {
							display: true,
							text: 'Sales Bar Chart'
						}
					}
                }

    
	if($('#barChart')[0]){
		var barChartCanvas = $("#barChart").get(0).getContext("2d");
		var barChart = new Chart(barChartCanvas, config);

	}


	
});
