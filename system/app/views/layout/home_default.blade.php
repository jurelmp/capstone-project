<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
	<head>
		<title> Alumni Tracer System </title>
		
		<meta charset="utf-8">
		<meta name="description" content="Alumni Tracer System">
		<meta name="author" content="Team Kamote">

		{{ HTML::style('css/bootstrap.css') }}
		<!-- {{ HTML::style('css/bootstrap-theme.css') }} -->
		{{ HTML::style('css/main.css') }}
		{{ HTML::style('css/sb-admin-2.css') }}
		{{ HTML::style('css/social-buttons.css') }}
		{{ HTML::style('css/foundation.min.css') }}
		

		<!-- ================================================= -->
		{{ HTML::script('js/vendor/jquery.js') }}
		{{ HTML::script('js/bootstrap.js') }}
		{{ HTML::script('js/sb-admin-2.js') }}
		{{ HTML::script('js/foundation.min.js') }}
		{{ HTML::script('js/foundation/foundation.orbit.js') }}

		<link rel="shortcut icon" href="{{ URL::to('images/logo.ico') }}">

		<style>
			#style {
				background-image: url('../images/uc.png') fixed no-repeat;width: 100%;height: 100%;background-position: center;background-size: cover;
			}
		</style>
	</head>

	<body style="background: url('images/uc.png') fixed no-repeat;width: 100%;background-position: center;background-size: cover;">

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
						<img src="{{ URL::to('images/logo_brand.png') }}" class="img-responsive" height="50px" width="55px" style=="padding-top: -10px;">
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
										<li><a href="{{ URL::to('admin') }}">Accounts</a></li>
										<!-- <li><a href="#">Feedbacks</a></li> -->
										<li><a href="{{ URL::to('admin/survey') }}">Survey</a></li>
										<li><a href="{{ URL::to('admin/news') }}">News</a></li>
										<li><a href="{{ URL::to('admin/master') }}">Departments</a></li>
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
		
		<div class="container">

			<div class="row">

				<div class="col-md-9">

					<!-- <div class="jumbotron" style="background-image: url('images/slide_1.jpg'); height: 500px;">

						<h2>Alumni Tracer System</h2>
						<p style="color: black;">uTRACE: Alumni Tracer System is a web and mobile-based that will provides the alumni with the faster and more convenient way of filling-out tracer study. Moreover, the system will generate a graphical data presentation that is timely and reliable alumni facts. The updated and real-time records of the alumni will serve as basis and reference for the admin and faculty's future decision for institutional improvement and development. The system's graphical data presentation and organized interface provides current and reliable facts about the alumni, giving a hassle-free filling-out tracer study for the graduates.</p>
						<p><a href="#" class="btn btn-outline btn-lg btn-success">Getting Started !</a></p>
					</div> -->

					<ul class="example-orbit" data-orbit data-options="timer_speed: 5000; resume_on_mouseout: true; pause_on_hover: false; bullets: false;">
						<li>
							<img src="{{ URL::to('images/slide_2.jpg') }}" alt="slide 1">
							<div class="orbit-caption">
								Caption One
							</div>
						</li>
						<li class="active">
							<img src="{{ URL::to('images/slide_2.jpg') }}" alt="slide 1">
							<div class="orbit-caption">
								Caption One
							</div>
						</li>
						<li>
							<img src="{{ URL::to('images/slide_2.jpg') }}" alt="slide 1">
							<div class="orbit-caption">
								Caption One
							</div>
						</li>
					</ul>

				</div>
				<div class="col-md-3">

					<div class="panel panel-primary">

						<!-- <div class="panel-heading"></div> -->
						<center>
						<img src="{{ URL::to('images/logo_head.png') }}" class="img-responsive" height="45px" width="300px">
						</center>

						<div class="panel-body">
							<a href="{{ URL::to('/register') }}" class="btn btn-outline btn-info btn-block">Sign up.</a>
							<br>
							<a href="{{ URL::to('/login') }}" class="btn btn-outline btn-success btn-block">Sign in.</a>
							<br>
							<a href="{{ URL::to('/login/facebook') }}" class="btn btn-block btn-social btn-facebook btn-outline"><i class="fa fa-facebook"></i> Sign in with Facebook</a>
						</div>

						<!-- <div class="panel-footer">&nbsp;</div> -->
					</div>
							
				</div>
			</div>


			<!-- about dialog -->
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

		</div>

		<div class="container"></div>


		{{ HTML::script('js/sb-admin-2.js') }}
		{{ HTML::script('js/foundation.min.js') }}
		{{ HTML::script('js/foundation/foundation.orbit.js') }}

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
			// $('a').tooltip();

			// $('button[name=send_message]').on('click', function(){
			// 	var lnkpath = "{{ URL::to('user/send-message') }}";
			// 	var subject = $('input[name=feedback_subject]').val();
			// 	var message = $('textarea[name=feedback_message]').val();

			// 	if(message == ''){
			// 		alert('Please provide your message.');
			// 	} else{
			// 		$.ajax({
			// 			url: lnkpath,
			// 			type: 'POST',
			// 			data: {
			// 				'subject': subject,
			// 				'message': message
			// 			},
			// 			beforeSend: function(){
			// 				$('button[name=send_message]').attr('disabled', 'disabled').html('Sending...');
			// 			},
			// 			success: function(response){
			// 				// alert(response);
			// 				window.location.reload();	
			// 			}
			// 		});
			// 	}
			// 	// alert('ss');
			// });

			$(document).foundation();
		</script>

	</body>
</html>