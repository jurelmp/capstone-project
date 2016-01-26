@extends('layout.index')
	
	@section('pagetitle')
		{{ $department{0}->name }}
	@endsection

	@section('head')
	@endsection

	@section('content')

		<div class="container">
			<input type="hidden" id="department_id" value="{{ $department{0}->id }}">
			<div class="panel panel-primary">
				<div class="panel-heading">{{ $department{0}->name }}</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6"><h4>Programs</h4></div>
							<div class="col-md-6">
								<button class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add_program_form">Add Program</button>
							</div>
							<hr>
							<table class="table table-hover default-table" id="programs">
								<thead>
									<tr>
										<th>Title</th>
										<th>Code</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($programs as $program)
										<tr>
											<td>
												{{ $program->title }}
											</td>
											<td>{{ $program->code }}</td>
											<td>
												<a rel="{{ $program->id }}" href="#" data-toggle="modal" data-target="#update_program_form" class="show_update_program">
													<span class="glyphicon glyphicon-edit"></span>
												</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>


			<div class="modal fade" id="job_descriptions" tabindex="-1" style="display: none; z-index: 1050;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							
							<h4 class="modal-title">Job Descriptions</h4>
						</div>

						<div class="modal-body">
							<label>Job Category</label>
							<select class="form-control" id="filter_job_category">
								<option value="0">--select a job category--</option>
								@foreach($job_categories as $job_category)
									<option value="{{ $job_category->id }}">{{ $job_category->category }}</option>
								@endforeach
							</select>
							<label>Jobs</label>
							<select class="form-control" id="jobs">

							</select>
						</div>

						<div class="modal-footer">
							<button class="btn btn-danger btn-md" data-dismiss="modal">Cancel</button>
							<button class="btn btn-success btn-md" id="add_job">Add</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="update_program_form" role="dialog" aria-labelledby="update_program_label" aria-hidden="true">

				<div class="modal-dialog modal-md">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="update_program_label">Update Program</h4>
						</div>

						<div class="modal-body">
							<input type="hidden" id="update_program_id">
							<label>Title</label>
							<input type="text" id="update_program_title" class="form-control">
							
							<label>Code</label>
							<input type="text" id="update_program_code" class="form-control">

							<label>Job Description</label>
							<select class="form-control" multiple="multiple" size="10" id="update_program_job_desc">
															
							</select>

							<button data-toggle="modal" data-target="#job_descriptions" class="btn btn-primary btn-xs">Add Job Description</button>
						</div>

						<div class="modal-footer">
							<button class="btn btn-md btn-success" name="update_program_btn">Update</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="add_program_form" role="dialog" aria-labelledby="add_program_label" aria-hidden="true">

				<div class="modal-dialog modal-md">
					<div class="modal-content">

						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="update_program_label">Add Program</h4>
						</div>

						<div class="modal-body">
							<label>Title</label>
							<input type="text" id="add_program_title" class="form-control">
							
							<label>Code</label>
							<input type="text" id="add_program_code" class="form-control">

							
						</div>

						<div class="modal-footer">
							<button class="btn btn-md btn-success" id="add_program_btn">Save</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container"></div>

		<script>
			$(function(){

				var program_job_desc = null;

				$('#programs').dataTable();

				$('.show_update_program').click(function(){
					var id = $(this).attr('rel');
					var lnkpath = "{{ URL::to('admin/program/"+id+"') }}";

					$.ajax({
						url: lnkpath,
						type: 'GET',
						dataType: 'JSON',
						success: function(data){
							$('#update_program_id').val(data[0].id);
							$('#update_program_title').val(data[0].title);
							$('#update_program_code').val(data[0].code);

							$.ajax({
								url: "{{ URL::to('admin/program-job-descriptions/"+id+"') }}",
								type: 'GET',
								dataType: 'JSON',
								success: function(jobs){
									var str = '';
									program_job_desc = jobs;

									for(var i=0; i < jobs.length; i++){
										str += "<option>"+jobs[i].job+"</option>";
									}

									$('#update_program_job_desc').html(str);
									
								}
							});
						}
					});
				});

				$('#filter_job_category').change(function(){
					var id = $(this).val();
					var lnkpath = "{{ URL::to('admin/jobs-by-category/"+id+"') }}";

					$.ajax({
						url: lnkpath,
						type: 'GET',
						dataType: 'JSON',
						success: function(data){
							str = '';
							// for(var i=0;i<data.length;i++){
							// 	str += "<option value='"+data[i].id+"'>"+data[i].job+"</option>";
							// }
							for(var j=0;j<data.length;j++){
								var i;
								var test = 0;
								for(i=0;i<program_job_desc.length;i++){
									if(program_job_desc[i].job_id == data[j].id){
										break;
									}
								}
								if(i == program_job_desc.length){
									str+= "<option value='"+data[j].id+"'>"+data[j].job+"</option>";
								}
							}
							$('#jobs').html(str);
						}
					});
				});


				$('#add_job').click(function(){
					var lnkpath = "{{ URL::to('admin/add-job-description') }}";
					var course_id = $('#update_program_id').val();
					var job_id = $('#jobs').val();
					var job_text = $('#jobs option:selected').html();

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'course_id': course_id,
							'job_id': job_id
						},
						success: function(data){
							if(data == 1){
								var opt = new Option(job_text, job_id);
								$(opt).html(job_text);
								$('#update_program_job_desc').append(opt);
								
								program_job_desc.push({
									'id': 0,
									'job_id': job_id,
									'job': job_text
								});
							}
						}
					});

					$('#job_descriptions').modal('hide');

				});

				$('button[name=update_program_btn]').click(function(){
					var lnkpath = "{{ URL::to('admin/update-program') }}";
					var id = $('#update_program_id').val();
					var code = $('#update_program_code').val();
					var title = $('#update_program_title').val();

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'id': id,
							'code': code,
							'title': title
						},
						success: function(data){
							if(data == 'success'){
								alert('updated successfully');
								window.location.reload();
							}
						}
					});
				
				});

				$('#add_program_btn').click(function(){
					var lnkpath = "{{ URL::to('admin/add-program') }}";
					var code = $('#add_program_code').val();
					var title = $('#add_program_title').val();
					var dept_id = $('#department_id').val();

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'code': code,
							'title': title,
							'dept_id': dept_id
						},
						success: function(data){
							if(data == 'success'){
								alert('added successfully');
								window.location.reload();
							}
						}
					});
				
				});


			});
		</script>
	@endsection
@stop