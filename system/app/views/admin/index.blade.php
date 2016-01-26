@extends('layout.index')

	@section('pagetitle')
		Manage Accounts
	@endsection

	@section('head')
		<script>

			$(document).ready(function(){

				$('#accounts_table').dataTable({
					"order": [[ 4, "desc" ]]
				});

				var g_user = '';
				var g_fname = '';
				var g_mname = '';
				var g_lname = '';
				var g_pass = '';
				var g_email = '';
				var g_type = '';
				var g_stat = '';

				// $('#accounts_table').tablesorter();

				$('#show_add_new').click(function(){
					// $('#add_new_account').attr('disabled', 'disabled');
					$('#null_error').hide();
					$('#match_error').hide();
					$.fancybox.open('#add_new_form');
				});

				$('.del_account').click(function(){
					if(confirm('Are you sure you want to deactivate this account?')){

						var lnkpath = "{{ URL::to('admin/deactivate-account') }}";
						var id = $(this).attr('rel');

						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'id': id
							},
							error: function(jqXHR, text_status, strError){
								alert(strError);
							},
							success: function(data){
								if(data == 1){
									window.location.reload();
								}
								// alert(data);
							}
						});
					}
				});

				
				$('#add_new_account').click(function(){
					var user = $('#user').val();
					var fname = $('#fname').val();
					var mname = $('#mname').val();
					var lname = $('#lname').val();
					var pass = $('#pass').val();
					var conpass = $('#conpass').val();
					var email = $('#email').val();
					var type = $('#type').val();

					var lnkpath = "{{ URL::to('/admin/addaccount') }}";

					if((user != "") && (pass != "") && (email != "") && (type != "") && fname != "" && mname != "" && lname != ""){
						
						if(pass == conpass){
							$.ajax({
								url: lnkpath,
								type: 'POST',
								data: {
									'username': user,
									'fname': fname,
									'mname': mname,
									'lname': lname,
									'password': pass,
									'email': email,
									'acc_type': type
								},
								error: function(jqXHR, text_status, strError){
									// alert(strError);
								},
								success: function(data){
									// alert(data);
									// if(data == 'success'){
										// var h = "<div class='alert alert-success><h4>Successfully added.</h4></div>'";
										// $('#error').html("<div class='alert alert-success><h4>Successfully added.</h4></div>'");
										// $('#error').show();
										// $.fancybox.close('#add_new_form');
										// $.fancybox.open('#error');
									// }
									// $(this).parent().close();
									if(data == 0){
										window.location.reload();
									} else if(data == 1){
										$('#null_error').html('Username and Email already taken.');
										$('#null_error').slideDown();
									} else if(data == 2){
										$('#null_error').html('Email already taken.');
										$('#null_error').slideDown();
									} else if(data == 3){
										$('#null_error').html('Username already taken.');
										$('#null_error').slideDown();
									}
									
								}
							});
							// $.fancybox.close('#add_new_form');
						} else {
							$('#null_error').slideUp('slow', function(){});
							$('#match_error').html('The password should match.');
							$('#match_error').slideDown('slow', function(){

							});
						}
					} else {
						$('#null_error').html('The fields are required.');
						$('#match_error').slideUp('slow', function(){});
						$('#null_error').slideDown('slow', function(){});
					}

				});


				// $('.account_copy').click(function(){
				// 	var user_id = $(this).attr('rel');
				// 	alert(user_id);
				// });


				// $('.del_account').click(function(){
					// if(confirm('Are you sure you want to delete this account?')){

					// 	var lnkpath = "{{ URL::to('/admin/deleteaccount') }}";
					// 	var id = $(this).attr('rel');

					// 	$.ajax({
					// 		url: lnkpath,
					// 		type: 'POST',
					// 		data: {
					// 			'user_id': id
					// 		},
					// 		error: function(jqXHR, text_status, strError){
					// 			// alert(strError);
					// 		},
					// 		success: function(data){
					// 			var cl = ".account_copy[rel='" + id + "']";
					// 			$(cl).remove();
					// 		}
					// 	});
					// }
				// });


				$('.show_update').click(function(){
					var id = $(this).attr('rel');

					var lnkpath = "{{ URL::to('/admin/account/" + id + "') }}";

					$.ajax({
						url: lnkpath,
						type: 'GET',
						dataType: 'JSON',
						success: function(data){
							g_user = data[0].username;
							g_fname = data[0].firstname;
							g_mname = data[0].midname;
							g_lname = data[0].lastname;
							g_pass = data[0].password;
							g_email = data[0].email;
							g_type = data[0].acc_type;
							g_stat = data[0].is_active;

							var str = '';
							var type = data[0].acc_type;
							var stat = data[0].is_active;
							var s = "input[type='radio'][value='" + stat + "']";
							// $('#content').html(data[0].username);
							var t = "#" + type;
							$(t).attr('selected', 'selected');

							$('#up_user').val(data[0].username);
							$('#up_fname').val(data[0].firstname);
							$('#up_mname').val(data[0].midname);
							$('#up_lname').val(data[0].lastname);
							$('#up_pass').val(data[0].password);
							$('#up_email').val(data[0].email);
							$('#up_type').val();
							$('#up_id').val(data[0].id);
							$(s).attr('checked', 'checked');
							$.fancybox.open('#update_form');
						}
					});
				});


				$('#update_account').click(function(){
					var lnkpath = "{{ URL::to('admin/updateaccount') }}";

					var id = $('#up_id').val();
					var user = $('#up_user').val();
					var fname = $('#up_fname').val();
					var mname = $('#up_mname').val();
					var lname = $('#up_lname').val();
					var pass = $('#up_pass').val();
					var email = $('#up_email').val();
					var type  = $('#up_type').val();
					var stat = $("input[type='radio'][name='up_stat']:checked").val();

					if((g_user == user) && (g_pass == pass) && (g_email == email) && (g_type == type) && (g_stat == stat) && g_fname == fname && g_mname == mname && g_lname == lname){
						alert('No changes has been made.');
					} else {
						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'id': id,
								'user': user,
								'fname': fname,
								'mname': mname,
								'lname': lname,
								'pass': pass,
								'email': email,
								'type': type,
								'stat': stat
							},
							error: function(jqXHR, text_status, strError){
								alert(strError);
							},
							success: function(data){
								if(data == 1)
									alert('Updated Successfully.');
								else
									alert('Update Fail.');

								window.location.reload();
							}
						});
					}
				});

				
				$('#search_accounts').keyup(function(){
					var value = this.value.toLowerCase().trim();

					$('#accounts_table tr').each(function(index){
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


				// $('#filter_account').on('change', function(e){
				// 	var letter = $(this).val();

				// 	if(letter === 'all'){
				// 		$('tr').show();
				// 	} else {
				// 		$('tr').each(function(rowIdx, tr){
				// 			$(this).hide().find('td#acc_stat').each(function(idx, td){
				// 				if(idx === 0 || idx === 1){
				// 					var check = $(this).text();
				// 					if(check && check.indexOf(letter) == 0){
				// 						$('tr').show();
				// 					}
				// 				}
				// 			});

				// 		});
				// 	}				
				// });

				

			});


		</script>
	@endsection


	@section('content')

		<div class="container">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">Accounts</div>

					<div class="panel-body">
						<div class="row">
							<!-- <div class="col-md-4">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
									<input type="text" class="form-control" placeholder="Search" id="search_accounts">
								</div>
							</div> -->

							<!-- <div class="col-md-4">
								<select class="form-control" id="filter_account">
									<option value="all">All</option>
									<option value="active">Active</option>
									<option value="inactive">Inactive</option>
								</select>
							</div> -->
							<div class="col-md-4">
								<button class="btn btn-md btn-primary" id="show_add_new"><span class="glyphicon glyphicon-user"></span>&nbsp;Add</button>
							</div>

						</div>
						<br>
						
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-hover default-table" id="accounts_table">
									<thead>
										<tr>
											<th>Username</th>
											<th>Email</th>
											<th>Account</th>
											<th>Status</th>
											<th>Date added</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if($users != null)

											@foreach($users as $user)
												<tr class="account_copy" rel="{{ $user->id }}">
													<td><a href="#" class="text-primary"> {{ $user->username }} </a></td>
													<td> {{ $user->email }} </td>

													@if($user->acc_type == 1)
														<td><span class="label label-default">admin</span></td>
													@elseif($user->acc_type == 2)
														<td><span class="label label-default">faculty</span></td>
													@elseif($user->acc_type == 3)
														<td><span class="label label-default">user</span></td>
													@endif
													
													@if($user->is_active == 1)
														<td class="td_stat"><span class="label label-success">active</span></td>
													@else
														<td class="td_stat"><span class="label label-danger">inactive</span></td>
													@endif
													
													<td> {{ $user->created_at }} </td>
													<td>
														<a href="#" title="Update this account." class="show_update" rel="{{ $user->id }}" role="button">
															<span class="glyphicon glyphicon-file"></span>
														</a> &nbsp;&nbsp; 
														<a href="#" title="Deactivate this account." class="del_account" rel="{{ $user->id }}" role="button">
															<span class="glyphicon glyphicon-trash"></span>
														</a>
													</td>
												</tr>
											@endforeach
										@else
											<tr>
												<td colspan="6">No Data</td>
											</tr>
										@endif
										
									</tbody>
								</table>
							</div>
						</div>
						
						<center>
						<div id="pageNavPosition" class="pagination">
						</div>
						</center>

						<!-- <div class="row">
							<ul class="pagination">
								<li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
								<li class="active"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">5</a></li>
								<li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
							</ul>
						</div> -->

					</div>
				</div>

			</div>

			<div id="update_form" style="display: none; width: 350px;">
				<h3><span class="label label-info"><span class="glyphicon glyphicon-user"></span>&nbsp;Update account</span></h3>
				<hr>
				<div id="content">
					<input type="hidden" id="up_id">
					<div class="form-group">
						<label for="username">Username</label>
						<input id="up_user" name="username" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="fname">First name</label>
						<input id="up_fname" name="fname" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="mname">Middle name</label>
						<input id="up_mname" name="mname" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="lname">Last name</label>
						<input id="up_lname" name="lname" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input id="up_pass" name="password" class="form-control" type="password">
					</div>

					<div class="form-group">
						<label for="email">Email</label>
						<input id="up_email" name="email" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="type">Account Type</label>
						<select id="up_type" name="type" class="form-control">
							<option id="3" value="3">User</option>
							<option id="2" value="2">Faculty</option>
							<option id="1" value="1">Admin</option>
						</select>
					</div>

					<div class="form-group">
						<label for="up_stat">Action</label> &nbsp;&nbsp;
						<input type="radio" name="up_stat" value="1">Activated &nbsp;&nbsp;
						<input type="radio" name="up_stat" value="0">Deactivated
					</div>

					<button id="update_account" class="btn btn-md btn-success"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Update</button>

				</div>
			</div>


			<div id="add_new_form" style="display: none; width: 350px;">

				<h3><span class="label label-info"><span class="glyphicon glyphicon-user"></span>&nbsp;Add new</span></h3>
				<hr>

				<div class="alert alert-danger" id="null_error" style="display: none;"></div>

				<div class="form-group">
					<label for="username">Username</label>
					<input id="user" name="username" class="form-control" type="text">
				</div>

				<div class="form-group">
					<label for="firstname">First name</label>
					<input id="fname" name="firstname" class="form-control" type="text">
				</div>

				<div class="form-group">
					<label for="midname">Middle Name</label>
					<input id="mname" name="midname" class="form-control" type="text">
				</div>

				<div class="form-group">
					<label for="lastname">Last name</label>
					<input id="lname" name="lastname" class="form-control" type="text">
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input id="pass" name="password" class="form-control" type="password">
				</div>

				<div class="alert alert-danger" id="match_error" style="display: none"></div>

				<div class="form-group">
					<label for="conpassword">Confirm Password</label>
					<input id="conpass" name="conpassword" class="form-control" type="password">
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input id="email" name="email" class="form-control" type="email">
				</div>

				<div class="form-group">
					<label for="type">Account Type</label>
					<select id="type" name="type" class="form-control">
						<option value="">SELECT TYPE</option>
						<option value="3">User</option>
						<option value="2">Faculty</option>
						<option value="1">Admin</option>
					</select>
				</div>
				
			
				<button id="add_new_account" class="btn btn-md btn-success"><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;Save</button>

			</div>

		</div>
		<div class="container"></div>

		<script>
			// var pager = new Pager('accounts_table', 10); 
	  //       pager.init(); 
	  //       pager.showPageNav('pager', 'pageNavPosition'); 
	  //       pager.showPage(1);
		</script>

	@endsection

@stop