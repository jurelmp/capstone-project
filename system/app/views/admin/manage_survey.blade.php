@extends('layout.index')
	
	@section('pagetitle')
		Manage Survey
	@endsection

	@section('head')
	@endsection

	@section('content')

		<div class="container">
			<div class="panel panel-primary">

				<div class="panel-heading">&nbsp;</div>

				<div class="panel-body">
					
					<div id="tracer_survey">
							
							@if($questions != null)
								<div id="survey_form">
									<div id="accordion">
										@foreach($questions as $s_q)
											@if($s_q->id != 0)
											<?php
												$q_i = $s_q->id;
												$name_q = "question".$s_q->id;
												$cc = DB::select("SELECT * FROM survey_choices WHERE question_id = ?", array($q_i));
											?>
											
												<h3 class="question_copy" rel="{{ $s_q->id }}" id="{{ $name_q }}">{{ $s_q->question }}</h3>
												<div id="{{ $name_q }}">
													
													@if($s_q->type == 0)
														<textarea class="form-control" rows="2" name="{{ $name_q }}"></textarea>
													@elseif($s_q->type == 1)
														@foreach($cc as $c)
															<input type="radio" name="{{ $name_q }}" value="{{ $c->id }}">&nbsp;{{ $c->choice }}<br>
														@endforeach
													@elseif($s_q->type == 2)
														@foreach($cc as $c)
															<input type="checkbox" name="{{ $name_q }}" value="{{ $c->id }}">&nbsp;{{ $c->choice }}<br>
														@endforeach
															<!-- <input type="checkbox" name="{{ $name_q }}">&nbsp;Other -->
													@endif
												</div>
											
											@endif
										@endforeach
									</div><br>
									<button class="btn btn-md btn-success pull-right" id="survey_submit_btn">Submit</button>
								</div>
							

							@endif
							

						</div>
				</div>

				<!-- <div class="panel-footer">&nbsp;</div> -->
			</div>
		</div>

		<div class="container"></div>

		<script>
			$(function(){
				$('#accordion').accordion({
					collapsible: true,
			    	heightStyle: 'content',
			    	active: false
				});
			});
		</script>
	@endsection
@stop