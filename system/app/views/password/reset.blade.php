@extends('layout.index')



	@section('pagetitle')
		Reset Password
	@endsection

	@section('head')
	@endsection


	@section('content')

		<div class="container">

			<div class="col-md-6 col-md-offset-3">
				<div class="jumbotron">
					<h4>Reset Password</h4>
					<hr>

					@if(Session::has('error'))
						<div class="alert alert-danger">
						{{ trans(Session::get('error')) }}
						</div>
					@endif
					<div class="row">
						<div class="col-md-12">

							{{ Form::open(array('url' => array('password/reset', $token))) }}
						
								<p> {{ Form::label('email', 'Email') }}
								{{ Form::text('email', null, array('class' => 'form-control')) }} </p>

								<p> {{ Form::label('password', 'Password') }}
								{{ Form::password('password', array('class' => 'form-control')) }} </p>

								<p> {{ Form::label('password_confirmation', 'Password Confirm') }}
								{{ Form::password('password_confirmation', array('class' => 'form-control')) }} </p>

								{{ Form::hidden('token', $token) }}

								<!-- <p> {{ Form::submit('Submit') }} </p> -->

								<input type="submit" class="btn btn-md btn-success" value="Reset Password">

							{{ Form::close() }}
						</div>
					</div>
					

				</div>	
			</div>
					

		</div>
			
	@endsection
		


@stop