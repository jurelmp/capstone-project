@extends('layout.index')
	
	@section('pagetitle')
		Employability
	@endsection

	@section('head')

		

		<script>
			$(document).ready(function(){
				var lnk_not_employed = "{{ URL::to('analytics/not-employed/"+$("#not_employed_dept").val()+"/"+$("#not_employed_from").val()+"/"+$("#not_employed_to").val()+"') }}";
				$.ajax({
					url: lnk_not_employed,
					type: 'GET',
					beforeSend: function(){
						// $('#not_employed_generate').attr('disabled', 'disabled').html('Generating...');
					},
					success: function(response){
						$('#not_employed_container').html(response);
					}
				});

				$('#not_employed_generate').click(function(){
					var from = $('#not_employed_from').val();
					var to = $('#not_employed_to').val();
					var dept = $('#not_employed_dept').val();

					var lnkpath = "{{ URL::to('analytics/not-employed/"+dept+"/"+from+"/"+to+"') }}";

					$.ajax({
						url: lnkpath,
						type: 'GET',
						beforeSend: function(){
							$('#not_employed_generate').attr('disabled', 'disabled').html('Generating...');
						},
						success: function(response){
							$('#not_employed_container').html(response);
							$('#not_employed_generate').removeAttr('disabled').html('Generate');
							// alert(response);
						}
					});

				});


				var lnk_sum_emp_stat = "{{ URL::to('analytics/summary-employment-status') }}";
				$.ajax({
					url: lnk_sum_emp_stat,
					type: 'GET',
					data: {
						'from': $('#summary_es_from').val(),
						'to': $('#summary_es_to').val(),
						'department': $('#summary_es_dept').val(),
						'emp_status': $('#summary_es_emp_status').val()
					},
					beforeSend: function(){
						// $('#summary_es_generate').attr('disabled', 'disabled').html('Generating...');
					},
					success: function(response){

						// $('#summary_es_generate').removeAttr('disabled').html('Generate');
						$('#summary_employment_status').html(response);
						// alert(response);
					}
				});
				
				var lnk_emp_stat = "{{ URL::to('analytics/employment-status/"+$("#filter_course").val()+"') }}";
				$.ajax({
					url: lnk_emp_stat,
					type: 'GET',
					data: {
						'filter_course': null
					},
					beforeSend: function(){
						// $('#employment_status_generate').attr('disabled', 'disabled').html('Generating...');
					},
					success: function(response){
						// $('#employment_status_generate').removeAttr('disabled').html('Generate');
						$('#emp_status').html(response);
						// alert(response);
					}
				});
				var lnk_fld_sp = "{{ URL::to('analytics/field-specialization/"+$("select[name=fs_from]").val()+"/"+$("select[name=fs_to]").val()+"') }}";
				$.ajax({
					url: lnk_fld_sp,
					type: 'GET',
					beforeSend: function(){
						// $('#fs_generate_btn').attr('disabled', 'disabled').html('Generating...');
					},
					success: function(response){
						$('#field_specialization').html(response);
						// $('#fs_generate_btn').removeAttr('disabled').html('Generate');
						// alert(response);
					}
				});
				
				

				$('body').delegate('#employment_status_generate', 'click', function(){
					var filter = $('#filter_course').val();
					var lnk = "{{ URL::to('analytics/employment-status/"+filter+"') }}";
					$.ajax({
						url: lnk,
						type: 'GET',
						data: {
							'filter_course': null
						},
						beforeSend: function(){
							$('#employment_status_generate').attr('disabled', 'disabled').html('Generating...');
						},
						success: function(response){
							$('#employment_status_generate').removeAttr('disabled').html('Generate');
							$('#emp_status').html(response);
							// alert(response);
						}
					})
				});

				$('#fs_generate_btn').on('click', function(){
					var from = $('select[name=fs_from]').val();
					var to = $('select[name=fs_to]').val();

					var lnk = "{{ URL::to('analytics/field-specialization/"+from+"/"+to+"') }}";
					
					if(from > to){
						alert('Invalid Batch Range.')
					} else{
						$.ajax({
							url: lnk,
							type: 'GET',
							beforeSend: function(){
								$('#fs_generate_btn').attr('disabled', 'disabled').html('Generating...');
							},
							success: function(response){
								$('#field_specialization').html(response);
								$('#fs_generate_btn').removeAttr('disabled').html('Generate');
								// alert(response);
							}
						});
					}
						
					// alert(lnk);
				});


				$('#summary_es_generate').on('click', function(){
					var lnkpath = "{{ URL::to('analytics/summary-employment-status') }}";

					var from = $('#summary_es_from').val();
					var to = $('#summary_es_to').val();
					var dept = $('#summary_es_dept').val();
					var emp_status = $('#summary_es_emp_status').val();

					$.ajax({
						url: lnkpath,
						type: 'GET',
						data: {
							'from': from,
							'to': to,
							'department': dept,
							'emp_status': emp_status
						},
						beforeSend: function(){
							$('#summary_es_generate').attr('disabled', 'disabled').html('Generating...');
						},
						success: function(response){

							$('#summary_es_generate').removeAttr('disabled').html('Generate');
							$('#summary_employment_status').html(response);
							// alert(response);
						}
					});

				});

					
				

			});
				
		</script>

	@endsection

	@section('content')

		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">&nbsp;</div>

				<div class="panel-body">


					<!-- graph for reasons not employed -->
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									College:
									<select id="not_employed_dept">
										<option value="0">All</option>
										@foreach($department as $d)
											<option value="{{ $d->id }}">{{ $d->name }}</option>
										@endforeach
									</select>
									From
									<select id="not_employed_from">
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
									<select id="not_employed_to">
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

									<button id="not_employed_generate">Generate</button>
								</div>

								<div class="col-md-12" id="not_employed_container">

								</div>
							</div>
						</div>
					</div>
					<!-- end of graph for reasons not employed -->



					<!-- graph no. 3 -->
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								Filter by:
								<select id="summary_es_emp_status">
									<option value="36">Employed</option>
									<option value="37">Not Employed</option>
									<option value="38">Never Employed</option>
								</select>
								&nbsp;
								College:
								<select id="summary_es_dept">
									<option value="0">All</option>
									@foreach($department as $d)
										<option value="{{ $d->id }}">{{ $d->name }}</option>
									@endforeach
								</select>
								From
								<select id="summary_es_from">
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
								<select id="summary_es_to">
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

								<button class="btn btn-md btn-success" id="summary_es_generate">Generate</button>
							</div>

							<div id="summary_employment_status"></div>
						</div>
					</div>
					<!-- end of grapph no. 3 -->


					<!-- graph no. 1 -->
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-4">
									<select class="form-control" id="filter_course">
										<option val="0">All</option>
										@foreach($course as $c)
											<option value="{{ $c->id }}">{{ $c->title }}</option>
										@endforeach
									</select>
								</div>
								<button class="btn btn-md btn-success" id="employment_status_generate">Generate</button>
							</div>
							<div class="row" id="emp_status">

							</div>
						</div>
					</div>
					<!-- end of graph no. 1 -->

					<!-- graph no. 2 -->
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-4">
									<div class="col-md-2">
										Batch
									</div>
									<div class="col-md-4">
										<select class="form-control" name="fs_from">
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
									</div>
									<div class="col-md-2">
										To
									</div>
									<div class="col-md-4">
										<select class="form-control" name="fs_to">
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
									</div>
										
								</div>
								<button class="btn btn-md btn-success" id="fs_generate_btn">Generate</button>
							</div>
							<div id="field_specialization">

							</div>
						</div>
					</div>
					<!-- end of graph no. 2 -->

					


					
				</div>

				<div class="panel-footer">&nbsp;</div>
			</div>


		</div>
		<div class="container"></div>

	@endsection

@stop