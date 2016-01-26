@extends('layout.index')

	@section('pagetitle')
		Departments
	@endsection

	@section('head')
	@endsection

	@section('content')

		<div class="container">

			<div class="panel panel-primary">
				<div class="panel-heading">Departments</div>

				<div class="panel-body">

					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add_dept_form">Add</button>
									<br>
								</div>
							</div>

							<table class="table table-hover default-table" id="results">
								<thead>
									<tr>
										<th>Name</th>
										<th>Code</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($departments as $dept)

										<tr>
											<td>
												<?php
													$url = URL::to('admin/department/'.$dept->id);
												?>
												<a href="{{ $url }}">
													{{ $dept->name }}
												</a>
											</td>
											<td>{{ $dept->code }}</td>
											<td>
												<a rel="{{ $dept->id }}" href="#" class="update_dept" data-toggle="modal" data-target="#update_dept_form"><span class="glyphicon glyphicon-edit"></span></a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

				{{-- <div class="panel-footer"></div> --}}
			</div>


			<div class="modal fade" id="update_dept_form" tabindex="-1" role="dialog" aria-labelledby="update_dept_label" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal" aria-label="Close" id="update_close_btn"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="update_dept_label">Update Department</h4>
						</div>

						<div class="modal-body">
							<div class="alert alert-danger" style="display: none;" id="error">The field name is required.</div>
							<label for="dept_name">Name</label>
							<input type="hidden" id="update_dept_id">
							<input type="text" class="form-control" id="update_dept_name">
							<br>
							<label for="dept_code">Code (optional)</label>
							<input type="text" class="form-control" id="update_dept_code">
							<br>
							<label for="dept_desc">Description</label>
							<textarea class="form-control" id="update_dept_desc" rows="2"></textarea>	
						</div>

						<div class="modal-footer">
							<button class="btn btn-md btn-success" id="update_btn"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Save</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="add_dept_form" tabindex="-1" role="dialog" aria-labelledby="add_dept_label" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" type="button" data-dismiss="modal" aria-label="Close" id="add_close_btn"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="add_dept_label">Create Department</h4>
						</div>

						<div class="modal-body">
							<div class="alert alert-danger" style="display: none;" id="error">The field name is required.</div>
							<label for="dept_name">Name</label>
							<input type="text" class="form-control" id="add_dept_name">
							<br>
							<label for="dept_code">Code (optional)</label>
							<input type="text" class="form-control" id="add_dept_code">
							<br>
							<label for="dept_desc">Description</label>
							<textarea class="form-control" id="add_dept_desc" rows="2"></textarea>	
						</div>

						<div class="modal-footer">
							<button class="btn btn-md btn-success" id="add_btn"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Save</button>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="container"></div>

		<script>

			$(function(){

				$('#results').dataTable();

				$('.update_dept').click(function(){
					var id = $(this).attr('rel');
					var lnkpath = "{{ URL::to('admin/view-department/"+id+"') }}";

					$.ajax({
						url: lnkpath,
						type: "GET",
						dataType: "JSON",
						success: function(data){
							$('#update_dept_id').val(data[0].id);
							$('#update_dept_name').val(data[0].name);
							$('#update_dept_code').val(data[0].code);
							$('#update_dept_desc').val(data[0].description);
						}
					});
				});

				$('#update_btn').click(function(){
					var lnkpath = "{{ URL::to('admin/updatedept') }}";
					var id = $('#update_dept_id').val();
					var name = $('#update_dept_name').val();
					var code = $('#update_dept_code').val();
					var desc = $('#update_dept_desc').val();

					$.ajax({
						url: lnkpath,
						type: "POST",
						data: {
							'id': id,
							'name': name,
							'code': code,
							'desc': desc
						},
						success: function(data){
							if(data == 0)
								alert('Something went wrong.');
							else
								window.location.reload();
						}
					});
				});

				$('#add_btn').click(function(){
					var lnkpath = "{{ URL::to('admin/createdept') }}";
					var name = $('#add_dept_name').val();
					var code = $('#add_dept_code').val();
					var desc = $('#add_dept_desc').val();

					$.ajax({
						url: lnkpath,
						type: "POST",
						data: {
							'name': name,
							'code': code,
							'desc': desc
						},
						success: function(data){
							if(data == 'fail')
								alert('Something went wrong.');
							else
								window.location.reload();
						}
					});
				});

			});
		</script>
	@endsection
@stop