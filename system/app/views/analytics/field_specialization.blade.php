<script type="text/javascript">
	
	var categories = <?php echo json_encode($categories) ?>;
	var values = <?php echo json_encode($values) ?>;
	var employed = <?php echo json_encode($employed) ?>;
	var not_employed = <?php echo json_encode($not_employed) ?>;
	var never_employed = <?php echo json_encode($never_employed); ?>;

	$('#fs_container').highcharts({
	    chart: {
	        type: 'spline'
	    },
	    title: {
	        text: 'Distribution of Graduates by Field of Specialization'
	    },
	    subtitle: {
	        text: 'Source: From ' + $('select[name=fs_from]').val() + ' to ' + $('select[name=fs_to]').val()
	    },
	    xAxis: {
	        categories: categories,
	        labels: {
	        	rotation: -45,
	        	style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
	        },
	        title: {
	        	text: 'Programs'
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
	        headerFormat: '<span style="font-size:15px"><b>{point.key}</b></span><table>',
	        pointFormat: '<tr><td style="color:{series.color};padding:0">{point.key} {series.name} :</td>' +
	            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
	        footerFormat: '</table>',
	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        series: {
	            // borderWidth: 0,
	            // dataLabels: {
	            //     enabled: true,
	            //     format: '{point.y:.0f}'
	            // }
	        }
	    },
	    series: [{
	    	name: 'Graduates',
	    	data: values,
	    	color: Highcharts.getOptions().colors[10]
	    	// dataLabels: {
      //           enabled: true,
      //           rotation: -90,
      //           color: '#FFFFFF',
      //           align: 'right',
      //           x: 4,
      //           y: 10,
      //           style: {
      //               fontSize: '13px',
      //               fontFamily: 'Verdana, sans-serif',
      //               textShadow: '0 0 3px black'
      //           }
      //       }
	    }, {
	    	type: 'column',
	    	name: 'Employed',
	    	// data: [0, 0, 0, 0, 0, 0, 4, 6, 3, 0, 10, 0, 6, 20, 0, 0, 0, 1, 0, 0]
	    	data: employed
	    }, {
	    	type: 'column',
	    	name: 'Not Employed',
	    	// data: [0, 0, 0, 0, 0, 0, 4, 6, 3, 0, 10, 0, 6, 20, 0, 0, 0, 1, 0, 0]
	    	data: not_employed
	    }, {
	    	type: 'column',
	    	name: 'Never Employed',
	    	// data: [0, 0, 0, 0, 0, 0, 4, 6, 3, 0, 10, 0, 6, 20, 0, 0, 0, 1, 0, 0]
	    	data: never_employed
	    }]
	});
</script>

<div id="fs_container"></div>