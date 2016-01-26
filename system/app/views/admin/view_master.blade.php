@extends('layout.index')

	@section('pagetitle')
		Master
	@endsection

	@section('head')

		<script>

			$(document).ready(function(){

				var url = "{{ URL::to('admin/departments') }}";
				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'HTML',
					success: function(data){
						$('#table_content').html(data);
						$('#table_content').slideDown();
					}
				});


				$('#show_dept').on('click', function(){
					var lnkpath = "{{ URL::to('admin/departments') }}";
					$('#table_content').slideUp();

					$.ajax({
						url: lnkpath,
						type: 'GET',
						dataType: 'HTML',
						success: function(data){
							$('#table_content').html(data);
							$('#table_content').slideDown();
						}
					});
				});


				$('#show_course').on('click', function(){
					var lnkpath = "{{ URL::to('admin/courses') }}";
					$('#table_content').slideUp();

					$.ajax({
						url: lnkpath,
						type: 'GET',
						dataType: 'HTML',
						success: function(data){
							$('#table_content').html(data);
							$('#table_content').slideDown();
						}
					});
				})


			});

		</script>
	@endsection


	@section('content')

		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">&nbsp;</div>


				<div class="panel-body">
					<div class="col-md-3">
						<div class="list-group">
							<a href="#" class="list-group-item" id="show_course">Programs/Course</a>
							<a href="#" class="list-group-item" id="show_dept">Departments</a>
							<!-- <a href="#" class="list-group-item" id="show_tracer">Tracer Questions</a> -->
						</div>
					</div>

					<div class="col-md-9" id="table_content" style="display: none;">

					</div>
				</div>
			</div>
		</div>
		<div class="container"></div>

	@endsection
@stop