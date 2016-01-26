<div class="panel panel-default">
	<div class="panel-heading">Account Settings</div>

	<div class="panel-body">
		<input type="hidden" id="cp_id" value="{{ $account[0]->id }}">
		<div class="input-group">
			<div class="input-group-addon">Username</div>
			<input type="text" class="form-control" value="{{  $account[0]->username }}" disabled>	
		</div>
		<br>
		<div class="input-group">
			<div class="input-group-addon">Email</div>
			<input type="text" class="form-control" value="{{ $account[0]->email }}" disabled>
		</div>
		<br>
		<div class="input-group">
			<div class="input-group-addon">Password</div>
			<input id="mypass" type="password" class="form-control" value="{{ $account[0]->password }}" disabled>
			<span class="input-group-btn">
				<button class="btn btn-info" type="button" id="change_pass">Change</button>
			</span>
		</div>
		<br>
		<div class="panel panel-default" id="change_pass_form" style="display: none;">
			<div class="panel-body">

				<div class="input-group">
					<div class="input-group-addon">Current Password </div>
					<input type="password" class="form-control" id="cp_current_pass">
				</div><hr>
				<div class="input-group">
					<div class="input-group-addon">New Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
					<input type="password" class="form-control" id="cp_new_pass" disabled>
				</div><br>
				<div class="input-group">
					<div class="input-group-addon">Confirm Password</div>
					<input type="password" class="form-control" id="cp_confirm_pass" disabled>
				</div><br>
				<button class="btn btn-md btn-success" id="change_pass_save" disabled><span class="glyphicon glyphicon-floppy-saved"></span></button>
				<button class="btn btn-md btn-danger" id="change_pass_cancel"><span class="glyphicon glyphicon-floppy-remove"></span></button>


			</div>
		</div>
		<br>
		<!-- <div class="input-group">
			<span class="glyphicon glyphicon-remove"></span>&nbsp;Deactivate Account
		</div> -->
	</div>
</div>

<script>
	$('#change_pass').click(function(){
		
		// $('#cp_new_pass').val("");
		// $('#cp_confirm_pass').val("");
		$('#change_pass_form').slideToggle(function(){});
	});

	$('#change_pass_cancel').click(function(){
		// $('#cp_new_pass').val("");
		// $('#cp_confirm_pass').val("");
		$('#change_pass_form').slideUp(function(){});
	});

	$('#cp_current_pass').keyup(function(){
		var mypass = $('#mypass').val();
		var nhash_pass = $('#cp_current_pass').val();
		
		var lnkpath = "{{ URL::to('user/checkpassword') }}";

		$.ajax({
			url: lnkpath,
			type: 'POST',
			data: {
				'pass': nhash_pass
			},
			dataType: 'TEXT',
			success: function(data){
				if(data == 'success'){
					$('#cp_new_pass').prop('disabled', false);
					$('#cp_confirm_pass').prop('disabled', false);
				} else {
					$('#cp_new_pass').prop('disabled', true);
					$('#cp_confirm_pass').prop('disabled', true);
				}
			}

		});
		
	});

	$('#cp_confirm_pass').keyup(function(){
		if($(this).val() == $('#cp_new_pass').val()){
			$('#change_pass_save').prop('disabled', false);
		} else {
			$('#change_pass_save').prop('disabled', true);
		}
	});

	$('#change_pass_save').on('click', function(){
		var pass = $('#cp_confirm_pass').val();
		var id = $('#cp_id').val();
		var lnkpath = "{{ URL::to('user/updatepass') }}";

		$.ajax({
			url: lnkpath,
			type: 'POST',
			data: {
				'id': id,
				'password': pass
			},
			success: function(data){
				if(data == 1){
					alert('succesfully change.');
					window.location.reload();
				} else {
					alert('something went wrong.')
				}
			}
		});
		// alert($('#cp_id').val());
	});

</script>