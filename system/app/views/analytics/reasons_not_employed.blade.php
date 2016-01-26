<script type="text/javascript">
	
	var data = <?php echo json_encode($series); ?>;
	var names = <?php echo json_encode($names); ?>;
	var categories = <?php echo json_encode($categories); ?>;

	var series = generate(names, data);

	$('#not_employed').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'Reasons for being not employed of the graduates'
		},
		subtitle: {
			text: 'From: ' + $('#not_employed_from').val() + "-" + $('#not_employed_to').val()
		},
		xAxis: {
			categories: categories,
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
			ceiling: 100,
			title: {
				text: 'No. of Graduates'
			}
		},
		// tooltip: {
		// 	formatter: function(){
		// 		return '<b>' + this.x + '</b><br/>' +
		// 				this.series.name + ': ' + this.y + '<br/>' +
		// 				'Total: ' + this.point.stackTotal;
		// 	}
		// },
	    plotOptions: {
	    	column: {
	    		stacking: 'normal'
	    	}
            // series: {
            //     borderWidth: 0,
            //     dataLabels: {
            //         enabled: true,
            //         format: '{point.y:.2f} %'
            //     }
            // }
        },
		series: series
	});

	function generate(names, data){
		var series = [];

		for (var i =  0; i < names.length; i++) {
			series.push({
				name: names[i],
				data: data[i]
			});
		}

		return series;
	}
	
</script>

<div id="not_employed"></div>

<table>
	<thead>
		<tr>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
</table>