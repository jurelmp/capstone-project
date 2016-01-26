<script type="text/javascript">
	
	var program = <?php echo json_encode($program); ?>;
	var academic_years = <?php echo json_encode($academic_years); ?>;
	var data = <?php echo json_encode($data); ?>;
	var series = generate_series(program, data);

	var to = $('#summary_es_to').val();
	var from = $('#summary_es_from').val();
	var stat = $('#summary_es_emp_status').val();
	var status = $('#summary_es_emp_status > option[value='+stat+']').html();
	// alert(series);

	$('#summary_es_container').highcharts({
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'number of graduates who are ' + status
	    },
	    subtitle: {
	        text: 'From' + from + " to " + to
	    },
	    xAxis: {
	        categories: academic_years,
	        labels: {
	        	rotation: -45
	        },
	        // labels: {
	        // 	rotation: -45,
	        // 	style: {
         //            fontSize: '13px',
         //            fontFamily: 'Verdana, sans-serif'
         //        }
	        // },
	        title: {
	        	text: 'Academic Year'
	        }
	    },
	    yAxis: {
	    	allowDecimals: false,
	        min: 0,
	        title: {
	            text: 'Frequency of Graduates'
	        }
	    },
	    tooltip: {
	        // headerFormat: '<span style="font-size:15px"><b>{point.key}</b></span><table>',
	        // pointFormat: '<tr><td style="color:{series.color};padding:0">{point.key} {series.name} :</td>' +
	        //     '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
	        // footerFormat: '</table>',
	        // shared: true,
	        // useHTML: true
	        formatter: function(){
	        	return '<b>' + this.x + '</b><br/>' +
						this.series.name + ': ' + this.y + '<br/>' +
						'Total: ' + this.point.stackTotal;
	        }
	    },
	    plotOptions: {
	    	column: {
	    		stacking: 'normal'
	    	},
	        series: {
	            // borderWidth: 0,
	            // dataLabels: {
	            //     enabled: true,
	            //     format: '{point.y:.0f}'
	            // }
	        }
	    },
	    series: series
	});


	function generate_series(names, data){
		var series = [];

		for(i=0;i<names.length; i++){
	        series.push({
	            name:names[i],
	            data:data[i]
	        });
	    }

	    return series;
	}
</script>

<div id="summary_es_container"></div>