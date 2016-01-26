<script type="text/javascript">
	var series = [];
	var academic_years = <?php echo json_encode($academic_years); ?>;
	var skills_data = <?php echo json_encode($skills_data) ?>;
	var names = <?php echo json_encode($names) ?>;


	var series = generate_data(names, skills_data);
	// alert(names);

	$('#graph_3').highcharts({
		chart: {
			type: 'spline'
		},
		title: {
			text: 'Skills Assessment'
		},
		subtitle: {

		},
		xAxis: {
			categories: academic_years,
			labels: {
				rotation: -45,
				style: {
					fontSize: '10px',
					fontFamily: 'Verdana, sans-serif'
				}
			},
			title: {
				text: 'Academic Year'
			}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			// ceiling: 100,
			title: {
				text: 'Frequency Graduates'
			}
		},
		tooltip: {
	        headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{point.key} {series.name} :</td>' +
	            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
	        footerFormat: '</table>',
	        shared: true,
	        useHTML: true
	    },
	    // plotOptions: {
     //        series: {
     //            borderWidth: 0,
     //            dataLabels: {
     //                enabled: true,
     //                format: '{point.y:.2f} %'
     //            }
     //        }
     //    },
		series: series
	});


	function generate_data(names, data){
		var series = [];

		for (var i = 0; i < names.length; i++) {
			series.push({
				name: names[i],
				data: data[i]
			});
		};

		return series;
	}

</script>

<div id="graph_3"></div>