@extends('layout.index')
	
	@section('pagetitle')
		Curriculum
	@endsection

	@section('head')
	@endsection


	@section('content')


		<div class="container">

			<div class="panel panel-primary">
				<div class="panel-heading">&nbsp;</div>

				<div class="panel-body">

					<!-- graph for responses versus overall graduates -->
					<!-- <div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<select id="filter_dept_response">
										<option value="0">All</option>
										@foreach($departments as $dept)
											<option value="{{ $dept->id }}">{{ $dept->name }}</option>
										@endforeach
									</select>
									From
									<select id="response_from">
										<?php
											$y = date('Y');
											for ($i=1994; $i < $y; $i++) {
												if($i == 1994){
													echo "<option value='".$i."' selected='selected'>".$i."</option>";
												} else{
													echo "<option value='".$i."'>".$i."</option>";
												}
											}	
										?>
									</select>
									to 
									<select id="response_to">
										<?php
											$y = date('Y');
											for ($i=1994; $i < $y; $i++) {
												if($i == $y - 1){
													echo "<option value='".$i."' selected='selected'>".$i."</option>";
												} else{
													echo "<option value='".$i."'>".$i."</option>";
												}
											}	
										?>
									</select>
									<button id="btn_generate_response">Generate</button>
								</div>
							</div>

							<div class="row" id="graph_2"></div>
						</div>
					</div> -->

					<!-- graph for curriculum development -->
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									Department
									<select id="dept_dev">
										<option value="0">All</option>
										@foreach($departments as $dept)
											<option value="{{ $dept->id }}" rel="{{ $dept->description }}">{{ $dept->name }}</option>
										@endforeach
									</select>
									From
									<select id="dev_from">
										<?php
											$y = date('Y');
											for ($i=1994; $i <= $y; $i++) {
												if($i == 1994){
													echo "<option value='".$i."' selected='selected'>".$i."</option>";
												} else{
													echo "<option value='".$i."'>".$i."</option>";
												}
											}	
										?>
									</select>
									to 
									<select id="dev_to">
										<?php
											$y = date('Y');
											for ($i=1994; $i <= $y; $i++) {
												if($i == $y - 1){
													echo "<option value='".$i."' selected='selected'>".$i."</option>";
												} else{
													echo "<option value='".$i."'>".$i."</option>";
												}
											}	
										?>
									</select>

									<button id="dept_dev_generate">Generate</button>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12" id="dev_container"></div>
							</div>
						</div>
					</div>
					<!-- end of graph for curriculum development -->

					<!-- graph reasons for taking collge in uclm -->
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									Department
									<select id="filter_dept">
										<option value="0" rel="">All</option>
										@foreach($departments as $dept)
											<option value="{{ $dept->id }}" rel="{{ $dept->description }}">{{ $dept->name }}</option>
										@endforeach
									</select>
									<button id="btn_generate_reasons">Generate</button>
								</div>
							</div>

							<div class="row" id="graph_1"></div>
						</div>
							
					</div>
					

				</div>
			</div>
		</div>
		<div class="container"></div>

		<script type="text/javascript">

			$(document).ready(function(){

				var lnk_graph1 = "{{ URL::to('analytics/reason-for-taking-uc') }}";
				var lnk_development = "{{ URL::to('analytics/curriculum-development/"+$("#dept_dev").val()+"/"+$("#dev_from").val()+"/"+$("#dev_to").val()+"') }}";

				$.ajax({
					url: lnk_graph1,
					type: 'GET',
					data: {
						'filter_dept': $("#filter_dept").val()
					},
					success: function(response){
						$('#graph_1').html(response);
					}
				});

				$.ajax({
					url: lnk_development,
					type: 'GET',
					success: function(response){
						$('#dev_container').html(response);
						// alert(response);
					}
				});


				$('#btn_generate_reasons').click(function(){
					var lnkpath = "{{ URL::to('analytics/reason-for-taking-uc') }}";
					var id = $("#filter_dept").val();

					$.ajax({
						url: lnkpath,
						type: 'GET',
						data: {
							'filter_dept': id
						},
						beforeSend: function(){
							$('#btn_generate_reasons').attr('disabled', 'disabled').html('Generating...');
						},
						success: function(response){
							$('#graph_1').html(response);
							$('#btn_generate_reasons').removeAttr('disabled').html('Generate');
						}
					});
				});

				$('#dept_dev_generate').click(function(){
					var from = $("#dev_from").val();
					var to = $("#dev_to").val();
					var dept = $("#dept_dev").val();

					var lnkpath = "{{ URL::to('analytics/curriculum-development/"+dept+"/"+from+"/"+to+"') }}";

					if(from > to){
						alert('Invalid');
					} else{
						$.ajax({
							url: lnkpath,
							type: 'GET',
							beforeSend: function(){
								$('#dept_dev_generate').attr('disabled', 'disabled').html('Generating...');
							},
							success: function(response){
								$('#dev_container').html(response);
								$('#dept_dev_generate').removeAttr('disabled').html('Generate');

								// alert(response);
							}
						});
					}

						
				});





			});

		</script>
	@endsection
@stop