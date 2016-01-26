@extends('layout.index')

	@section('pagetitle')
		Messages
	@endsection


	@section('head')
	@endsection


	@section('content')
		<div class="container">

			<div class="panel panel-primary">

				<div class="panel-heading">Messages</div>

				<div class="panel-body">

					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-md btn-success" data-toggle="modal" data-target="#new_mail_message">New</button>
							<button class="btn btn-md btn-success" id="mark_delete">Delete</button><br><br>

							<table id="messages_table" class="table table-bordered table-hover default-table">
								<thead>
									<tr>
										<th width="5px"><input type="checkbox" id="mark_all"></th>
										<th width="150px">Sender</th>
										<th>Subject</th>
										<th width="300px">Date</th>
									</tr>
								</thead>
								<tbody>

									@foreach($messages as $m)
										@if($m->is_new == 1)
											<tr class="success" rel="{{ $m->id }}">
										@else
											<tr rel="{{ $m->id }}">
										@endif
											<td><input type="checkbox" id="mark_item" rel="{{ $m->id }}"></td>
											<td>{{ $m->fullname }}
												<input type="hidden" name="sender_email" value="{{ $m->email }}">
											</td>
											<td><a href="#" class="message_copy" data-target="#view_message" data-toggle="modal" rel="{{ $m->id }}">{{ $m->subject }}</a>
												<button rel="{{ $m->id }}" name="send_mail" style="display: none;" class="btn btn-xs btn-success pull-right" data-toggle="modal" data-target="#new_mail">Send Mail</button>
											</td>
											<td>{{ $m->created_at }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="panel-footer">&nbsp;</div>
			</div>


			<div class="modal fade" id="view_message" tabindex="-1" role="dialog" aria-labelledby="view_message_label" aria-hidden="true">

				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="view_message_label"><span aria-hidden="true">&times;</span></button> -->
							<h4 class="modal-title" id="message_sender">&nbsp;</h4>
						</div>

						<div class="modal-body">
							<span class="text-info" id="date_send"></span><br>
							<label>Subject</label>
							<input type="text" class="form-control" id="message_subject" disabled>
							<br>
							<label>Message</label>
							<textarea class="form-control" rows="6" id="message_body" disabled></textarea>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-md btn-success" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>


			<div class="modal fade" id="new_mail" tabindex="-1" role="dialog" aria-labelledby="new_mail_label" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="view_message_label"><span aria-hidden="true">&times;</span></button> -->
							<h4 class="modal-title">Send Mail</h4>
						</div>

						<div class="modal-body">
							<label>To</label>
							<input type="email" class="form-control" id="mail_to" disabled>
							<label>Subject</label>
							<input type="text" class="form-control" id="mail_subject" autofocus>
							<label>Message</label>
							<textarea class="form-control" id="mail_message" rows="6"></textarea>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Cancel</button>
							<button id="btn_send_mail" type="button" class="btn btn-md btn-success">Send</button>
						</div>
					</div>
				</div>
			</div>


			<div class="modal fade" id="new_mail_message" tabindex="-1" role="dialog" aria-labelledby="new_mail_message_label" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-header">
							<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="view_message_label"><span aria-hidden="true">&times;</span></button> -->
							<h4 class="modal-title">New Message</h4>
						</div>

						<div class="modal-body">
							<label>To</label>
							<input type="email" class="form-control" id="new_mail_to" placeholder="example@email.com">
							<label>Subject</label>
							<input type="text" class="form-control" id="new_mail_subject" placeholder="subject">
							<label>Message</label>
							<textarea class="form-control" id="new_mail_message" rows="6" placeholder="message"></textarea>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Cancel</button>
							<button id="btn_send_new_mail" type="button" class="btn btn-md btn-success">Send</button>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="container"></div>
		<script>

			$(document).ready(function(){

				var mytable = $('#messages_table').dataTable();

				$('#btn_send_new_mail').click(function(){
					var lnkpath = "{{ URL::to('admin/send-mail') }}";

					var email = $('#new_mail_to').val();
					var subject = $('#new_mail_subject').val();
					var msg = $('#new_mail_message').val();

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'email': email,
							'subject': subject,
							'message': msg
						},
						success: function(response){
							alert('Message Sent');
							window.location.reload();
						}
					});
				});

				$('#mark_delete').click(function(){
					
					$('input[type=checkbox][id=mark_item]:checked').each(function(){
						if(this.checked){
							// var pos = mytable.fnGetPosition($('#messages_table tbody td'));
							// console.log(pos);
							var msg_id = $(this).attr('rel');
							// console.log($(this).attr('rel'));

							var lnkpath = "{{ URL::to('admin/delete-message') }}";

							$.ajax({
								url: lnkpath,
								type: 'POST',
								data: {
									'msg_id': msg_id
								},
								success: function(response){
									console.log(response);
								}
							});
						}
					});
					window.location.reload();
					// mytable.fnDeleteRow(0);
				});

				$('#mark_all').click(function(){
					if(this.checked){
						$('input[type=checkbox]#mark_item').each(function(){
							this.checked = true;
						});
					} else{
						$('input[type=checkbox]#mark_item').each(function(){
							this.checked = false;
						});
					}
				});

				$('tr').hover(function(){
					var i = $(this).attr('rel');
					$('button[name=send_mail][rel='+i+']').show();
				}, function(){
					var i = $(this).attr('rel');
					$('button[name=send_mail][rel='+i+']').hide();
				});

				$('button[name=send_mail]').click(function(){
					var id = $(this).attr('rel');
					var email = $('tr[rel='+id+'] > td > input[type=hidden][name=sender_email]').val();

					$('#mail_to').val(email);
					// alert(email);
				});

				$('.message_copy').click(function(){
					var lnkpath = "{{ URL::to('admin/view-message') }}";
					var lnkpath2 = "{{ URL::to('admin/mark-as-read') }}";
					var id = $(this).attr('rel');

					$.ajax({
						url: lnkpath2,
						type: 'POST',
						data: {
							'id': id
						},
						success: function(data){
							if(data == 1){
								$("tr[rel='"+id+"']").removeClass('success');
							}
						}
					});

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'id': id
						},
						dataType: 'JSON',
						success: function(response){
							if(response != null){
								$('#date_send').html(response[0].created_at);
								$('#message_sender').html(response[0].fullname);
								$('#message_subject').val(response[0].subject);
								$('#message_body').html(response[0].message);
							}
						}
					});
				});

				$('#btn_send_mail').click(function(){
					var lnkpath = "{{ URL::to('admin/send-mail') }}";

					var email = $('#mail_to').val();
					var subject = $('#mail_subject').val();
					var message = $('#mail_message').val();

					if(subject == ''){
						alert('Subject should not be empty.');
					} else{

						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'email': email,
								'subject': subject,
								'message': message
							},
							beforeSend: function(){
								$('#btn_send_mail').attr('disabled', 'disabled').html('Sending...');
							},
							success: function(response){
								$('#btn_send_mail').removeAttr('disabled').html('Send');
								window.location.reload();
							}
						});
					}

				});

			});

		</script>
	@endsection

@stop