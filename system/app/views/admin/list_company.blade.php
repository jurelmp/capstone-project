@extends('layout.index')

	
	@section('pagetitle')
		Companies
	@endsection

	@section('head')
	@endsection

	@section('content')

		<div class="container">

			<div class="panel panel-primary">
				<div class="panel-heading">Companies</div>

				<div class="panel-body">

					<div class="row">
						<div class="col-md-12">

							<table class="table table-hover table-bordered default-table" id="company_table">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email / Website</th>
									</tr>
								</thead>
								<tbody>
									@foreach($companies as $company)
										<tr>
											<td>
												<?php 
													$id = $company->id;
													$str_url = 'admin/view-company/'.$id;
													$url = URL::to($str_url);
												?>
												<a href="{{ $url }}">
													{{ $company->name }}
												</a>
											</td>
											<td>{{ $company->email }}</td>
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

		<script type="text/javascript">
			$(document).ready(function(){

				$('#company_table').dataTable();
			});
		</script>
	@endsection
@stop