@extends('layout.index')
	
	@section('pagetitle')
		Register
	@endsection


	@section('head')

		{{ HTML::style('css/sb-admin-2.css') }}

		<script>

			$(document).ready(function(){

				<?php

					if(Session::has('result')){
						$info = Session::get('result');
						// echo "<script>alert(".json_encode($info).")</script>";
						$result = json_encode($info);
				?>
					var result = <?php echo $result; ?>;
					var fname = result.first_name;
					var mname = result.middle_name;
					var lname = result.last_name;
					var email = result.email;

					$('input[name=username]').val(lname+fname);
					$('input[name=firstname]').val(fname);
					$('input[name=midname]').val(mname);
					$('input[name=lastname]').val(lname);
					$('input[name=email]').val(email);
				<?php
					}
				?>

				
				// alert(result.first_name);

				$('input[name=username], input[name=email], input[name=password], input[name=confirmpassword]').on('change', function(){
					var u = $('input[name=username]').val();
					var e = $('input[name=email]').val();
					var p = $('input[name=password]').val();
					var cp = $('input[name=confirmpassword]').val();

					if((u != '') && (e != '') && (p != '') && (cp != '')){
						if(p == cp){
							$('#reg_btn').prop('disabled', false);

							// alert(u + e + p + cp);
						} else {
							$('#reg_btn').prop('disabled', true);
						}
					} else {
						$('#reg_btn').prop('disabled', true);
					}
				});

			});

		</script>

	@endsection

	@section('content')
		<div class="container">
			<div class="col-md-6 centered">
				

				<div class="panel panel-green">
					<div class="panel-heading">Sign up.</div>
					<div class="panel-body">

						<!-- <p class="text-danger">Note: <br>Username should be unique.<br>Email should be unique.<br>Password should match with the confirm password field.</p> -->


						<div class="row">
							<div class="col-md-6">
								<img src="{{ URL::to('images/logo_brand.png') }}">
							</div>
							<div class="col-md-6">
								<img src="{{ URL::to('images/logo_head.png') }}" class="img-responsive" height="50px" width="190px">
							</div>
						</div>
						
						
							

						<div class="alert alert-info">
							The username must be at least 4 characters.<br>
							The email must be a valid email address.<br>
							The password must be at least 8 characters.<br>
						</div>

						@if($errors->has())
							<div class="alert alert-danger">
								{{ $errors->first('username') }} <br>
								{{ $errors->first('email') }} <br>
								{{ $errors->first('password') }}
							</div>
						@endif

						@if(Session::has('duplicate'))
							<div class="alert alert-danger">
								{{ Session::get('duplicate') }}
							</div>
						@endif

						<!-- <div class="alert alert-danger" style="display: none;" id="reg_null">
							The fields are required.
						</div>

						<div class="alertalert-danger" style="display: none;" id="reg_match">
							The password should match
						</div> -->

						

						{{ Form::open(array('url' => 'register', 'role' => 'form')) }}
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" class="form-control" name="username" required>
							</div>
							<div class="form-group">
								<label for="firstname">First name</label>
								<input type="text" class="form-control" name="firstname" required>
							</div>
							<div class="form-group">
								<label for="midname">Middle name</label>
								<input type="text" class="form-control" name="midname" required>
							</div>
							<div class="form-group">
								<label for="lastname">Last name</label>
								<input type="text" class="form-control" name="lastname" required>
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="text" class="form-control" name="email" required>
							</div>

							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" name="password" id="password" required>
							</div>
							<div class="form-group">
								<label for="confirmpassword">Confirm Password</label>
								<input type="password" class="form-control" name="confirmpassword" required>
							</div>

							<div class="row">
								<div class="col-md-3 pull-right">
									<input type="reset" value="Reset" class="btn btn-danger form-control">
								</div>
								<div class="col-md-3 pull-right">
									<input type="submit" value="Sign-up" class="btn btn-primary form-control" id="reg_btn">
								</div>
							</div>
						{{ Form::close() }}
					</div>
				</div>

				
			</div>

		</div>
		<div class="container"></div>
		

	@endsection

@stop