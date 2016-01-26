@extends('layout.index')

	@section('pagetitle')
		Account Settings
	@endsection

	@section('head')
		<script>
			$(document).ready(function(){
				var lnk_load = "{{ URL::to('user/accountsetting') }}";
				$.ajax({
					url: lnk_load,
					type: 'GET',
					success: function(data){
						// $('#user_content').html('');

						$('#user_content').html(data);
						$('#user_content').slideDown(function(){});
					}
				})

				$('#profile_settings').click(function(){

					var lnkpath = "{{ URL::to('user/profile') }}";
					$('#user_content').hide();

					$.ajax({
						url: lnkpath,
						type: 'GET',
						success: function(data){
							$('#user_content').html(data);
							$('#user_content').slideDown(function(){});
							// alert(data);
						}
					});
				});

				$('#account_settings').click(function(){

					var lnkpath = "{{ URL::to('user/accountsetting') }}";
					$('#user_content').hide();

					$.ajax({
						url: lnkpath,
						type: 'GET',
						success: function(data){
							// $('#user_content').html('');

							$('#user_content').html(data);
							$('#user_content').slideDown(function(){});
						}
					});
				});


				

			});

		</script>
	@endsection


	@section('content')

		<div class="container">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">&nbsp;</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-md-3">
								<!-- <div class="sidebar" role="navigation">
									<div class="sidebar-nav navbar-collapse">
										<ul class="nav" id="side-menu">
											<li><a href="#" id="profile_settings">User Profile</a></li>
											<li><a href="#" id="account_settings">Account Settings</a></li>
										</ul>
									</div>
								</div> -->
								<div class="list-group">
									<!-- <a href="#" class="list-group-item" id="profile_settings">User Profile</a> -->
									<a href="#" class="list-group-item" id="account_settings">Account Settings</a>
								</div>
							</div>
							
							<div class="col-md-9">
								<div id="user_content" style="display: none;"></div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	@endsection

@stop