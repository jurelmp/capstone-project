<script>
	var g_name = '';
	var g_code = '';
	var g_desc = '';
	
	$('#dept_table').tablesorter();

	$('[data-toggle="tooltip"]').tooltip();

	$('#add_btn').on('click', function(){
		var name = $('#dept_name').val();
		var desc = $('#dept_desc').val();
		var code = $('#dept_code').val().toUpperCase();
		var lnkpath = "{{ URL::to('admin/createdept') }}";


		if(name === ''){
			$('#error').slideDown();
		} else {

			$.ajax({
				url: lnkpath,
				type: 'POST',
				data: {
					'name': name,
					'desc': desc,
					'code': code
				},
				success: function(data){
					// if(data == 'success'){
					// 	alert(data);
					// }
					$('#add_close_btn').click();
					// $('#dept_table').slideDown();

					var lnkpath = "{{ URL::to('admin/departments') }}";

					$.ajax({
						url: lnkpath,
						type: 'GET',
						dataType: 'HTML',
						success: function(data){
							var f = $(data).find('tr:last');
							// $('#table_content').replaceWith(data);
							// $('#table_content').slideDown();
							// $('tbody').append($(f).html());
							$('#dept_table tr:last').after("<tr>" + $(f).html() + "</tr>");
							// alert("<tr>" + $(f).html() + "</tr>");
						}
					});
				}
			});
		}

	});

	$('.courses_btn').on('click', function(){
		var id = $(this).attr('rel');
		var lnkpath = "{{ URL::to('admin/deptcourse') }}";
		

		$.ajax({
			url: lnkpath,
			type: 'POST',
			data: {
				'dept_id': id
			},
			dataType: 'JSON',
			success: function(data){
				var str = '';
				
				// $('p#crs_title').text(id);
				$('h4#courses').text(data[0].name);

				for(var d in data){
					if(data[d].code == null){
						str += "<a class='list-group-item'>No course.</a>";
					} else {
						str += "<a href='#' class='list-group-item' data-toggle='tooltip' data-placement='top' title='"+data[d].title+"'>"+ data[d].code +"</a>";

					}
				}
				$('#grp_course').html(str);
			}
		});
	});


	$('.edit_btn').on('click', function(){
		var id = $(this).attr('rel');
		var lnk = "{{ URL::to('admin/getdept') }}";

		$.ajax({
			url: lnk,
			type: 'POST',
			data: {
				'id': id
			},
			dataType: 'JSON',
			success: function(data){
				g_name = data[0].name;
				g_code = data[0].code;
				g_desc = data[0].description;
				$('#edit_dept_id').val(data[0].id);
				$('#edit_dept_name').val(data[0].name);
				$('#edit_dept_code').val(data[0].code);
				$('#edit_dept_desc').val(data[0].description);
			}
		});
	});

	$('#edit_btn').on('click', function(){
		var id = $('#edit_dept_id').val();
		var n = $('#edit_dept_name').val();
		var c = $('#edit_dept_code').val();
		var d = $('#edit_dept_desc').val();
		var lnk = "{{ URL::to('admin/updatedept') }}";

		if(n == g_name && c == g_code && d == g_desc){
			alert('No changes.');
			$('#edit_close_btn').click();
		} else {
			$.ajax({
				url: lnk,
				type: 'POST',
				data: {
					'id': id,
					'name': n,
					'code': c,
					'desc': d
				},
				success: function(data){
					if(data == 1){
						alert('Save changes.');
						window.location.reload();
					} else {
						alert('Something went wrong.');
					}
				}
			});
		}
	});

</script>

<div class="row">
	<h4 class="pull-left">Departments</h4>
	<button class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add_dept_form"><span class="glyphicon glyphicon-plus"></span></button>
</div>
<hr>
<div class="row">
	<table class="table table-hover table-bordered default-table" id="dept_table">
		<thead>
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Code</th>
				<th>No. of Programs</th>
			</tr>
		</thead>
		<tbody>
			@if($departments == null)
				<tr><td colspan="4">No Data</td></tr>
			@else
				@foreach($departments as $department)
					<tr>
						<td>{{ $department->id }}</td>
						<td>
							<a href="#" data-toggle="tooltip" data-placement="top" title="{{ $department->description }}" class="edit_name" rel="{{ $department->id }}">{{ $department->name }}</a>
							<a href="#" class="text-success pull-right edit_btn" rel="{{ $department->id }}" data-toggle="modal" data-target="#edit_dept_form" title="Update this department."><span class="glyphicon glyphicon-edit"></span></a>
							
						</td>
						<td>{{ $department->code }}</td>
						<td><a href="" class="courses_btn" data-toggle="modal" data-target="#show_courses" rel="{{ $department->id }}">{{ $department->courses }}</a></td>
					</tr>

				@endforeach
			@endif
			
		</tbody>
	</table>

	<center>
		<div id="pageNavPosition" class="pagination"></div>
	</center>

</div>
<br>
<div class="modal fade" id="add_dept_form" tabindex="-1" role="dialog" aria-labelledby="add_dept_label" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close" id="add_close_btn"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="add_dept_label">Add Department</h4>
			</div>

			<div class="modal-body">
				<div class="alert alert-danger" style="display: none;" id="error">The field name is required.</div>
				<label for="dept_name">Name</label>
				<input type="text" class="form-control" id="dept_name">
				<br>
				<label for="dept_code">Code (optional)</label>
				<input type="text" class="form-control" id="dept_code">
				<br>
				<label for="dept_desc">Description</label>
				<textarea class="form-control" id="dept_desc" rows="2"></textarea>	
			</div>

			<div class="modal-footer">
				<button class="btn btn-md btn-success" id="add_btn"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Save</button>
			</div>
		</div>
	</div>
</div>
<br>
<div class="modal fade" id="show_courses" tabindex="-1" role="dialog" aria-labelledby="courses" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="courses"></h4>
			</div>

			<div class="modal-body">
				<div class="list-group" id="grp_course">
					<!-- <p class="list-group-item" id="crs_title"></p> -->
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-md btn-default" type="button" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div> 
</div>
<br>
<div class="modal fade" id="edit_dept_form" tabindex="-1" role="dialog" aria-labelledby="edit_dept_label" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close" id="edit_close_btn"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="edit_dept_label">Update Department</h4>
			</div>

			<div class="modal-body">
				<div class="alert alert-danger" style="display: none;" id="error">The field name is required.</div>
				<input type="hidden" id="edit_dept_id">
				<label for="dept_name">Name</label>
				<input type="text" class="form-control" id="edit_dept_name">
				<br>
				<label for="dept_code">Code (optional)</label>
				<input type="text" class="form-control" id="edit_dept_code">
				<br>
				<label for="dept_desc">Description</label>
				<textarea class="form-control" id="edit_dept_desc" rows="4"></textarea>	
			</div>

			<div class="modal-footer">
				<button class="btn btn-md btn-success" id="edit_btn"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Update</button>
			</div>
		</div>
	</div>
</div>

<script>
	var pager = new Pager('dept_table', 5); 
    pager.init(); 
    pager.showPageNav('pager', 'pageNavPosition'); 
    pager.showPage(1);
</script>