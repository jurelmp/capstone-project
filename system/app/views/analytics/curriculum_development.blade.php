<script type="text/javascript">
	var names = <?php echo json_encode($names); ?>;
	var data = <?php echo json_encode($series); ?>;
	var categories = <?php echo json_encode($categories); ?>;
	var series = generate(names, data);
	var total_graduates = <?php echo json_encode($graduates); ?>;
	var no_suggestion = <?php echo json_encode($no_suggestion); ?>;

	$('#result > tbody').html(table(names, no_suggestion));

	$('#development').highcharts({
		chart: {
			type: 'spline'
		},
		title: {
	        text: 'Suggestions for Curriculum Development'
	    },
	    subtitle: {
	        text: 'From' + $('#dev_from').val() + " to " + $('#dev_to').val()
	    },
	    xAxis: {
	        categories: categories,
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
	    // plotOptions: {
	    // 	column: {
	    // 		stacking: 'normal'
	    // 	},
	    //     series: {
	    //         borderWidth: 0,
	    //         dataLabels: {
	    //             enabled: true,
	    //             format: '{point.y:.0f}'
	    //         }
	    //     }
	    // },
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

	function table(suggestion, data){
		var str = '';

		for(var i=0;i<suggestion.length;i++){
			str += "<tr>";
			str += "<td>"+suggestion[i]+"</td>";
			str += "<td>"+data[i]+"</td>";
			str += "<td>"+Number((data[i]/total_graduates)*100).toFixed(2)+" % </td>";
			str += "</tr>";
		}

		return str;
	}


</script>

<div id="development"></div>

<table class="table default-table" id="result">
	<thead>
		<tr>
			<th>Suggestion</th>
			<th>Frequency</th>
			<th>Rate (%)</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
		</tr>
	</tbody>
</table>