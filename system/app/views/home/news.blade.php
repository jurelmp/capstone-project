@extends('layout.index')

	@section('pagetitle')
		News
	@endsection

	@section('head')
		{{ HTML::style('css/sb-admin-2.css') }}
	@endsection

	@section('content')
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">News &amp; Announcements</div>
				<div class="panel-body">
					<div class="col-md-9 col-sm-9 col-xs-9">

						@foreach($h_news as $n)
							<div class="panel panel-green">
								<div class="panel-body">
									
									<div id="news_content">
										<?php
											$str = 'alumni/viewnews/'.$n->id;
											$url = URL::to($str);
										?>
										
										<h3 class="text-primary"><a href="{{ $url }}"> {{ $n->title }} </a></h3>
											<em>Posted by:</em> <b>{{ $n->firstname }} {{ $n->midname }} {{ $n->lastname }}</b>
											<br>
											<?php
												$d = strtotime($n->created_at);
												$month = date("M. d, Y D h:i a", $d);
												// $d
												// $time
											?>
											<em>Date posted:</em>&nbsp;<?php echo "".$month.""; ?>
									</div>

								</div>
							</div>
						@endforeach
					</div>


					<div class="col-md-3 col-sm-3 col-xs-3">
						<div class="panel panel-success">
							<!-- <div class="panel-heading">Latest News</div> -->
							<div class="panel-body">
								<div class="list-group">
									@if($latest != null)
										@foreach($latest as $l_news)
											<?php
												$str2 = 'alumni/viewnews/'.$l_news->id;
												$url2 = URL::to($str2);
											?>
											<a href="{{ $url2 }}" class="list-group-item">{{ $l_news->title }}</a>
										
										@endforeach
									@else
										<a class="list-group-item">No Latest News</a>
									@endif
								</div>
								<!-- <a href="#" class="btn btn-md btn-default btn-block">View All  News</a> -->
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="container"></div>
	@endsection


	

@stop