@extends('layout.index')

	@section('pagetitle')
		Skills Assessment
	@endsection

	@section('head')
	@endsection


	@section('content')

		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">&nbsp;</div>

				<div class="panel-body">
					<!-- graph 1 -->
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									Department
									<select id="filter_dept">
										<option value="0">All</option>
										@foreach($departments as $dept)
											<option value="{{ $dept->id }}">{{ $dept->name }}</option>
										@endforeach
									</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									From
									<select id="filter_from">
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
									To
									<select id="filter_to">
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

									<button id="skills_assessment_btn">Generate</button>
								</div>
							</div>

							<div class="row" id="graph_1">

							</div>
						</div>
					</div>

				</div>

				<!-- <div class="panel-footer"></div> -->
			</div>
		</div>
		<div class="container"></div>

		<script>

			$(document).ready(function(){

				var str = "analytics/skills/" + $('#filter_dept').val() + "/" + $('#filter_from').val() + "/" + $('#filter_to').val();
				var lnk_load = "{{ URL::to('"+str+"') }}";
				
				// alert(lnk_load);
				$.ajax({
					url: lnk_load,
					type: 'GET',
					success: function(response){
						$('#graph_1').html(response);
						// alert(response);
					}
				});

				// alert(lnk_load);

				$('#skills_assessment_btn').click(function(){
					var str_val = "analytics/skills/" + $('#filter_dept').val() + "/" + $('#filter_from').val() + "/" + $('#filter_to').val();
					var lnkpath = "{{ URL::to('"+str_val+"') }}";

					$.ajax({
						url: lnkpath,
						type: 'GET',
						beforeSend: function(){
							$('#skills_assessment_btn').attr('disabled', 'disabled').html('Generating...');
						},
						success: function(response){
							$('#graph_1').html(response);
							$('#skills_assessment_btn').removeAttr('disabled').html('Generate');
							// alert(response);
						}
					});
				});
			});
		</script>


	@endsection
@stop