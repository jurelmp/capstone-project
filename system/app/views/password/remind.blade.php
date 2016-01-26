@extends('layout.index')
	
	@section('pagetitle')
		Forgot Password
	@endsection

	@section('content')

		<div class="container">

			<div class="col-md-6 col-md-offset-3">
				<div class="jumbotron">

					<h4>Forgot your password ?</h4>
					<hr>
					<p class="text-info" style="font-size: 14px;">An email containing with password reset link will be send.</p>
					
					@if(Session::has('error'))
						<div class="alert alert-danger">
						{{ trans(Session::get('error')) }}
						</div>
					@elseif(Session::has('status'))
						<div class="alert alert-success">
						An email with the password reset has been sent.
						<!-- {{ trans(Session::get('success')) }} -->
						</div>
					@endif

					{{ Form::open(array('url' => 'password/remind')) }}

						<!-- <p> {{ Form::label('email', 'Email') }} -->
						<!-- {{ Form::text('email') }} </p> -->
						<!-- <p> {{ Form::submit('Submit') }} </p> -->
						<!-- <p><input type="submit" value="Submit" class="btn btn-md btn-success"></p> -->
						<div class="input-group">
							<div class="input-group-addon" style="font-size: 20px;">
								Email
							</div>
							<input type="text" name="email" class="form-control">
						</div>
						<br>
						<input type="submit" value="Submit" class="btn btn-md btn-success btn-block">
					{{ Form::close() }}

				</div>

			</div>

				
				

		</div>
			
	@endsection

@stop