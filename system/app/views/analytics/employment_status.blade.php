<script>
	var choices = <?php echo json_encode($choices) ?>;
	var status_count = <?php echo json_encode($employment_status) ?>;
	var data = <?php echo json_encode($data) ?>;
	var categories = <?php echo json_encode($categories) ?>;
	
	var t = "{{ $title }}";



		$('#employment_status').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Distribution of Graduates by Employment Status'
            },
            subtitle: {
                text: 'Source: ' + t
            },
            xAxis: {
                categories: categories,
                title: {
                	text: '<b>Employment Status</b>'
                }
            },
            yAxis: {
            	allowDecimals: false,
                min: 0,
                title: {
                    text: 'Number of Graduates'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{point.key}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}'
                    }
                }
            },
            series: [{
            	name: t,
            	data: data,
            	color: Highcharts.getOptions().colors[6]
            }, {
	            type: 'pie',
	            name: 'Total consumption',
	            data: [{
	                name: categories[0],
	                y: data[0],
	                color: Highcharts.getOptions().colors[0]
	            }, {
	                name: categories[1],
	                y: data[1],
	                color: Highcharts.getOptions().colors[1]
	            }, {
	                name: categories[2],
	                y: data[2],
	                color: Highcharts.getOptions().colors[2]
	            }, {
	                name: categories[3],
	                y: data[3],
	                color: Highcharts.getOptions().colors[3]
	            }, {
	                name: categories[4],
	                y: data[4],
	                color: Highcharts.getOptions().colors[4]
	            }],
	            center: [190, 10],
	            size: 100,
	            showInLegend: false,
	            dataLabels: {
	                enabled: false
	            }
	        }]
        });

	function generate_series(names, data){
		var series = [];

		return series;
	}

</script>

<div id="employment_status"></div>