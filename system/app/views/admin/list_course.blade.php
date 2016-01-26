<script>

	$('#update_program').click(function(){

		var id = $(this).attr('rel');

		// alert(id);
	});

	$('#add_program_save').click(function(){
		var lnkpath = "{{ URL::to('admin/courses') }}";
		var lnkpath2 = "{{ URL::to('admin/coursenew') }}";

		var prog_title = $('input[name=prog_title]').val();
		var prog_dept = $('select[name=prog_dept]').val();
		var prog_desc = $('textarea[name=prog_desc]').val();
		var prog_code = $('input[name=prog_code]').val();

		if(prog_title == '') {
			alert('Please provide the title.');
		} else if(prog_dept === '') {
			alert('Please select a department.');
		} else {
			
			$.ajax({
				url: lnkpath2,
				type: 'POST',
				data: {
					'title': prog_title,
					'prog_code': prog_code,
					'dept': prog_dept,
					'desc': prog_desc
				},
				success: function(data){
					// alert(data);
					window.location.reload();
				}
			});
		}
		// alert(prog_dept);
	});
</script>


<div class="row">
	<h4 class="pull-left">Programs</h4>
	<button class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add_program_form"><span class="glyphicon glyphicon-plus"></span></button>
</div>
<hr>
<div class="row">
	<table class="table table-hover table-bordered default-table" id="course_table">
		<thead>
			<tr>
				<th width="200">Department</th>
				<th width="450">Program</th>
				<th width="100">Code</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@if($course == null)
				<tr>
					<td colspan="4" align="center">No Data</td>
				</tr>
			@else
				@foreach($course as $crs)
					<tr rel="{{ $crs->id }}">
						<td>{{ $crs->name }}</td>
						<td>{{ $crs->title }}</td>
						<td>{{ $crs->code }}</td>
						<td align="center">
							<a id="update_program" class="text-primary" href="#" rel="{{ $crs->id }}" data-toggle="modal" data-target="#update_program_form">
								<span class="glyphicon glyphicon-edit"></span>
							</a>
						</td>
					</tr>
				@endforeach	
			@endif
			
		</tbody>
	</table>

	<center>
	<div id="pageNavPosition" class="pagination"></div>
	</center>

	<div class="modal fade" id="add_program_form" tabindex="-1" role="dialog" aria-labelledby="program_label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					<h4 class="modal-title" id="program_label">Add Program</h4>
				</div>

				<div class="modal-body">
					<label for="prog_title">Title</label>
					<input type="text" class="form-control" name="prog_title">
					<br>
					<label for="prog_dept">Department</label>
					<select class="form-control" name="prog_dept">
						<option value="">SELECT</option>
						@foreach($department as $d)
							<option value="{{ $d->id }}">{{ $d->name }}</option>
						@endforeach
					</select>
					<br>
					<label for="prog_code">Code <span class="text-muted">optional</span></label>
					<input type="text" class="form-control" name="prog_code">
					<br>
					<label for="prog_desc">Description <span class="text-muted">optional</span></label>
					<textarea rows="2" class="form-control" name="prog_desc"></textarea>
				</div>
					
				<div class="modal-footer">
					<button class="btn btn-md btn-success" id="add_program_save">Save</button>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="update_program_form" tabindex="-1" role="dialog" aria-labelledby="program_label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					<h4 class="modal-title" id="program_label">Update Program</h4>
				</div>

				<div class="modal-body">
					<label for="prog_title">Title</label>
					<input type="text" class="form-control" name="prog_title">
					<br>
					<label for="prog_dept">Department</label>
					<select class="form-control" name="prog_dept">
						<option value="">SELECT</option>
						@foreach($department as $d)
							<option value="{{ $d->id }}">{{ $d->name }}</option>
						@endforeach
					</select>
					<br>
					<label for="prog_code">Code <span class="text-muted">optional</span></label>
					<input type="text" class="form-control" name="prog_code">
					<br>
					<label for="prog_desc">Description <span class="text-muted">optional</span></label>
					<textarea rows="2" class="form-control" name="prog_desc"></textarea>
				</div>
					
				<div class="modal-footer">
					<button class="btn btn-md btn-success" id="update_program_btn">Update</button>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	var pager = new Pager('course_table', 5); 
    pager.init(); 
    pager.showPageNav('pager', 'pageNavPosition'); 
    pager.showPage(1);
</script>

	
