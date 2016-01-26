@extends('layout.index')

	@section('pagetitle')
		Alumni Master List
	@endsection

	@section('head')
		<link rel="stylesheet" href="../js/extensions/TableTools/css/dataTables.bootstrap.css">
	@endsection


	@section('content')

		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">Master List</div>

				<div class="panel-body">

					<!-- <input type="file" name="fileupload" id="txtfileupload" accept=".csv,.xls"> -->

					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<!-- <div class="col-md-4">
								<input type="text" class="form-control" id="search_master">
							</div>
							<div class="col-md-4">
								<select class="form-control">
									<option>Filter Course</option>
								</select>
							</div> -->
							

							<!-- <input type="checkbox" class="btn btn-sm btn-default" id="mark_all" value="Select All"></input> -->
							<button class="btn btn-md btn-success" data-toggle="modal" data-target="#import_form"><span class="glyphicon glyphicon-import"></span> Import</button>
							<!-- <button class="btn btn-md btn-success"><span class="glyphicon glyphicon-export"></span> Export</button> -->
							<button class="btn btn-md btn-success" data-toggle="modal" data-target="#new_form"><span class="glyphicon glyphicon-plus"></span> New</button>
							<button class="btn btn-md btn-success" name="delete_select"><span class="glyphicon glyphicon-trash"></span> Delete</button>
							
						</div>
					</div>
					<br>
					<!-- <div class="row">
						<div class="col-md-10 col-md-offset-1">
							Show 
							<select>
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select> entries
						</div>
					</div><br> -->
					<div class="row">
						<div class="col-md-10 col-md-offset-1" id="master-content">
							<table class="table table-bordered table-hover default-table" id="student_master">
								<thead>
									<tr>
										<th width="10px">
											<input type="checkbox" id="mark_all" name="mark_all">
											<!-- <button class="btn btn-xs btn-success"><span class="glyphicon glyphicon-trash"></span></button> -->
										</th>
										<th>ID No</th>
										<th>Family Name</th>
										<th>First Name</th>
										<th>M.I</th>
										<th>Course</th>
										<th>Batch</th>
									</tr>
								</thead>
								<tbody>
									<!-- <tr>
										<td colspan="77" align="center">No Records</td>
									</tr> -->
									@foreach($master as $m)
										<tr rel="{{ $m->id }}" class="master_copy">
											<td><input type="checkbox" name="mark_item"></td>
											<td>{{ $m->stud_no }}</td>
											<td id="{{ $m->id }}">{{ $m->last_name }}</td>
											<td>{{ $m->first_name }}</td>
											<td>{{ $m->mid_name }}</td>
											<td>{{ $m->course }}</td>
											<td>{{ $m->batch }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>

						</div>

						<center>
						<div style="margin-top: 3px;" class="pagination" id="pageNavPosition"></div>
						</center>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="modal fade" id="import_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Import</h4>
						</div>

						<div class="modal-body">
							<input type="file" class="form-control" name="file_upload" accept=".csv">
						</div>

						<div class="modal-footer">
							<button class="btn btn-success" type="button" name="start_import" data-loading-text="Importing..." autocomplete="off">Start Import</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="new_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">New</h4>
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">ID No.</div>
								<div class="col-md-6"><input type="text" class="form-control" id="new_studno"></div>
							</div><br>
							<div class="row">
								<div class="col-md-6">Last Name</div>
								<div class="col-md-6"><input type="text" class="form-control" id="new_lname"></div>
							</div><br>
							<div class="row">
								<div class="col-md-6">First Name</div>
								<div class="col-md-6"><input type="text" class="form-control" id="new_fname"></div>
							</div><br>
							<div class="row">
								<div class="col-md-6">Middle Initial/Name</div>
								<div class="col-md-6"><input type="text" class="form-control" id="new_mname"></div>
							</div><br>
							<div class="row">
								<div class="col-md-6">Course</div>
								<div class="col-md-6">
									<select class="form-control" id="new_course">
										
										@foreach($course as $c)
											<option value="{{ $c->id }}">{{ $c->title }}</option>
										@endforeach
										
									</select>
								</div>
							</div><br>
							<div class="row">
								<div class="col-md-6">Batch</div>
								<div class="col-md-6">
									<select class="form-control" id="new_batch">
										<?php
											$y = date('Y');
											for ($i=1994; $i < $y; $i++) { 
												echo "<option value='".$i."'>".$i."</option>";
											}
										?>
									</select>
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<button class="btn btn-success" type="button" name="new_save_btn">Save</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="../js/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="../js/extensions/TableTools/js/dataTables.bootstrap.js"></script>
		<script>
	        var csvData = [];

	        function doStuff(data){
	        	csvData = data;
	        	// console.log(data);
	        }
	        function parseData(url, callback){
	        	Papa.parse(url, {
	        		worker: true,
	        		download: true,
	        		dynamicTyping: true,
	        		complete: function(results){
	        			callback(results.data);
	        		}
	        	});
	        }
	   //      function loadData(){
	   //      	var link = "{{ URL::to('admin/master-table') }}";
				// var filter = "";

				// $.ajax({
				// 	url: link,
				// 	type: 'POST',
				// 	data: {
				// 		'filter': filter
				// 	},
				// 	beforeSend: function(){
				// 		$('#master-content').html('<center><img src="{{ URL::to("images/ajax-loader.gif") }}" width="80" height="80"><br>Loading...</center>');
				// 	},
				// 	success: function(data){
				// 		$('#master-content').html(data);
				// 	}

				// });ww
	   //      }

	        $(document).ready(function(){

	        	$('button[name=delete_select]').click(function(){

	        		// $('input[type=checkbox][name=mark_item]:checked').
	        		$('input[type=checkbox][name=mark_item]:checked').each(function(){
						if(this.checked){
							// var pos = mytable.fnGetPosition($('#messages_table tbody td'));
							// console.log(pos);
							var id = $('tr.master_copy').attr('rel');
							// console.log($(this).attr('rel'));

							var lnkpath = "{{ URL::to('admin/delete-single-master') }}";

							$.ajax({
								url: lnkpath,
								type: 'POST',
								data: {
									'id': id
								},
								success: function(response){
									console.log(response);
								}
							});
	        		// alert(id);
						}
					});
					window.location.reload();
	        	});


	        	$('#new_studno').keydown(function(e){
					if($(this).val().length > 7 && e.which !== 8 && e.which !== 46 || (e.which >= 65 && e.which <= 90) || (e.which >= 189 && e.which <= 195)){
						return false;
					}
				});
	        	// $('.DTTT').addClass('pull-right');
	        	
	        	// $('#txtfileupload').change(function(){
	        	// 	var fileupload = document.getElementById('txtfileupload').files;

	        	// 	var file = fileupload[0];
	        	// 	var reader = new FileReader();

	        	// 	reader.readAsText(file);
	        	// 	reader.onload = function(e){
	        	// 		var data = e.target.result;
	        	// 		alert(data);
	        	// 	}
	        	// 	reader.readAsDataURL(file);	
	        	// });
					
				// loadData();

				$('#student_master').dataTable({
					// "dom": 'T<"clear">lfrtip',
			  //       "tableTools": {
			  //           "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
			  //       }
			  		"order": [[ 2, "asc" ]],
			  		// dom: 'T<"clear">lfrtip',
			    //     tableTools: {
			    //         "sSwfPath": "../js/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
			    //     }

			    	"sDom": 'T<"clear">lfrtip',
			        "oTableTools": {
			            "aButtons": [
			            	// "select_all",
			                // "copy",
			                "print",
			                {
			                    "sExtends":    "collection",
			                    "sButtonText": "Save As",
			                    "aButtons":    [ "csv", "xls", "pdf" ]
			                }
			            ]
			        }
				});

				$('input[name=file_upload]').change(function(){
					var lnkpath = "{{ URL::to('admin/import-file') }}";
					var upload = $('input[name=file_upload]').prop('files')[0];
	        		
	        		var form_data = new FormData();
	        		form_data.append('upload', upload);

	        		$.ajax({
	        			url: lnkpath,
	        			type: 'POST',
	        			data: form_data,
	        			cache: false,
	        			processData: false,
	        			contentType: false,
	        			error: function(jqXHR){
	        				alert(jqXHR.responseText);
	        			},
	        			success: function(data){
	        				// lnkpath2 = data;
	        				// alert(data);
	        				parseData(data, doStuff);
	        			}
	        		});
				});

	        	$('button[name=start_import]').click(function(){
	        		var lnkpath2 = "{{ URL::to('admin/save-import-csv') }}";
	        		var $btn = $(this);
	        		
	        		$.ajax({
    					url: lnkpath2,
    					type: 'POST',
    					data: {
    						'data': csvData
    					},
    					beforeSend: function(){
    						$btn.attr('disabled', 'disabled').html('Importing...');
    						$('input[name=file_upload]').attr('disabled', 'disabled');
    					},
    					error: function(jqXHR){
    						alert(jqXHR.responseText);
    					},
    					success: function(data){
    						$('input[name=file_upload]').val('');
    						$('input[name=file_upload]').removeAttr('disabled');
    						$btn.removeAttr('disabled').html('Start Import');
    						alert('Import Success.');
    						window.location.reload();
    					}
    				});
	        		
	        	});

	   //      	$('#search_master').keyup(function(){
				// 	var value = this.value.toLowerCase().trim();

				// 	$('#student_master tr').each(function(index){
				// 		if(!index)
				// 			return;
				// 		$(this).find("td").each(function(){
				// 			var id = $(this).text().toLowerCase().trim();
				// 			var not_found = (id.indexOf(value) == -1);
				// 			$(this).closest('tr').toggle(!not_found);
				// 			return not_found;
				// 		});
				// 	});
				// });

	        	$('#mark_all').click(function(){
	        		if(this.checked){
	        			$('input[type=checkbox][name=mark_item]').each(function(){
	        				this.checked = true;
	        				// $('button[name=delete_select]').show();
	        			});
	        		} else{
	        			$('input[type=checkbox][name=mark_item]').each(function(){
	        				this.checked = false;
	        				// $('button[name=delete_select]').hide();
	        			});
	        		}
	        	});

	        	// $('input[name=mark_item]').click(function(){
	        	// 	if(this.checked){
	        	// 		$('input[type=checkbox][name=mark_item]').each(function(){
	        	// 			$('button[name=delete_select]').show();
	        	// 		});
	        	// 	} else{
	        	// 		$('input[type=checkbox][name=mark_item]').each(function(){
	        	// 			$('button[name=delete_select]').hide();
	        	// 		});
	        	// 	}
	        	// });

	        	$('button[name=new_save_btn]').click(function(){
	        		var lnkpath = "{{ URL::to('admin/save-single-master') }}";
	        		var stud_no = $('#new_studno').val();
	        		var last_name = $('#new_lname').val();
	        		var first_name = $('#new_fname').val();
	        		var mid_name = $('#new_mname').val();
	        		var course_id = $('#new_course').val();
	        		var batch = $('#new_batch').val();

	        		$.ajax({
	        			url: lnkpath,
	        			type: 'POST',
	        			data: {
	        				'studno': stud_no,
	        				'lname': last_name,
	        				'fname': first_name,
	        				'mname': mid_name,
	        				'course': course_id,
	        				'batch': batch
	        			},
	        			beforeSend: function(){
	        				$(this).attr('disabled', 'disabled');
	        			},
	        			success: function(data){
	        				if(data == 0){
	        					alert('Save successfully');
	        					window.location.reload();
	        				} else{
	        					alert('Already exists.');
	        				}
	        				
	        			}
	        		});
	        		// alert(lnkpath);
	        	});


	        	// $('#student_master tr').hover(
	        	// 	function(){
	        	// 		var sel = $(this).attr('rel');
	        	// 		$('#'+sel).append('<span><a href="#" class="pull-right edit_copy"><span class="glyphicon glyphicon-edit"></span></a></span>');
	        	// 	},
	        	// 	function(){
	        	// 		var sel = $(this).attr('rel');
	        	// 		$(this).find($('span')).remove();
	        	// 	}
	        	// );

	        	// $('.edit_copy').click(function(){
	        	// 	alert($(this).attr('id'));
	        	// });

				// $('button[name=delete_select]').click(function(){
				// 	var rows = $('input[name=mark_item][type=checkbox]:checked').length;

				// 	if(confirm('Are you sure you want to delete '+rows+' items?')){
						
				// 	} else{
						
				// 	}
				// });
				
		        	
	        });
		</script>
	@endsection
@stop