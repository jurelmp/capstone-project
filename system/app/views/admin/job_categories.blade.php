@extends('layout.index')

	@section('pagetitle')
		Job Categories
	@endsection

	@section('head')
	@endsection


	@section('content')

		<div class="container">

			<div class="panel panel-primary">
				<div class="panel-heading">Job Categories</div>

				<div class="panel-body">
					<div class="row">

						<div class="col-md-12">
							<div class="row">
					
								<div class="col-md-6">
									<button class="btn btn-md btn-success" data-toggle="modal" data-target="#add_category_form">
										<span class="glyphicon glyphicon-plus"></span> Add New Category</button>
								</div>
							</div>
							
						</div>

						<div class="col-md-12">
							<div id="accordion">
								<!-- <h3>ddd</h3>
								<div>
									<p>ddd</p>
								</div> -->

								@foreach($job_categories as $cat)
									<h3 class="cat_copy" rel="{{ $cat->id }}">{{ $cat->category }}</h3>
									<div>
										<p>
											<button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#add_job_form">Add Job</button>
											<div rel="{{ $cat->id }}">

											</div>
										</p>
									</div>
								@endforeach

							</div>

						</div>
					</div>

				</div>
			</div>
		</div>


		<div class="modal fade" id="add_job_form" tabindex="-1" role="dialog" aria-labelledby="job_label" aria-hidden="true">

			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="job_label">Add Job</h4>
					</div>
					<div class="modal-body">
						<label>Name</label>
						<input type="hidden" id="category_id">
						<input type="text" id="job_name" class="form-control">
					</div>
					<div class="modal-footer">
						<button class="btn btn-md btn-success" name="save_job">Add Job</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="add_category_form" tabindex="-1" role="dialog" aria-labelledby="category_label" aria-hidden="true">

			<div class="modal-dialog modal-md">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="category_label">Add Category</h4>
					</div>

					<div class="modal-body">
						<label>Name</label>
						<input type="text" id="category_name" class="form-control">
						
					</div>

					<div class="modal-footer">
						<button class="btn btn-md btn-success" name="save_category">Save</button>
					</div>
				</div>
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


				$('button[name=save_category]').click(function(){
					var lnkpath = "{{ URL::to('admin/add-category') }}";
					var name = $('#category_name').val();

					if(name == '' || name == '  '){
						alert('category name is a required field');
					} else{
						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'name': name
							},
							success: function(response){
								window.location.reload();
							}
						});
					}
				});

				$('.cat_copy').click(function(){
					var id = $(this).attr('rel');
					var lnkpath = "{{ URL::to('admin/view-category/"+id+"') }}";
					
					$.ajax({
						url: lnkpath,
						type: 'GET',
						success: function(response){
							$('div[rel='+id+']').html(response);
							$('#category_id').val(id);
						}
					});

				});

				$('button[name=save_job]').click(function(){
					var lnkpath = "{{ URL::to('admin/add-job') }}";
					var cat_id = $('#category_id').val();
					var name = $('#job_name').val();

					if(name == '' || name == '  '){
						alert('name is a required field');
					} else{
						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'name': name,
								'cat_id': cat_id
							},
							success: function(){
								$.ajax({
									url: "{{ URL::to('admin/view-category/"+cat_id+"') }}",
									type: 'GET',
									success: function(response){
										// $('#add_job_form').modal('hide');
										$('#job_name').val("");
										$('div[rel='+cat_id+']').html(response);
									}
								});
							}
						});
					}
						
				});
			});
		</script>
	@endsection
@stop