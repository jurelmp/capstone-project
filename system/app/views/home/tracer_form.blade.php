@extends('layout.index')

	@section('pagetitle')
		Alumni Tracer
	@endsection

	@section('head')

		<script>

			$(document).ready(function(){

				$('#datepicker').datepicker();

				$('#region').on('change', function(){
					// alert($(this).val());
					var lnkpath = "{{ URL::to('alumni/province') }}";
					var r_id = $(this).val();

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'region_id': r_id
						},
						dataType: 'JSON',
						success: function(data){
							var str = '';
							for (var i = 0; i < data.length; i++) {
								str += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
							};
							$('#province').html(str);
							// alert(str);
						}
					});
				});

				$('#department').on('change', function(){
					var lnkpath = "{{ URL::to('alumni/course') }}";
					var dept_id = $(this).val();

					// alert(dept_id);
					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'dept_id': dept_id
						},
						dataType: 'JSON',
						success: function(course){
							var str = '';
							for (var i = 0; i < course.length; i++) {
								str += "<option value='" + course[i].id + "'>" + course[i].title + "</option>";
							};
							$('#course').html(str);
							// alert(str);
						}

					});
				});



			});

		</script>

	@endsection

	@section('content')
		<div class="container">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Alumni Tracer Survey Form</div>

					<div class="panel-body">
						<div class="col-md-8 centered">
							<fieldset>
								<legend>Personal Information</legend>
								<div class="row">
									<div class="col-md-6">
										<div class="input-group">
											<div class="input-group-addon">
												Student No.
											</div>
											<input type="text" class="form-control" placeholder="optional">
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<div class="input-group-addon">
												<span class="glyphicon glyphicon-picture"></span>
											</div>
											<input type="file" class="form-control">
										</div>
										
									</div>
								</div><br>
								<div class="row">
									&nbsp;&nbsp;&nbsp;&nbsp;<label>Full Name</label><br>
									<div class="col-md-4">
										<input type="text" class="form-control" placeholder="First name">
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" placeholder="Middle name">
									</div>
									<div class="col-md-4">
										<input type="text" class="form-control" placeholder="Family name">
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-4">
										<div style="width: 100%; border: 1px solid #c9c9c9; border-radius: 5px; padding: 7px 5px 6px 10px;">
											<label for="gender">
												Gender &nbsp;&nbsp;
											</label>
													<input type="radio" name="gender">&nbsp;Male
													&nbsp;
													<input type="radio" name="gender">&nbsp;Female
												
										</div>

										<!-- <label for="gender">Gender</label>
											<input type="radio" name="gender">Male
											<input type="radio" name="gender">Female -->
									</div>

									<div class="col-md-4">
										<div class="dropdown">
											<select class="form-control">
												<option>Civil Status</option>
												<option>Single</option>
												<option>Married</option>
												<option>Separated/Divorce</option>
												<option>Single parent</option>
												<option>Widow/Widower</option>
											</select>
										</div>
									</div>

									<div class="col-md-4">
										<div class="input-group">
											<div class="input-group-addon">
												Birth
											</div>
											<input type="text" id="datepicker" class="form-control" placeholder="mm/dd/yyyy">
										</div>
									</div>
								</div>
							</fieldset>
							<br><br>

							<fieldset>
								<legend>Contact Information</legend>
								<div class="row">
									<div class="col-md-12">
										<label for="address">Complete Address</label>
										<textarea rows="3" class="form-control"></textarea>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-4">
										<label for="email">Email</label>
										<input type="email" class="form-control" name="email">
									</div>
									<div class="col-md-4">
										<label for="tel-no">Phone number</label>
										<input type="text" class="form-control" name="tel-no">
									</div>
									<div class="col-md-4">
										<label for="mobile-no">Mobile number</label>
										<input type="text" class="form-control" name="mobile-no">
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<label for="region">Region of Origin</label>
										<select name="region" class="form-control" id="region">
											<option>SELECT</option>
											@if($regions != null)
												@foreach($regions as $region)
													<option value="{{ $region->id }}">{{ $region->name }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="col-md-6">
										<label for="province">Province</label>
										<select name="province" class="form-control" id="province"></select>
									</div>
								</div>

							</fieldset>
							<br><br>

							<fieldset>
								<legend>Education</legend>

								<div class="row">
									<div class="col-md-6">
										<label for="department">Department</label>
										<select name="department" class="form-control" id="department">
											<option>SELECT</option>
											@if($departments != null)
												@foreach($departments as $dept)
													<option value="{{ $dept->id }}">{{ $dept->name }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="col-md-6">
										<label for="course">Course</label>
										<select name="course" class="form-control" id="course"></select>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-md-6">
										<label for="term">Term</label>
										<select name="term" class="form-control">
											<option value="1">1st Sem</option>
											<option value="2">2nd Sem</option>
											<option value="3">Summer</option>
										</select>
									</div>

									<div class="col-md-6">
										<label for="yr_graduated">Year Graduated</label>
										<select name="yr_graduated" class="form-control">
											<?php
												$y = date('Y');
												for ($i=1995; $i <= $y; $i++) { 
													echo "<option>".$i."</option>";
												}
											?>
										</select>
									</div>
								</div>
							</fieldset>
							<br><hr>

							<button type="button" class="btn btn-md btn-success pull-right">Next</button>
						</div>
					</div>
				</div>
			</div>
				
		</div>
	@endsection

@stop