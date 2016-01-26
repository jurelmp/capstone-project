<script type="text/javascript">

	var categories = <?php echo json_encode($categories); ?>;
	var graduates = <?php echo json_encode($graduates); ?>;
	var response = <?php echo json_encode($response); ?>;


	$('table > tbody').html(generate_table(categories, graduates, response));
	
	$('#response').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'Graduates who respond and did not respond to survey.'
		},
		subtitle: {
			text: 'From' + $('#response_from').val() + "-" + $('#response_to').val()
		},
		xAxis: {
			categories: categories,
			labels: {
				rotation: -45
			},
			title: {
				text: 'Academic Year'
			}
		},
		yAxis: {
			allowDecimal: false,
			min: 0,
			title: {
				text: 'No of Graduates'
			}
		},
		tooltip: {
			formatter: function(){
				// return '<b>' + this.x + ': ' + this.y + '<br>' + 'Total: ' + this.point.stackTotal;
				return '<b>' + this.x + ': ' + this.y + '<br>' + 'Total: ' + this.point.y;
			}
		},
		// plotOptions: {
		// 	series: {
		// 		dataLabels: {
		// 			enabled: true,
		// 			format: '{point.y: .0f} '
		// 		}
		// 	}
		// },
		series: [{
			name: 'Response',
			data: response
		},
		{
			name: 'Graduates',
			data: graduates
		}]
	});

	function generate_table(c, g, r){
		var str = '';
		var n_total = 0;
		var g_total = 0;
		var r_total = 0;

		for (var i = 0; i < c.length; i++) {
			n_total += (g[i] - r[i]);
			g_total += g[i];
			r_total += r[i];

			str += "<tr>";
			str += "<td>"+c[i]+"</td>";
			str += "<td>"+r[i] + " <span style='color: red;'>( "+Number((r[i]/g[i])*100).toFixed(1)+" % )</span> " +"</td>";
			str += "<td>"+(g[i] - r[i])+ " <span style='color: red;'>( "+Number(((g[i] - r[i])/g[i])*100).toFixed(1)+" % )</span>"  +"</td>";
			str += "<td>"+g[i]+"</td>";
			str += "</tr>";
		};

		str += "<tr style='color: blue'>";
		str += "<td>Total</td>";
		str += "<td>"+r_total+ " ( "+ Number((r_total/g_total)*100).toFixed(1) +" % )</td>";
		str += "<td>"+n_total+ " ( "+ Number((n_total/g_total)*100).toFixed(1) +" % )</td>";
		str += "<td>"+g_total+"</td>";
		str += "</tr>";

		return str;
	}

</script>

<div id="response"></div>

<table class="table table-bordered default-table">
	<thead>
		<tr>
			<th>Academic Year</th>
			<th>Respond</th>
			<th>Did Not Respond</th>
			<th>No. of Graduates</th>
		</tr>
	</thead>

	<tbody>

		<?php
			$str = "";
			for ($i=0; $i < count($categories); $i++) { 
				$str .= "<tr>";
				$str .= "<td>".$categories[$i]."</td>";
				$str .= "<td></td>";
				$str .= "<td></td>";
				$str .= "<td></td>";
				$str .= "</tr>";
			}
		?>

	</tbody>

</table>