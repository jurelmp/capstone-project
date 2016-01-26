<script type="text/javascript">
	var r = <?php echo json_encode($reasons); ?>;
	var reasons = categories(r);
	var results = <?php echo json_encode($results); ?>;
	var n = <?php echo json_encode($n_graduates); ?>;
	var data = generate_data(results);
	// console.log(results);


	// console.log(n);
	$('#reason_1').highcharts({
		chart: {
			type: 'spline'
		},
		title: {
			text: 'Reasons for enrolling '+ $('#filter_dept option:selected').attr('rel') +' in UC-LM'
		},
		subtitle: {
			text: $('#filter_dept > option:selected').html()
		},
		xAxis: {
			categories: reasons,
			labels: {
				rotation: -45,
				style: {
					fontSize: '10px',
					fontFamily: 'Verdana, sans-serif'
				}
			}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			ceiling: 100,
			title: {
				text: 'Graduates in (%)'
			}
		},
		tooltip: {
	        headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{point.key} {series.name} :</td>' +
	            '<td style="padding:0"><b>{point.y:.2f} %</b></td></tr>',
	        footerFormat: '</table>',
	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f} %'
                }
            }
        },
		series: [{
			name: 'Graduates',
			data: data
		}]
	});

	function categories(cat){
		var series = [];
		for(var i = 0;i < cat.length; i++){
			series.push(cat[i].choice);
		}
		return series
	}

	function generate_data(dat){
		var data = [];

		for(var i = 0;i < dat.length; i++){
			data.push(dat[i].count);
		}

		return data;
	}

	// function generate_data(dat, num){
	// 	var data = [];
	// 	var ntemp = num[0].count;

	// 	for(var i = 0;i < dat.length; i++){
	// 		data.push((dat[i].count / ntemp)*100);
	// 	}
	// 	// console.log(data);
	// 	return data;
	// }

</script>

<div id="reason_1" style="height: 500px;">

</div>