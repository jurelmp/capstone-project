@extends('layout.index')
	
	@section('pagetitle')
		Login
	@endsection


	@section('head')
		<script>
			$(document).ready(function(){

				// $('#show_forgot').click(function(){
				// 	$.fancybox.open('#forgot_form');

				// });

			});

		</script>
	@endsection

	@section('content')
		<div class="container">
			<div class="col-md-6 centered">
				<div class="panel panel-primary">
					<!-- <div class="panel-heading">Login</div> -->
					<div class="panel-body">
						<center>
						<img src="{{ URL::to('images/logo_head.png') }}" class="img-responsive" height="40px" width="500px">
						</center>

						@if($errors->has())
							<div class="alert alert-danger" role="alert">
								{{ $errors->first('username') }}
								{{ $errors->first('password') }}
							</div>
						@endif

						@if(Session::has('unauth'))
							<div class="alert alert-danger" role="alert">
								{{ Session::get('unauth') }}
							</div>
						@endif

						@if(Session::has('loginmsg'))
							<div class="alert alert-danger" role="alert">
								{{ Session::get('loginmsg') }}
							</div>
						@endif

						@if(Session::has('logoutmsg'))
							<div class="alert alert-success" role="alert">
								{{ Session::get('logoutmsg') }}
							</div>
						@endif

						@if(Session::has('success'))
							<div class="alert alert-success" role="alert">
								{{ Session::get('success') }}
							</div>
						@endif

						{{ Form::open(array('url' => 'login', 'role' => 'form')) }}
							<div class="form-group">
								<!-- <label for="username">Username</label> -->
								<div class="input-group">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-user text-info"></span>
									</div>
									<input type="text" class="form-control" name="username" placeholder="Username">
								</div>
							</div>

							<div class="form-group">
								<!-- <label for="password">Password</label> -->
								<div class="input-group">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-lock text-info"></span>
									</div>

									<input type="password" class="form-control" name="password" placeholder="Password">
								</div>
							</div>

							<div class="checkbox">
								<label>
									<input type="checkbox" name="keepme" value="1" checked="checked">Keep me signed in.
								</label>
								<a href="{{ URL::to('password/remind') }}" class="pull-right" id="show_forgot">Forgot Password?</a>
							</div>

							<input type="submit" value="Sign-in" class="btn btn-success form-control">
						{{ Form::close() }}
						<br>
						or <a href="{{ URL::to('register') }}">Create an account.</a>


					</div>
				</div>

				
			</div>

		</div>

		<div class="container"></div>

		<!-- <div id="forgot_form" style="display:none; width: 400px;" class="col-md-6">
			
			<div class="form-group">
				<label for="email">Email</label>
				<input class="form-control" name="email" id="email">
			</div>

			<button class="btn btn-success btn-md form-control">Send</button>

				
		</div> -->

	@endsection

@stop