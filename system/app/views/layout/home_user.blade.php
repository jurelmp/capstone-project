@extends('layout.index')
	

	@section('pagetitle')
		Alumni Tracer System
	@endsection

	@section('head')
	@endsection

	@section('content')

		<div class="container">

			@if(Session::has('unauthorized'))
				<div class="alert alert-danger">
					{{ Session::get('unauthorized') }}
				</div>

			@endif
			Welcome {{ Auth::user()->firstname }}
		</div>

	@endsection

@stop