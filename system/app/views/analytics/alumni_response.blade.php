@extends('layout.index')

	@section('pagetitle')
		Alumni Response
	@endsection

	@section('head')
	@endsection

	@section('content')

		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">&nbsp;</div>

				<div class="panel-body">

					<!-- responses report -->
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<select id="filter_course">
										<option value="0">All</option>
									
										@foreach($course as $c)
											<option value="{{ $c->id }}">{{ $c->title }}</option>
									
										@endforeach
									</select>

									From
									<select id="response_from">
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
									<select id="response_to">
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

									<button id="response_generate">Generate</button>
								</div>
							</div>

							<div id="response_report"></div>
						</div>
					</div>
					<!-- end of responses report -->
							


				</div>
			</div>

		</div>
		<div class="container"></div>
		<script>

			$(function(){

				$.ajax({
					url: "{{ URL::to('analytics/graph-response/"+$("#filter_course").val()+"/"+$("#response_from").val()+"/"+$("#response_to").val()+"') }}",
					type: "GET",
					success: function(response){
						$('#response_report').html(response);
					}
				});

				$('#response_generate').click(function(){
					$.ajax({
						url: "{{ URL::to('analytics/graph-response/"+$("#filter_course").val()+"/"+$("#response_from").val()+"/"+$("#response_to").val()+"') }}",
						type: "GET",
						beforeSend: function(){
							$('#response_generate').attr('disabled', 'disabled').html('Generating...');
						},
						success: function(response){
							$('#response_report').html(response);
							$('#response_generate').removeAttr('disabled').html('Generate');
						}
					});
				});


			});
		</script>
	@endsection
@stop