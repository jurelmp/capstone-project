<table class="table table-bordered table-hover default-table" id="student_master">
	<thead>
		<tr>
			<th width="10px"><span class="glyphicon glyphicon-check"></span></th>
			<th>ID No</th>
			<th>Family Name</th>
			<th>First Name</th>
			<th>M.I</th>
			<th>Course</th>
			<th>Batch</th>
		</tr>
	</thead>
	<tbody>
		@if($test == null)
			<tr>
				<td colspan="77" align="center">No Records</td>
			</tr>
		@else

			@foreach($test as $t)
				<tr>
					<td><input type="checkbox" name="select_item"></td>
					<td>{{ $t->id_no }}</td>
					<td>{{ $t->family_name }}</td>
					<td>{{ $t->first_name }}</td>
					<td>{{ $t->m }}</td>
					<td>{{ $t->course }}</td>
					<td>{{ $t->year }}</td>
				</tr>
			@endforeach

		@endif
	</tbody>
</table>

<script>

	// var pager = new Pager('student_master', 10);
	// pager.init();
	// pager.showPageNav('pager', 'pageNavPosition'); 
 //    pager.showPage(1);

    $('#student_master').tablesorter();
    $('#student_master').dataTable();
</script>