@extends('layout.index')
	
	@section('pagetitle')
		{{ $info{0}->firstname }}
	@endsection
	
	@section('head')
	@endsection

	@section('content')
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-body">
							

					<div class="row">
						<div class="col-md-3 col-md-offset-1">
							<?php
								if($info{0}->pic_path != null) {
									$l = $info{0}->pic_path;
								} else {
									$l = "images/unknown.png";
								}
								$lnk = URL::to($l);
							?>
							<img src="{{ $lnk }}" class="img-rounded img-thumbnail img-responsive" height="200" width="200">

							<div class="row">
								<div class="col-md-12">
									@if($survey == null)
										<span class="label label-danger">survey not yet taken</span>
									@else
										<span class="label label-success">survey taken</span>
									@endif

									@if($info{0}->is_confirmed == 1)
										<span class="label label-success">verified</span>
									@else
										<span class="label label-danger">not verified</span>	
									@endif
								</div>
							</div>
						</div>

						<div class="col-md-7">
							<h3 class="text-primary">
							{{ $info{0}->firstname }}
							{{ $info{0}->midname }}
							{{ $info{0}->lastname }}
							</h3>
							<p>{{ $info{0}->course }} ({{ $info{0}->code }})</p>
							<hr>
							<table class="table table-bordered">
								<tr>
									<td width="25%">Student Number</td>
									<td width="25%"> {{ $info{0}->stud_no }}</td>
									<td width="25%">Gender</td>
									<td width="25%">
										@if($info{0}->gender == 1)
											Male
										@else
											Female
										@endif
									</td>
									
								</tr>
								<tr>
									<td>Civil Status</td>
									<td>
										@if($info{0}->civil_stat == 1)
											Single
										@elseif($info{0}->civil_stat == 2)
											Married
										@elseif($info{0}->civil_stat == 3)
											Separated Divorce
										@elseif($info{0}->civil_stat == 4)
											Single Parent
										@elseif($info{0}->civil_stat == 5)
											Widow/Widower
										@endif
									</td>
									<td>Birthdate</td>
									<td>
										<?php
											echo date('M. d, Y', strtotime($info{0}->birthdate));
										?>
									</td>
								</tr>
								<tr>
									<td>Tel. Number</td>
									<td> {{ $info{0}->tel_no }} </td>
									<td>Mobile Number</td>
									<td> {{ $info{0}->mobile_no }}</td>
								</tr>
								<tr>
									<td>Region</td>
									<td> {{ $info{0}->region }}</td>
									<td>Province</td>
									<td> {{ $info{0}->province }}</td>
								</tr>
								<tr>
									<td>Complete Address</td>
									<td colspan="3"> {{ $info{0}->address }}</td>
								</tr>
							</table>

						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<h4>Educational Background</h4>
							<table class="table table-bordered table-hover default-table">
								<thead>
									<tr>
										<th>Title</th>
										<th>Program</th>
										<th>School Attended</th>
										<th>Year Graduated</th>
										<th>Awards</th>
									</tr>
								</thead>
								<tbody>
									@if($degree == null)
										<tr><td colspan="5" align="center">No Degree</td></tr>
									@else

										@foreach($degree as $d)
											<tr>
												<td>{{ $d->title }}</td>
												<td>{{ $d->program }}</td>
												<td>{{ $d->school_name }}</td>
												<td>
													@if($d->year_graduated == 0)
														ON-GOING
													@else
														{{ $d->year_graduated }}
													@endif
												</td>
												<td>{{ $d->awards }}</td>
											</tr>
										@endforeach

									@endif
								</tbody>
							</table>
						</div>
					</div>

					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<h4>Professional Examination Passed</h4>
							<table class="table table-bordered table-hover default-table">
								<thead>
									<tr>
										<th>Name of Examination</th>
										<th>Date Taken</th>
										<th>Rating</th>
									</tr>
								</thead>
								<tbody>
									@if($exam == null)
										<tr><td colspan="3" align="center">No Examination Passed</td></tr>
									@else

										@foreach($exam as $e)
											<tr>
												<td>{{ $e->title }}</td>
												<td>
													<?php
														echo date('M. d, Y', strtotime($e->date_taken));
													?>
												</td>
												<td>{{ $e->rating }}</td>
											</tr>
										@endforeach

									@endif
								</tbody>
							</table>
						</div>
					</div>

					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<h4>Work Experience</h4>
							<table class="table table-bordered table-hover default-table">
								<thead>
									<tr>
										<th>Company</th>
										<th>Occupation</th>
										<th>Place of Work</th>
										<th>Date Hired</th>
										<th>Date Finish</th>
									</tr>
								</thead>
								<tbody>
									@if($work == null)
										<tr><td colspan="5" align="center">No Work Experience</td></tr>
									@else

										@foreach($work as $w)
											<tr>
												<td>{{ $w->name }}</td>
												<td>{{ $w->title }}</td>
												<td>
													@if($w->place_of_work == 1)
														Local
													@else
														Abroad
													@endif
												</td>
												<td>
													<?php
														echo date('M. d, Y', strtotime($w->date_hired));
													?>
												</td>
												<td>
													<?php
														echo date('M. d, Y', strtotime($w->date_finished));
													?>
												</td>
											</tr>
										@endforeach

									@endif
								</tbody>
							</table>
						</div>
					</div>


				</div>
			</div>
		</div>

		<div class="container"></div>
	@endsection
@stop