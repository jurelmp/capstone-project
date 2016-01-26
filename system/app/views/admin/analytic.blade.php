@extends('layout.index')

	@section('pagetitle')
		Analytics
	@endsection

	@section('head')
		
		<script>

			$(document).ready(function(){
				var chart = {
					chart: {
						renderTo: '#example'
					},
					series: [{
			            name: name1,
			            data: series1
			        }, {
			            name: name2,
			            data: series2
			        }, {
			            name: name3,
			            data: series3
			        }]
				};

				var name1 = 'CCS';
				var name2 = 'Allied';
				var name3 = '';
				var series1 = [14, 13, 15, 13, 10, 9, 11, 11, 16];
				var series2 = [14, 13, 15, 13, 10, 9, 11, 11, 16];
				var series3 = [];

				$('select[name=department]').change(function(){
					// alert($(this).val());
					var val = $(this).val();

					if(val == 1){
						name1 = 'BSIT';
						name2 = 'BSIS';
						name3 = 'BSCS';
						series1 = [5, 4, 6, 3, 5, 3, 4, 7, 10]
						series2 = [3, 4, 5, 4, 2, 2, 3, 2, 1]
						series3 = [6, 5, 4, 6, 3, 4, 4, 2, 5]
					} else if(val == 2){
						name1 = 'BSECE';
						name2 = 'BSCPE';
						name3 = 'BSME';
						series3 = [5, 4, 6, 3, 5, 3, 4, 7, 10]
						series1 = [3, 4, 5, 4, 2, 2, 3, 2, 1]
						series2 = [6, 5, 4, 6, 3, 4, 4, 2, 5]
					}

					chart.series = [{
			            name: name1,
			            data: series1
			        }, {
			            name: name2,
			            data: series2
			        }, {
			            name: name3,
			            data: series3
			        }];
				});

				$('#example').highcharts({
			        chart: {
			            type: 'column'
			        },
			        title: {
			            text: 'Alumni Tracer'
			        },
			        xAxis: {
			            categories: ['2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014']
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Number of alumni who answer the study.'
			            },
			            stackLabels: {
			                enabled: true,
			                style: {
			                    fontWeight: 'bold',
			                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
			                }
			            }
			        },
			        legend: {
			            align: 'right',
			            x: -30,
			            verticalAlign: 'top',
			            y: 25,
			            floating: true,
			            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
			            borderColor: '#CCC',
			            borderWidth: 1,
			            shadow: false
			        },
			        tooltip: {
			            formatter: function () {
			                return '<b>' + this.x + '</b><br/>' +
			                    this.series.name + ': ' + this.y + '<br/>' +
			                    'Total: ' + this.point.stackTotal;
			            }
			        },
			        plotOptions: {
			            column: {
			                stacking: 'normal',
			                dataLabels: {
			                    enabled: true,
			                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
			                    style: {
			                        textShadow: '0 0 3px black'
			                    }
			                }
			            }
			        },
			        series: [{
			            name: name1,
			            data: series1
			        }, {
			            name: name2,
			            data: series2
			        }, {
			            name: name3,
			            data: series3
			        }]
			    });

				
				

			});

		</script>
	
	@endsection


	@section('content')
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">Number of Graduates</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-md-6 pull-right">
							<select class="form-control" name="department">
								<option>All</option>
								<option value="1">CCS</option>
								<option value="2">Allied Engineering</option>
							</select>
						</div>
					</div>
					<div id="example" class="col-md-10 col-md-offset-1">

					</div>
				</div>

			</div>
		</div>
	@endsection

@stop