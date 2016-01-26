@extends('layout.index')


	@section('pagetitle')
		{{ $company->name }}
	@endsection

	@section('head')
	@endsection


	@section('content')

		<div class="container">
			<div class="panel panel-primary">

				<div class="panel-heading">{{ $company->name }}</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								Address
								<textarea class="form-control" rows="6" disabled>{{ $company->address }}</textarea>
							</div>
							<div class="col-md-6">
								Email / Website
								<input type="text" class="form-control" disabled value="{{ $company->email }}">
								Telephone
								<input type="text" class="form-control" disabled value="{{ $company->tel_no }}">
								Mobile
								<input type="text" class="form-control" disabled value="{{ $company->mobile_no }}">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">

							<table class="table table-hover table-bordered default-table">
								<thead>
									<tr>
										<th>Name</th>
										<th>Date Hired</th>
										<th>Date Finished</th>
										<th width="500px">Occupation</th>
									</tr>
								</thead>
								<tbody>
									
									@foreach($employees as $emp)
										<tr>
											<td>
												<?php
													$a_id = $emp->id;
													$str = "admin/profile/".$a_id;
													$link = URL::to($str);
												?>
												<a href="{{ $link }}">
													{{ $emp->firstname }}&nbsp;
													{{ $emp->midname }}&nbsp;
													{{ $emp->lastname }}
												</a>
											</td>
											<td>
												<?php
													echo date('M. d, Y', strtotime($emp->date_hired));
												?>
											</td>
											<td>
												<?php
													echo date('M. d, Y', strtotime($emp->date_finished));
												?>
											</td>
											<td>{{ $emp->title }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>

		</div>

		<div class="container"></div>

		<script type="text/javascript"></script>
	@endsection
@stop