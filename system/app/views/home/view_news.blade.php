@extends('layout.index')

	@section('pagetitle')
		@if($v_news != null)
			{{ $v_news{0}->title }}
		@endif
	@endsection

	@section('head')
	@endsection


	@section('content')

		<div class="container">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<!-- <div class="panel-heading"></div> -->

					<div class="panel-body">
						<a href="{{ URL::to('alumni/news') }}" class="text-primary pull-right">See all...</a><br>
						<hr>
						<h3 class="text-primary">{{ $v_news{0}->title }}</h3>
						<em>Posted by:</em> <b>{{ $v_news{0}->firstname }} {{ $v_news{0}->midname }} {{ $v_news{0}->lastname }}</b>
						<br>
						<?php
							$d = strtotime($v_news{0}->created_at);
							$month = date("M. d, Y D h:i a", $d);
							// $d
							// $time
						?>
						<em>Date posted:</em>&nbsp;<?php echo "".$month.""; ?>
						<hr>
						
						<div id="contain">
							{{ $v_news{0}->content }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container"></div>

	@endsection
@stop