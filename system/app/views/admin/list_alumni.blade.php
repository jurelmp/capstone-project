@extends('layout.index')

	@section('pagetitle')
		Alumni Records
	@endsection


	@section('head')
		<link rel="stylesheet" href="../js/extensions/TableTools/css/dataTables.bootstrap.css">

		<script src="../js/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="../js/extensions/TableTools/js/dataTables.bootstrap.js"></script>

		<script>

			$(document).ready(function(){

				$('#btn_send_survey').click(function(){
					var lnkpath = "{{ URL::to('admin/send-survey') }}";
					var mail_to = $('#survey_mail_to').val();
					var subject = $('#survey_subject').val();
					var message = $('#survey_message').val();

					if(subject != ''){
						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'mail_to': mail_to,
								'subject': subject,
								'message': message
							},
							beforeSend: function(){

							},
							success: function(response){
								alert(response);
								window.location.reload();
								
							}
						})
					} else{
						alert('Please provide the subject field.');
					}
						

					// alert('ss');
				});

				$('button[name=send_survey_btn]').click(function(){
					var id = $(this).attr('rel');

					var email = $('tr[rel='+id+'] > td#email span').html();

					$('#survey_mail_to').val(email);

					// alert(email);
				});

				$('tr').hover(function(){
					var i = $(this).attr('rel');
					$('button[name=send_survey_btn][rel='+i+']').show();
				}, function(){
					var i = $(this).attr('rel');
					$('button[name=send_survey_btn][rel='+i+']').hide();
				});

				$('#alumni_table').dataTable({
					"order": [[ 5, "asc" ]],
					dom: 'T<"clear">lfrtip',
			        tableTools: {
			            "sSwfPath": "../js/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
			        }
			  		// "sDom": 'T<"clear">lfrtip',
			    //     "oTableTools": {
			    //         "aButtons": [
			    //         	// "select_all",
			    //             // "copy",
			    //             "print",
			    //             {
			    //                 "sExtends":    "collection",
			    //                 "sButtonText": "Save As",
			    //                 "aButtons":    [ "csv", "xls", "pdf" ]
			    //             }
			    //         ]
			    //     }
				});

				$('a[data-toggle=tooltip], a').tooltip({
					content: function(){
						return $(this).attr('title');
					}
				});

				// var names = ['annabelle', 'b', 'c', 'd'];
				var names = [];
				var lnk = "{{ URL::to('admin/alumninames') }}";
				$.ajax({
					url: lnk,
					type: 'GET',
					dataType: 'JSON',
					success: function(data){
						for(var n in data){
							names[n] = data[n].firstname + ' ' + data[n].midname.charAt(0) + '. ' + data[n].lastname;
						}
					}
				});
				$('input[name=search_name]').autocomplete({
					source: names
				});


				$('#search_alumni').keydown(function(){
					var value = this.value.toLowerCase().trim();

					$('#alumni_table tr').each(function(index){
						if(!index)
							return;
						$(this).find("td").each(function(){
							var id = $(this).text().toLowerCase().trim();
							var not_found = (id.indexOf(value) == -1);
							$(this).closest('tr').toggle(!not_found);
							return not_found;
						});
					});
				});

				$('.verify_alumni').click(function(){
					var alumni_id = $(this).attr('rel');
					var lnkpath = "{{ URL::to('admin/verify-alumni') }}";

					if(confirm('Verify this record.')){

						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'alumni_id': alumni_id
							},
							success: function(response){
								if(response == 1){
									window.location.reload();
								}
							}
						});
					}
		  			// alert(alumni_id);
		  		});

		  		$('.unverify_alumni').click(function(){
					var alumni_id = $(this).attr('rel');
					var lnkpath = "{{ URL::to('admin/unverify-alumni') }}";

					if(confirm('Are you sure you want to unverify this record?.')){

						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'alumni_id': alumni_id
							},
							success: function(response){
								if(response == 1){
									window.location.reload();
								}
							}
						});
					}
		  			// alert(alumni_id);
		  		});

			});
		</script>
	@endsection


	@section('content')
		<div class="container">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Records</div>

					<div class="panel-body">
						<!-- <div class="row">
							<div class="col-md-4">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
									<input type="text" class="form-control" placeholder="Search" name="search_name" id="search_alumni">
								</div>
							</div>
							<div class="col-md-4">
								<div class="input-group">
									<span class="input-group-addon">Batch</span>
									<select class="form-control">
										<option>All</option>
										<?php
											$y = date('Y');
											for ($i=1995; $i <= $y; $i++) { 
												echo "<option>".$i."</option>";
											}
										?>
									</select>
								</div>	
							</div>
						</div><br> -->

						<div class="row">
							

							<!-- <div class="col-md-4">
								<button class="btn btn-md btn-success pull-right"><span class="glyphicon glyphicon-download-alt"></span>&nbsp; Download</button>
								<button class="btn btn-md btn-success pull-right" style="margin-right: 4px;"><span class="glyphicon glyphicon-print"></span> &nbsp;Print</button>
								<button class="btn btn-md btn-success pull-right" style="margin-right: 4px;"><span class="glyphicon glyphicon-user"></span> &nbsp;Add</button>

							</div> -->
						</div><br>

						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover default-table" id="alumni_table">
									<thead>
										<tr>
											<!-- <th style="width: 5px;"><span class="glyphicon glyphicon-list"></span></th> -->
											<th style="width: 90px;">ID #</th>
											<th style="width: 350px;">Name</th>
											<th style="width: 100px;">Course</th>
											<th style="width: 100px;">Year Graduated</th>
											<th style="width: 230px;">Email</th>
											<th>Status</th>
											<th>Action</th>

										</tr>
									</thead>
									<tbody>
										@if($alumni == null)
											<tr>
												<td colspan="7">No Data</td>
											</tr>
										@else

											@foreach($alumni as $al)
												<tr rel="{{ $al->id }}">
													<td>{{ $al->stud_no }}</td>
													<td>
														<?php
															if($al->pic_path != ''){
																$p = $al->pic_path;
															} else {
																$p = 'images/unknown.png';
															}
															
															$u = URL::to($p);
														?>
														<!-- <img src="{{ $u }}" width="30" height="30" class="img-responsive"> -->
														<?php
															$a_id = $al->id;
															$str = "admin/profile/".$a_id;
															$link = URL::to($str);
														?>
														<a href="{{ $link }}" class="text-primary" data-toggle="tooltip" title="<img src='{{ $u }}' width='100' height='100' class='img-responsive'>">
														{{ $al->firstname }}&nbsp;
														{{ $al->midname }}&nbsp;
														{{ $al->lastname }}
														</a>
													</td>
													<td>{{ $al->code }}</td>
													<td>{{ $al->year_graduated }}</td>
													<td id="email">
														<span>{{ $al->email }}</span>
														<button rel="{{ $al->id }}" name="send_survey_btn" style="display: none;" class="btn btn-xs btn-success pull-right" data-toggle="modal" data-target="#send_survey">Send Survey</button>
													</td>
													<td>
														@if($al->is_confirmed == 0)
															<span class="label label-danger">pending</span>
														@else
															<span class="label label-success">verified</span>
														@endif
													</td>
													<td align="center">
														<!-- <a href="#" class="text-primary" title="Edit this record."><span class="glyphicon glyphicon-edit"></span></a>&nbsp; -->

														<a class="text-primary verify_alumni" title="Verify." rel="{{ $al->id }}"><span class="glyphicon glyphicon-check"></span></a>&nbsp;
														<a href="#" class="text-primary unverify_alumni" title="Unverify this record." rel="{{ $al->id }}"><span class="glyphicon glyphicon-trash"></span></a>
													</td>
												</tr>
											@endforeach

										@endif
									</tbody>
								</table>

								<center>
								<div id="pageNavPosition" class="pagination"></div>
								</center>
							</div>
								

						</div>	
					</div>
				</div>
			</div>


			<div class="modal fade" id="send_survey" tabindex="-1" role="dialog" aria-labelledby="send_survey_label" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="view_message_label"><span aria-hidden="true">&times;</span></button> -->
							<h4 class="modal-title">Send Tracer Survey Form</h4>
						</div>

						<div class="modal-body">
							<label>To</label>
							<input type="email" class="form-control" id="survey_mail_to" disabled>
							<label>Subject</label>
							<input type="text" class="form-control" id="survey_subject" value="Alumni Tracer Survey Form">
							<label>Message</label>
							<textarea class="form-control" id="survey_message" rows="6">Please answer the survey form attached in PDF format.</textarea>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Cancel</button>
							<button id="btn_send_survey" type="button" class="btn btn-md btn-success">Send</button>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="container"></div>

		<script>
			// var pager = new Pager('alumni_table', 10); 
	  //       pager.init(); 
	  //       pager.showPageNav('pager', 'pageNavPosition'); 
	  //       pager.showPage(1);


		</script>
	@endsection

@stop