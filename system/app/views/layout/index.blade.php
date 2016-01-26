<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
	<head>
		<title> @yield('pagetitle') </title>
		
		<meta charset="utf-8">
		<meta name="description" content="Alumni Tracer System">
		<meta name="author" content="Team Kamote">

		{{ HTML::style('css/bootstrap.css') }}
		<!-- {{ HTML::style('css/bootstrap-theme.css') }} -->
		{{ HTML::style('css/main.css') }}
		{{ HTML::style('fancybox/jquery.fancybox.css') }}
		{{ HTML::style('jquery-ui/jquery-ui.css') }}
		{{ HTML::style('css/dataTables.bootstrap.css') }}
		{{ HTML::style('font-awesome/css/font-awesome.css') }}
		

		<!-- ================================================= -->
		{{ HTML::script('js/vendor/jquery.js') }}
		{{ HTML::script('js/bootstrap.js') }}
		{{ HTML::script('fancybox/jquery.fancybox.js') }}
		{{ HTML::script('highcharts/js/highcharts.js') }}
		{{ HTML::script('highcharts/js/modules/exporting.js') }}
		<!-- {{ HTML::script('highcharts/js/themes/sand-signika.js') }} -->
		{{ HTML::script('jquery-ui/jquery-ui.js') }}
		{{ HTML::script('js/jquery.tablesorter.min.js') }}
		{{ HTML::script('js/main.js') }}
		{{ HTML::script('js/tinymce/tinymce.min.js') }}
		{{ HTML::script('js/typeahead.js') }}
		{{ HTML::script('js/pagination.js') }}
		{{ HTML::script('js/papaparse.js') }}
		{{ HTML::script('js/jquery.csv.js') }}
		{{ HTML::script('js/jquery.dataTables.js') }}
		{{ HTML::script('js/dataTables.bootstrap.js') }}
		

		<link rel="shortcut icon" href="{{ URL::to('images/logo.ico') }}">
		@yield('head')


	</head>

	<body>

		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">

			
			<div class="container">
				
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ URL::to('/') }}">
						<!-- <img id="system_logo" style="margin-top: -12px; padding-top: 0px;" src="images/logo-active.png"> -->
						<!-- <div id="logo">&nbsp;</div> -->
						<!-- <span class="fa fa-graduation-cap" style="font-size: 30px; color: #fff;"></span> -->
						<img src="{{ URL::to('images/logo_brand.png') }}" class="img-responsive" height="40px" width="55px" style=="padding-top: -10px;">
					</a>
				</div>

				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<!-- <li><a href="{{ URL::to('/') }}">Home</a></li> -->
						<li><a href="{{ URL::to('alumni/news') }}">News</a></li>
						<!-- <li><a href="#">ID Released</a></li> -->
						<!-- <li><a href="#">Officers</a></li> -->

						@if(Auth::check())
							@if(Auth::user()->acc_type == 3)
								<!-- <li><a href="{{ URL::to('alumni/tracer') }}">Profile</a></li> -->
								<li><a href="{{ URL::to('user/myprofile') }}">Profile</a></li>
								<!-- <li><a href="#">Tracer Survey</a></li> -->
							@endif
						@endif

						@if(Auth::check())

							@if(Auth::user()->acc_type == 2 || Auth::user()->acc_type == 1)
								<!-- <li><a href="{{ URL::to('admin/analytics') }}">Analytics</a></li> -->
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Metrics <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ URL::to('analytics/alumni-response') }}">Alumni Response</a></li>
										<li><a href="{{ URL::to('analytics/employability') }}">Employability</a></li>
										<li><a href="{{ URL::to('analytics/skills-assessment') }}">Skills Assessment</a></li>
										<li><a href="{{ URL::to('analytics/curriculum') }}">Curriculum</a></li>
									</ul>
								</li>
							@endif
						
							@if(Auth::user()->acc_type == 1)
								<!-- <li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Alumni <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ URL::to('admin/records') }}">Records</a></li>
									</ul>
								</li> -->
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Alumni <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ URL::to('admin/records') }}">Responses</a></li>
										<!-- <li><a href="{{ URL::to('admin/alumni-confirm') }}">Tracer</a></li>
										<li><a href="{{ URL::to('admin/alumni-pending') }}">Pending</a></li> -->
										<li><a href="{{ URL::to('admin/master-list') }}">Master List</a></li>
									</ul>
									
								</li>
							@endif
							
							@if(Auth::user()->acc_type == 1)
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Manage <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{ URL::to('admin/job-categories') }}">Job Categories</a></li>
										<li><a href="{{ URL::to('admin') }}">Accounts</a></li>
										<!-- <li><a href="#">Feedbacks</a></li> -->
										<li><a href="{{ URL::to('admin/survey') }}">Survey</a></li>
										<li><a href="{{ URL::to('admin/news') }}">News</a></li>
										<li><a href="{{ URL::to('admin/list-departments') }}">Departments</a></li>
									</ul>
								</li>
								<li><a href="{{ URL::to('admin/company-list') }}">Company</a></li>
							@endif
						
						@endif

						@if(!Auth::check())
							<li><a href="#" data-toggle="modal" data-target="#about_modal">About</a></li>
						@endif
					</ul>


					@if(Auth::check())
						
						<ul class="nav navbar-nav pull-right">
							<!-- <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} &nbsp;<span class="glyphicon glyphicon-user"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Profile</a></li>
									<li><a href="#">Settings</a></li>
									<li><a href="#">Contact</a></li>
								</ul>
							</li> -->
							@if(Auth::user()->acc_type == 1)
								<?php
									$sql = "SELECT COUNT(id) AS 'count' FROM messages WHERE is_new = 1";
									$r = DB::select($sql);
									echo "<li><a href='".URL::to('admin/messages')."' title='".$r{0}->count." new message.'>".$r{0}->count." <span class='fa fa-envelope-square'></span></a></li>";
								?>
							@endif
								

							<li><a href="{{ URL::to('/user') }}">
								
								@if(Auth::user()->firstname != null && Auth::user()->midname != null && Auth::user()->lastname != null)
									{{ Auth::user()->firstname }}&nbsp;{{ Auth::user()->lastname }}&nbsp;<span class="glyphicon glyphicon-cog"></span>
								@else
									{{ Auth::user()->username }}&nbsp;<span class="glyphicon glyphicon-cog"></span>
								@endif
							</a></li>
							<li><a href="{{ URL::to('/logout') }}">Logout&nbsp;<span class="glyphicon glyphicon-log-out"></span></a></li>
						</ul>

					@else
						
						<!-- <div class="pull-right" style="padding-top: 10px;">
							<a href="{{ URL::to('/login') }}" class="btn btn-sm btn-success">Signin</a>
							<a href="{{ URL::to('/register') }}" class="btn btn-sm btn-success" id="showcreate">Signup</a>
						</div> -->
					@endif
					

					
				</div>

			</div>
		</nav>

		@yield('content')

		<!-- <div class="container">
			<div style="display: none; width: 300px;" id="feedback_form"> 
				<h3><span class="label label-info"><span class="glyphicon glyphicon-envelope"></span>&nbsp;Contact Us</span></h3>
				<hr>

				@if(!Auth::check())
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name">

					<label for="email">Email</label>
					<input type="text" class="form-control" name="email">
				@endif
				
				<label for="message">Message</label>
				<textarea rows="4" class="form-control" name="message"></textarea>
				<br>
				<button class="btn btn-md btn-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;Send Message</button>
			</div>
		</div> -->

		<div class="modal fade" id="feedback_form" tabindex="-1" role="dialog" aria-labelledby="message_label" aria-hidden="true">

			<div class="modal-dialog modal-md">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="message_label">Contact Us</h4>
					</div>

					<div class="modal-body">
						<label>Subject</label>
						<input type="text" name="feedback_subject" class="form-control">
						<label>Message</label>
						<textarea class="form-control" rows="7" name="feedback_message"></textarea>
					</div>

					<div class="modal-footer">
						<button class="btn btn-md btn-success" name="send_message">Send</button>
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade" id="about_modal" tabindex="-1" role="dialog" aria-labelledby="about_modal_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="view_message_label"><span aria-hidden="true">&times;</span></button> -->
						<h4 class="modal-title">About</h4>
					</div>

					<div class="modal-body">
						
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-md btn-success" data-dismiss="modal" aria-label="about_modal_label">Close</button>
					</div>
				</div>
			</div>
		</div>

		

		<footer class="footer">
			<div class="container">
				<p class="text-muted">&copy; Alumni Tracer System 
					&nbsp;<a href="https://www.facebook.com/ucaai1965" target="_blank" style="font-size: 20px; margin-left: 15px;" class="pull-right"><span class="fa fa-facebook-square"></span></a>

					@if(Auth::check())
						@if(Auth::user()->acc_type != 1)
							<a href="#" style="font-size: 20px;" class="pull-right" role="button" id="show_fb_form" data-toggle="modal" data-target="#feedback_form"><span class="fa fa-envelope"></span></a>&nbsp;
						@endif
					@endif
				</p>
			</div>
		</footer>

		
		<script>
			$('a').tooltip();

			$('button[name=send_message]').on('click', function(){
				var lnkpath = "{{ URL::to('user/send-message') }}";
				var subject = $('input[name=feedback_subject]').val();
				var message = $('textarea[name=feedback_message]').val();

				if(message == ''){
					alert('Please provide your message.');
				} else{
					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'subject': subject,
							'message': message
						},
						beforeSend: function(){
							$('button[name=send_message]').attr('disabled', 'disabled').html('Sending...');
						},
						success: function(response){
							// alert(response);
							window.location.reload();	
						}
					});
				}
				// alert('ss');
			});


		</script>

	</body>
</html>