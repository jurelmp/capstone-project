@extends('layout.index')
	
	@section('pagetitle')
		Profile
	@endsection

	@section('head')

		<script>

			$(document).ready(function(){

				$('#show_update').click(function(){
					$('#cancel_update').show();
					$('#update_form').show();
					$('#view_info').hide();
					$(this).hide();
				});
				$('#cancel_update').click(function(){
					$('#show_update').show();
					$(this).hide();
					$('#update_form').hide();
					$('#view_info').show();
				});

				$('#update_btn').click(function(){
					var lnkpath = "{{ URL::to('user/update-profile') }}";
					
					var firstname = $('#update_firstname').val();
					var midname = $('#update_midname').val();
					var lastname = $('#update_lastname').val();
					var gender = $('input[name=update_gender]').val();
					var birthdate = $('#update_birthdate').val();
					var civil_stat = $('#update_civil_stat').val();
					var email = $('#update_email').val();
					var phone_no = $('#update_phone').val();
					var mobile_no = $('#update_mobile').val();
					var province = $('#update_province').val();
					var address = $('#update_address').val();

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'id': id,
							'firstname': firstname,
							'midname': midname,
							'lastname': lastname,
							'gender': gender,
							'birthdate': birthdate,
							'civil_stat': civil_stat,
							'email': email,
							'phone_no': phone_no,
							'mobile_no': mobile_no,
							'address': address
						},
						beforeSend: function(){
							$('#update_btn').attr('disabled', 'disabled').html('Saving...');
						},
						success: function(response){
							if(response != 0){
								$('#update_btn').removeAttr('disabled').html('Save');
								window.location.reload();
							}
							
						}
					});

					// alert('ss');
				});

				$('#update_birthdate').datepicker();

				var img_size = 0.0;
				var k = null;
				// var urlschool = "{{ URL::to('user/schools') }}";
				var profile = "<?php if($profile == null){echo 0;}else{ echo 1;} ?>";
				var schools;

				//page loads hide all unneccessary questions
				$('h3#question6, div#question6').hide();
				$('h3#question7, div#question7').hide();
				$('h3#question8, div#question8').hide();
				$('h3#question9, div#question9').hide();
				$('h3#question10, div#question10').hide();
				$('h3#question11, div#question11').hide();
				$('h3#question12, div#question12').hide();
				$('h3#question13, div#question13').hide();
				$('h3#question14, div#question14').hide();
				$('h3#question15, div#question15').hide();
				$('h3#question16, div#question16').hide();
				$('h3#question17, div#question17').hide();
				$('h3#question18, div#question18').hide();
				$('h3#question19, div#question19').hide();
				$('h3#question20, div#question20').hide();
				$('h3#question21, div#question21').hide();
				$('h3#question22, div#question22').hide();
				$('h3#question23, div#question23').hide();
				$('h3#question24, div#question24').hide();
				$('h3#question26, div#question26').hide();


				if(profile == 0){
					// $('#education, #work_exp, #tracer_survey').hide();
					$('#education_btn, #work_exp_btn, #t_survey_btn').hide();
				} else if(profile == 1){
					// $('#education, #work_exp, #tracer_survey').show();
					$('#education_btn, #work_exp_btn, #t_survey_btn').show();
				}
				$( "#accordion" ).accordion({
			    	collapsible: true,
			    	heightStyle: 'content',
			    	active: false
			    });

				$('#education, #work_exp').hide();

				$('a').tooltip();

				// $('.question_copy').click(function(){
				// 	var index = $(this).attr('rel');
				// 	// alert($(this).attr('rel'));
				// });

				$('input[type=radio][name=question5]').click(function(){
					if($(this).val() == 37 || $(this).val() == 38){
						//No
						$('h3#question6, div#question6').show();
						$('h3#question7, div#question7').hide();
						$('h3#question8, div#question8').hide();
						$('h3#question9, div#question9').hide();

					} else{
						//yes
						$('h3#question6, div#question6').hide();
						$('h3#question7, div#question7').show();
						// $('h3#question8, div#question8').show();
						$('h3#question9, div#question9').show();
					}
					// alert($(this).val());
				});
				$('input[type=radio][name=question7]').click(function(){
					if($(this).val() == 49){
						$('h3#question8, div#question8').show();
					} else{
						$('h3#question8, div#question8').hide();
					}
				});
				$('input[type=radio][name=question9]').click(function(){
					if($(this).val() == 50){
						//yes
						$('h3#question10, div#question10').show();
						$('h3#question11, div#question11').show();
						$('h3#question12, div#question12').show();
						$('h3#question13, div#question13').hide();
						$('h3#question14, div#question14').hide();
					} else{
						//no
						$('h3#question10, div#question10').hide();
						$('h3#question11, div#question11').hide();
						$('h3#question12, div#question12').hide();
						$('h3#question13, div#question13').show();
						$('h3#question14, div#question14').show();
					}
				});
				$('input[type=radio][name=question11]').click(function(){
					if($(this).val() == 59){
						//yes
						$('h3#question12, div#question12').show();
						$('h3#question15, div#question15').show();
						$('h3#question16, div#question16').show();
						$('h3#question17, div#question17').show();
						$('h3#question18, div#question18').show();
						$('h3#question19, div#question19').show();
						$('h3#question20, div#question20').show();
						$('h3#question21, div#question21').show();
						$('h3#question23, div#question23').show();
					} else{
						//no
						$('h3#question12, div#question12').hide();
						$('h3#question15, div#question15').hide();
						$('h3#question16, div#question16').hide();
						$('h3#question17, div#question17').hide();
						$('h3#question18, div#question18').hide();
						$('h3#question19, div#question19').hide();
						$('h3#question20, div#question20').hide();
						$('h3#question21, div#question21').show();
						$('h3#question23, div#question23').hide();
					}
				});
				$('input[type=radio][name=question21]').click(function(){
					if($(this).val() == 111){
						//yes
						$('h3#question22, div#question22').show();
					} else{
						//no
						$('h3#question22, div#question22').hide();
					}
				});
				$('input[type=radio][name=question23]').click(function(){
					if($(this).val() == 119){
						//yes
						$('h3#question24, div#question24').show();
					} else{
						//no
						$('h3#question24, div#question24').hide();
					}
				});
				$('input[type=radio][name=question25]').click(function(){
					if($(this).val() == 128){
						//yes
						$('h3#question26, div#question26').hide();
					} else{
						//no
						$('h3#question26, div#question26').show();
					}
				});


				$('#survey_submit_btn').click(function(){
					var lnkpath = "{{ URL::to('user/surveysubmit') }}";
					var samples = '<?php echo json_encode($questions); ?>';
					var al_id = '<?php $acc_id = Auth::user()->id;
											$j = DB::select("SELECT id FROM alumni WHERE account_id = ? LIMIT 1", array($acc_id));
											$val = null;
											foreach($j as $x){
												$val = $x->id;
											}
											echo $val; ?>';
					var questions = JSON.parse(samples);
					var no_q = Object.keys(questions).length;
					var index = null;

					var data = [];

					var is_empty = false;

					// $('input[type=checkbox][name="question1"]:checked').each(function(i){
					// 	samples[i] = $(this).val();
					// });

					for(index = 1; index < no_q; index++){
						// alert(questions[index].question);
						var q_id = null;
						var c_id = null;
						var answer = null;
						var row = [];
						if(questions[index].type == 0){
							var ans = $('textarea[name=question'+questions[index].id+']').val();

							if(ans != ''){
								data.push({
									'alumni_id': al_id,
									'question_id': questions[index].id,
									'choice_id': null,
									'answer': ans
								});
								// is_empty = false;
							} else {
								// data.push({
								// 	'alumni_id': al_id,
								// 	'question_id': questions[index].id,
								// 	'choice_id': null,
								// 	'answer': null
								// });
							}
							// } else {
								// is_empty = true;
								// alert(questions[index].question + ": Must be answered.");
								// break;
							// }
						} else if(questions[index].type == 1){
							// alert('single');
							var ch_i = $('input[type=radio][name=question'+questions[index].id+']:checked').val();

							if(ch_i != null){
								data.push({
									'alumni_id': al_id,
									'question_id': questions[index].id,
									'choice_id': ch_i,
									'answer': null
								});
							} else {
								// data.push({
								// 	'alumni_id': al_id,
								// 	'question_id': questions[index].id,
								// 	'choice_id': null,
								// 	'answer': null
								// });
							}
								// is_empty = false;
							// } else {
								// is_empty = true;
								
								// alert(questions[index].question + ": Must be answered.");
								// break;
							// }
						} else if(questions[index].type == 2){
							var chk = false;
							
							$('input[type=checkbox][name=question'+questions[index].id+']:checked').each(function(i){
								chk = true;
								data.push({
									'alumni_id': al_id,
									'question_id': questions[index].id,
									'choice_id': $(this).val(),
									'answer': null
								});
							});
							if(!chk){
								// is_empty = true;

								// alert(questions[index].question + ": Must be answered.");
								// break;
							}
							// alert('multiple');
						}
					}

					if(is_empty){
						// Object.keys(data).length == 0

					} else{
						// alert('Success');
						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'data': data
							},
							beforeSend: function(){
								// $('#tracer_survey').replaceWith("<div class='screen_mask'><img src='{{ URL::to('images/ajax-loader.gif') }}'></div>");
								$('#survey_form').fadeOut();
								$('#loading_area').show();
							},
							error: function(jqXHR){
								alert(jqXHR.responseText);
							},
							success: function(response){
								// alert(response);
								window.location.reload();
							}
						});
					}

					
					// alert(Object.keys(questions).length);
					// alert(JSON.parse(data[0]));
					console.log(data);
				});

				$('#t_survey_btn').click(function(){
					$('#basic').hide();
					$('#education').hide();
					$('#work_exp').hide();
					$('#tracer_survey').show('slide', { direction: 'left' }, 1000);
					$(this).addClass('active');
					$('#education_btn').removeClass('active');
					$('#basic_info_btn').removeClass('active');
					$('#work_exp_btn').removeClass('active');
				});
				$('#basic_info_btn').click(function(){
					$('#tracer_survey').hide();
					$('#education').hide();
					$('#work_exp').hide();
					$('#basic').show('slide', { direction: 'left' }, 1000);
					$(this).addClass('active');
					$('#education_btn').removeClass('active');
					$('#work_exp_btn').removeClass('active');
					$('#t_survey_btn').removeClass('active');	
				});
				$('#education_btn').click(function(){
					$('#tracer_survey').hide();
					$('#basic').hide();
					$('#work_exp').hide();
					$('#education').show('slide', { direction: 'left' }, 1000);
					$(this).addClass('active');
					$('#basic_info_btn').removeClass('active');
					$('#t_survey_btn').removeClass('active');	
					$('#work_exp_btn').removeClass('active');
				});
				$('#work_exp_btn').click(function(){
					$('#tracer_survey').hide();
					$('#basic').hide();
					$('#education').hide();
					$('#work_exp').show('slide', {direction: 'left'}, 1000);
					$(this).addClass('active');
					$('#basic_info_btn').removeClass('active');
					$('#t_survey_btn').removeClass('active');	
					$('#education_btn').removeClass('active');
				});

				$('input[name=id_no]').keydown(function(e){
					if($(this).val().length > 7 && e.which !== 8 && e.which !== 46 || (e.which >= 65 && e.which <= 90) || (e.which >= 189 && e.which <= 195)){
						return false;
					}
				});
				$('input[name=cert_rating]').keydown(function(e){
					if($(this).val().length > 4 && e.which !== 8 && e.which !== 46 || (e.which >= 65 && e.which <= 90)){
						return false;
					}
				});

				$('input[name=wrk_date_hired], input[name=wrk_date_finished], input[name=cert_date_taken]').datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: 'yy-mm-dd'
				});


				$('button[name=add_cert_save]').click(function(){
					var lnkpath = "{{ URL::to('user/certificatenew') }}";

					var is_null = "<?php if($certificate == null) echo '0'; else echo '1'; ?>";

					var name = $('input[name=cert_name]').val();
					var desc = $('textarea[name=cert_desc]').val();
					var date_taken = $('input[name=cert_date_taken]').val();
					var rating = $('input[name=cert_rating]').val();

					if(name == '' && date_taken == '' && rating == ''){
						$('#cert_error').html('The fields are required.');
						$('#cert_error').slideDown();
					} else if(name == ''){
						$('#cert_error').html('Please fill in the name.');
						$('#cert_error').slideDown();
					} else if(rating == ''){
						$('#cert_error').html('Please provide the rating.');
						$('#cert_error').slideDown();
					} else if(date_taken == ''){
						$('#cert_error').html('Date taken on the Examination.');
						$('#cert_error').slideDown();
					} else {

						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'name': name,
								'desc': desc,
								'date_taken': date_taken,
								'rating': rating
							},
							error: function(jqXHR){
								alert(jqXHR.responseText);
							},
							success: function(data){
								if(data == 0){
									var str = "";
									str += "<tr>";
									str += "<td><a href='#' class='text-primary' title='"+desc+"'>"+name+"</a></td>";
									str += "<td>"+date_taken+"</td>";
									str += "<td>"+rating+"</td>";
									str += "</tr>";

									$('#add_cert_form .close').click();

									if(is_null == 0)
										$('#cert_table > tbody').html('');

									$('#cert_table > tbody:last').append(str);

									// alert(str);
								}	
							}

						});
						
					}
				});


				$('button[name=wrk_save_btn]').click(function(){
					var lnkpath = "{{ URL::to('user/workexpadd') }}";

					var company = $('select[name=wrk_company]').val();
					var occupation = $('select[name=wrk_occupation]').val();
					var place = $('select[name=wrk_place]').val();
					var date_hired = $('input[name=wrk_date_hired]').val();
					var date_finished = $('input[name=wrk_date_finished]').val();
					
					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'company': company,
							'occupation': occupation,
							'place': place,
							'date_hired': date_hired,
							'date_finished': date_finished
						},
						error: function(jqXHR){
							alert(jqXHR.responseText);
						},
						success: function(data){
							window.location.reload();
						}
					});
				
				});

				$('button[name=add_comp_save_btn]').click(function(){
					var lnkpath = "{{ URL::to('user/companyadd') }}";

					var name = $('input[name=comp_name]').val();
					var email = $('input[name=comp_email]').val();
					var address = $('textarea[name=comp_address]').val();
					var tel_no = $('input[name=comp_tel]').val();
					var mobile_no = $('input[name=comp_mobile]').val();
					var field  = $('select[name=comp_field]').val();

					if(name == '')
						alert('Name is required.');
					else if(field == '')
						alert('Please select a major line.');
					else {

						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'name': name,
								'email': email,
								'address': address,
								'tel_no': tel_no,
								'mobile_no': mobile_no,
								'field': field
							},
							dataType: 'JSON',
							success: function(data){
								var str = '';

								for(var i in data){
									str += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
								}

								$('select[name=wrk_company]').html('');
								$('select[name=wrk_company]').html(str);

								$('#add_company_form').modal('hide');
								$('#add_work_form').modal('show');
							}
						});
					}
				});

				$('button[name=show_add_company_form]').click(function(){
					$('#add_company_form').modal('show');
					$('#add_work_form').modal('hide');
				});
				$('button[name=add_comp_bck_btn]').click(function(){
					$('#add_company_form').modal('hide');
					$('#add_work_form').modal('show');
				});


				$('button[name=show_add_school_btn]').click(function(){
					$('input[type=text][name=add_school_name]').fadeIn();
					$('button[name=save_add_school_btn]').fadeIn();
					$('button[name=cancel_add_school_btn]').fadeIn();
					$('select[name=d_school]').fadeOut();
					$(this).fadeOut();
				});

				$('button[name=cancel_add_school_btn]').click(function(){
					$('input[type=text][name=add_school_name]').fadeOut();
					$('button[name=save_add_school_btn]').fadeOut();
					$(this).fadeOut();
					$('button[name=show_add_school_btn]').fadeIn();
					$('select[name=d_school]').fadeIn();
				});

				$('button[name=save_add_school_btn]').click(function(){
					var lnkpath = "{{ URL::to('user/schooladd') }}";

					var sch_name = $('input[type=text][name=add_school_name]').val();

					if(sch_name != ''){
						$('button[name=cancel_add_school_btn]').fadeIn();

						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'sch_name': sch_name
							},
							dataType: 'JSON',
							success: function(data){
								var str = '';
								
								$('button[name=cancel_add_school_btn]').fadeOut();
								$('select[name=d_school]').fadeIn();
								$('input[type=text][name=add_school_name]').val();
								$('button[name=save_add_school_btn]').fadeOut();
								$('input[type=text][name=add_school_name]').fadeOut();
								$('button[name=show_add_school_btn]').fadeIn();

								for(var n in data){
									str += "<option value='"+data[n].id+"'>"+data[n].name+"</option>";
								}

								$('select[name=d_school]').html(str);
							}
						});
					} else {
						alert('Field is required.');
					}

				});


				// $('a[href*=#]:not([href=#])').click(function(){
				// 	if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname){
				// 		var target = $(this.hash);
				// 		target = target.length ? target : $('[name='+this.hash.slice(1)+']');

				// 		if(target.length){
				// 			$('html, body').animate({
				// 				scrollTop: target.offset().top;
				// 			}, 2000);
				// 			return false;
				// 		}
				// 	}
				// });

				// function readURL(input){
				// 	if(input.files && input.files[0]){
				// 		var reader = new FileReader();
				// 		reader.onload = function(e){
				// 			$('#preview_image').attr('src', e.target.result);
				// 		}
				// 		reader.readAsDataURL(input.files[0]);
				// 	}
				// }
				// $('#img_upload').change(function(){
				// 	readURL(this);
				// });
				
				// $('#education').click(function(){
				// 	$('#basic').fadeOut();
				// });

				// $('#basic_info').click(function(){
				// 	$('#basic').fadeIn();
				// });
				
				$('#img_upload').change(function(){
					var filesToUpload = document.getElementById('img_upload').files;
					var file = filesToUpload[0];

					var img = document.createElement('img');

					var reader = new FileReader();

					reader.onload = function(e){
						img.src = e.target.result;

						var canvas = document.createElement('canvas');

						var ctx = canvas.getContext('2d');
						ctx.drawImage(img, 0, 0);

						var MAX_WIDTH = 200;
						var MAX_HEIGHT = 200;
						var width = img.width;
						var height = img.height;

						if(width > height){
							if(width > MAX_WIDTH){
								height *= MAX_WIDTH / width;
								width = MAX_WIDTH;
							}
						} else {
							if(height > MAX_HEIGHT){
								width *= MAX_HEIGHT / height;
								height = MAX_HEIGHT;
							}
						}
						canvas.width = width;
						canvas.height = height;
						ctx.drawImage(img, 0, 0, width, height);

						var dataurl = canvas.toDataURL('image/png');
						document.getElementById('preview_image').src = dataurl;
					}
					reader.readAsDataURL(file);
				});


				// setTimeout(function(){
				// 	$('.progress .bar').each(function(){
				// 		var me = $(this);
				// 		var perc = me.attr('aria-valuemax');

				// 		var current_perc = 0;

				// 		var progress = setInterval(function(){
				// 			if(current_perc >= perc){
				// 				clearInterval(progress);
				// 			} else {
				// 				current_perc += 1;
				// 				me.css('width', (current_perc)+'%');
				// 			}
				// 			me.text((current_perc)+'%');
				// 		}, 50);
				// 	});
				// }, 300);
				
				$('select[name=region]').on('change', function(){
					// alert($(this).val());
					var lnkpath = "{{ URL::to('alumni/province') }}";
					var r_id = $(this).val();

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'region_id': r_id
						},
						dataType: 'JSON',
						success: function(data){
							var str = '<option>SELECT</option>';
							for (var i = 0; i < data.length; i++) {
								str += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
							};
							$('select[name=province]').html(str);
							// alert(str);
						}
					});
				});

				$('select[name=department]').on('change', function(){
					var lnkpath = "{{ URL::to('alumni/course') }}";
					var dept_id = $(this).val();

					// alert(dept_id);
					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'dept_id': dept_id
						},
						dataType: 'JSON',
						success: function(course){
							var str = '<option>SELECT</option>';
							for (var i = 0; i < course.length; i++) {
								str += "<option value='" + course[i].id + "'>" + course[i].title + "</option>";
							};
							$('select[name=course]').html(str);
							// alert(str);
						}

					});
				});


				
				$('#create_btn').click(function(){
					var lnkpath = "{{ URL::to('user/basicinfo') }}";
					var lnkpath2 = "{{ URL::to('user/uploadphoto') }}";

					var image = $('input[name=img_upload]').prop('files')[0];
					var frm_data = new FormData();
					frm_data.append('img', image);
					
					// var image = $('input[name=img_upload]').val();
					var studno = $('input[name=id_no]').val();
					var fname = $('input[name=firstname]').val();
					var mname = $('input[name=midname]').val();
					var lname = $('input[name=lastname]').val();
					var gender = $('select[name=gender]').val();
					var birthdate = $('input[name=birthdate]').val();
					var civil_stat = $('select[name=civil_stat]').val();
					var phone_no = $('input[name=phone_number]').val();
					var mobile_no = $('input[name=mobile_number]').val();
					var region = $('select[name=region]').val();
					var province = $('select[name=province]').val();
					var address = $('textarea[name=address]').val();
					var department = $('select[name=department]').val();
					var course = $('select[name=course]').val();
					var term = $('select[name=term]').val();
					var year = $('select[name=year_graduated]').val();

					var imagepath = $('#temp').val();


					if(fname == '')
						alert('First name is required.');
					else if(mname == '')
						alert('Middle name is required.');
					else if(lname == '')
						alert('Last name is required.');
					else if(gender == null)
						alert('Select your gender.');
					else if(birthdate == '')
						alert('Birthdate is required.');
					else if(civil_stat == null)
						alert('Select your status.');
					else if(region == null)
						alert('Select your region of Origin.');
					else if(province == '')
						alert('Select your province.');
					else if(address == '')
						alert('Address field is required.');
					else if(department == '')
						alert('Select your department.');
					else if(course == null)
						alert('Select your course.');
					else if(term == '')
						alert('Select term graduated.');
					else if(year == '')
						alert('Select year graduated.');
					else if(img_size > 2)
						alert('Image size exceeded please choose another image.')
					else {
						// alert('success');

						if(img_size < 2){
							$.ajax({
								url: lnkpath2,
								type: 'POST',
								data: frm_data,
								dataType: 'TEXT',
								error: function(jqXHR){
									alert(jqXHR.responseText);
								},
								success: function(data){
									if(data != 0)
										k = data;
									else
										k = '';

									// console.log(data);
									// $('#temp').val(data);
									// alert(data);
									imagepath = k;

									$.ajax({
										url: lnkpath,
										type: 'POST',
										data: {
											'image': imagepath,
											'studno': studno,
											'fname': fname,
											'mname': mname,
											'lname': lname,
											'gender': gender,
											'birthdate': birthdate,
											'civil_stat': civil_stat,
											'phone_no': phone_no,
											'mobile_no': mobile_no,
											'region': region,
											'province': province,
											'address': address,
											'course': course,
											'term': term,
											'year': year
										},
										error: function(jqXHR, text_status, strError, error){
											alert(jqXHR.responseText + text_status + strError + error);
										},
										beforeSend: function(){

										},
										success: function(data){
											window.location.reload();
											// alert($('#temp').val());
										}
									});
								},
								cache: false,
						        contentType: false,
						        processData: false
							});
						}
					}
					
				});
				

				$('input[name=img_upload]').change(function(){
					img_size = this.files[0].size / 1024 / 1024;
					// alert(this.files[0].size/1024/1024);
				});


				$('button[name=d_save_btn]').click(function(){
					var program = $('input[type=text][name=d_program]').val();
					var title = $('select[name=d_title]').val();
					var year = $('select[name=d_year_graduated]').val();
					var school = $('select[name=d_school]').val();
					var award = $('textarea[name=d_awards]').val();

					var lnkpath = "{{ URL::to('user/degreeadd') }}";

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'program': program,
							'title': title,
							'year': year,
							'school': school,
							'award': award
						},
						error: function(jqXHR){
							alert(jqXHR.responseText);
						},
						success: function(data){
							if(data == 0)
								window.location.reload();		
						}
					});
				});


				$('#verify_profile').click(function(){
					var lnkpath = "{{ URL::to('user/verify-profile') }}";

					var studno = $('input[name=id_no]').val();

					$.ajax({
						url: lnkpath,
						type: 'POST',
						data: {
							'studno': studno
						},
						beforeSend: function(){

						},
						success: function(data){
							if(data == 0){
								alert('No Data');
							} else{
								alert(data);

							}
							
						}
					})

					// alert(studno);
				});


			});
		</script>

	@endsection


	@section('content')

		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">&nbsp;</div>

				<div class="panel-body">

					<div class="col-md-3">

						<div class="list-group">
							<a id="basic_info_btn" href="#" class="list-group-item active">Basic Information</a>
							<a id="education_btn" href="#" class="list-group-item">Education</a>
							<a id="work_exp_btn" href="#" class="list-group-item">Work Experience</a>
							<a id="t_survey_btn" href="#" class="list-group-item">Tracer Survey</a>
						</div>

						<!-- <div class="panel panel-default">
							<div class="panel-heading">Progress</div>

							<div class="panel-body"> -->
								<div class="row">
									<div class="col-md-12">
										<div class="progress">
											<?php
												$br = 0;
												$wr = 0;
												$er = 0;
												$tr = 0;
												$cr = 0;
												$avg = 0.0;
												if($profile != null){
													$br = 1;
												}
												if($work_exp != null){
													$wr = 1;
												}
												if($degree != null){
													$er = 1;
												} 
												if($a_tracer != null){
													$tr = 1;
												}
												if($certificate != null){
													$cr = 1;
												}
												$avg = (($br + $wr + $er + $tr + $cr)/5)*100;
												$a = "width: " . $avg . "%";
											?>
											<div class="progress-bar progress-bar-primary progress-bar-striped bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="{{ $a }}">{{ $avg }} %<span></span>
											</div>
										</div>
									</div>
								</div>
							<!-- </div>
						</div> -->


					</div>

					<div class="col-md-9">	

						<div id="basic">
							<h4>Basic Information</h4>
							<hr>
						@if($profile == null)
							<div class="row">
								<div class="col-md-5">
									<img src="{{ URL::to('images/unknown.png') }}" alt="Preview Image" class="img-thumbnail" id="preview_image">
									<!-- {{ HTML::image('images/unknown.png', 'alt', array('class' => 'img-thumbnail', 'id' => 'preview_image')) }} -->
									<input type="file" name="img_upload" accept="image/*" id="img_upload">
									<input type="hidden" id="temp" class="form-control">
									<br>
								</div>

								<div class="col-md-5 col-md-offset-1">
									<br><br><br><br><br><br><br>
									<div class="row">
										<label for="id_no">Student Number</label>
										<a href="#" class="text-primary" title="For Verification" id="verify_profile"><span class="glyphicon glyphicon-check"></span> Check </a>
										<input type="text" class="form-control" name="id_no" placeholder="required">
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-5">
									<div class="row">
										<label for="firstname">First Name</label>
										<input type="text" class="form-control" name="firstname" value="{{ Auth::user()->firstname }}" required>
									</div>
									<div class="row">
										<label for="midname">Middle Name</label>
										<input type="text" class="form-control" name="midname" value="{{ Auth::user()->midname }}" required>
									</div>
									<div class="row">
										<label for="lastname">Last Name</label>
										<input type="text" class="form-control" name="lastname" value="{{ Auth::user()->lastname }}" required>
									</div>	
								</div>

								<div class="col-md-5 col-md-offset-1">
									<div class="row">
										<label for="birthdate">Birth Date</label>
										<input type="date" class="form-control" name="birthdate" required>
									</div>
									<div class="row">
										<label for="gender">Gender</label>
										<select class="form-control" name="gender" required>
											<option>SELECT</option>
											<option value="1">Male</option>
											<option value="2">Female</option>
										</select>
										<!-- <input type="text" class="form-control" name="midname"> -->
									</div>
									<div class="row">
										<label for="lastname">Civil Status</label>
										<select class="form-control" name="civil_stat" required>
											<option>SELECT</option>
											<option value="1">Single</option>
											<option value="2">Married</option>
											<option value="3">Separated Divorce</option>
											<option value="4">Single Parent</option>
											<option value="5">Widow/Widower</option>
										</select>
										<!-- <input type="text" class="form-control" name="lastname"> -->
									</div>
								</div>
							</div>
							<br>
							<h4>Contact Information</h4>
							<hr>
							<div class="row">
								<div class="col-md-5">
									<div class="row">
										<label for="phone_number">Phone Number</label>
										<input type="text" class="form-control" name="phone_number">
									</div>
									<div class="row">
										<label for="region">Region of Origin</label>
										<select class="form-control" name="region" required>
											<option>SELECT</option>
											@foreach($region as $r)
												<option value="{{ $r->id }}">{{ $r->name }}</option>
											@endforeach
										</select>
										<!-- <input type="email" class="form-control" name="alt_email"> -->
									</div>
								</div>
								<div class="col-md-5 col-md-offset-1">
									<div class="row">
										<label for="mobile_number">Mobile Number</label>
										<input type="text" class="form-control" name="mobile_number">
									</div>
									<div class="row">
										<label for="province">Province</label>
										<select class="form-control" name="province" required>

										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-11">
									<div class="row">
										<label for="address">Complete Address</label>
										<textarea name="address" class="form-control" rows="2" required></textarea>
									</div>
								</div>
							</div>
							<br>
							<h4>Degree Information</h4>
							<hr>
							<div class="row">
								<div class="col-md-5">
									<div class="row">
										<label for="department">Department</label>
										<select class="form-control" name="department">
											<option>SELECT</option>
											@foreach($dept as $d)
												<option value="{{ $d->id }}">{{ $d->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="row">
										<label for="term">Term Graduated</label>
										<select class="form-control" name="term">
											<option>SELECT</option>
											<option value="1">1st Semester</option>
											<option value="2">2nd Semester</option>
											<option value="3">Summer</option>
										</select>
									</div>
								</div>

								<div class="col-md-5 col-md-offset-1">
									<div class="row">
										<label for="course">Course</label>
										<select class="form-control" name="course">

										</select>
									</div>

									<div class="row">
										<label for="year_graduated">Year Graduated</label>
										<select class="form-control" name="year_graduated">
											<option>SELECT</option>
											<?php
												$y = date('Y');
												for ($i=1994; $i <= $y; $i++) { 
													echo "<option value='".$i."'>".$i."</option>";
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-11">
									<br>
									<button class="btn btn-md btn-success pull-right" id="create_btn"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;SAVE</button>
								</div>
							</div>
							
						@else
							
							<div class="row">
								<div class="col-md-3">
									<?php
										$path = $profile{0}->pic_path;
										if($path == null){
											$url = URL::to('images/unknown.png');
										} else {
											$url = URL::to($path);
										}
										// $img = Image::make(".".$path."'");
										// $img->resize(200,200);
										// $img->save(".".$url."'");
									?>
									<img src="{{ $url }}" class="img-thumbnail" width="200" height="200">

								
										<?php
											if($profile{0}->is_confirmed == 0)
												echo "<p class='label label-danger'>pending</p>";
											else
												echo "<p class='label label-success'>verified</p>";
										?>
								
								</div>
								<div class="col-md-9">
									<!-- for update -->
									<button id="show_update">Edit</button>
									<button id="cancel_update" style="display: none;">Cancel</button>

									<div id="update_form" style="display: none;">

										<button id="update_btn" class="pull-right btn btn-md btn-success">Save</button>
										<table class="table table-bordered">
											<tr><td colspan="2"><h4>
												<div class="col-md-4">
													<input id="update_firstname" type="text" value="{{ $profile{0}->firstname }}" class="form-control">
												</div>
												<div class="col-md-4">
													<input id="update_midname" type="text" value="{{ $profile{0}->midname }}" class="form-control">
												</div>
												<div class="col-md-4">
													<input id="update_lastname" type="text" value="{{ $profile{0}->lastname }}" class="form-control">
												</div>
												
											</h4></td></tr>
											<tr>
												<td width="200">Gender</td>
												<td>
													@if($profile{0}->gender == 1)
														<input name="update_gender" type="radio" checked="checked" value="1">Male
														<input name="update_gender" type="radio" value="2">Female
													@elseif($profile{0}->gender == 2)
														<input name="update_gender" type="radio" value="1">Male
														<input name="update_gender" type="radio" checked="checked" value="2">Female
													@endif
												</td>
											</tr>
											<tr>
												<td width="200">Birthdate</td>
												<td>
													<input id="update_birthdate" type="text" value="{{ $profile{0}->birthdate }}" class="form-control">
												</td>
											</tr>
											<tr>
												<td width="200">Civil Status</td>
												<td>
													<select id="update_civil_stat" class="form-control">
														@foreach($civil_status as $civil)

															@if($civil->id == $profile{0}->civil_stat)
																<option value="{{ $civil->id }}" selected="selected">{{ $civil->value }}</option>
															@else
																<option value="{{ $civil->id }}">{{ $civil->value }}</option>
															@endif
														@endforeach
													</select>
												</td>
											</tr>
											<tr>
												<td width="200">Email</td>
												<td><input id="update_email" type="text" value="{{ Auth::user()->email }}" class="form-control"></td>
											</tr>
											<tr>
												<td width="200">Phone No</td>
												<td><input id="update_phone" type="text" value="{{ $profile{0}->tel_no }}" class="form-control"></td>
											</tr>
											<tr>
												<td width="200">Mobile No</td>
												<td><input id="update_mobile" type="text" value="{{ $profile{0}->mobile_no }}" class="form-control"></td>
											</tr>
											<!-- <tr>
												<td width="200">Region of Origin</td>
												<td>
													<select id="update_region" class="form-control">
														@foreach($region as $reg)
															@if($reg->id == $profile{0}->region_id)
																<option value="{{ $reg->region_id }}" selected="selected">{{ $reg->name }}</option>
															@else
																<option value="{{ $reg->region_id }}">{{ $reg->name }}</option>
															@endif
														@endforeach
													</select>
												</td>
											</tr> -->
											<tr>
												<td width="200">Province</td>
												<td>
													<select id="update_province" class="form-control">
														@foreach($province as $p)
															@if($p->id == $profile{0}->province_id)
																<option value="{{ $p->id }}" selected="selected">{{ $p->name }}</option>
															@else
																<option value="{{ $p->id }}">{{ $p->name }}</option>
															@endif
														@endforeach
													</select>
												</td>
											</tr>
											<tr>
												<td width="200">Complete Address</td>
												<td><textarea id="update_address" class="form-control" rows="2">{{ $profile{0}->address }}</textarea></td>
											</tr>
										</table>
										
									</div>
									<!-- end for update -->

									<div id="view_info">
										<table class="table table-bordered">
											<tr>
												<td colspan="3"><h4 class="text-primary"> {{ $profile{0}->firstname }} {{ $profile{0}->midname }} {{ $profile{0}->lastname }} </h4></td>
												
											</tr>
											<tr>
												<td width="200">Gender</td>
												@if($profile{0}->gender == 1)
													<td>Male</td>
												@else
													<td>Female</td>
												@endif
											</tr>
											<tr>
												<td width="200">Birthdate</td>
												<td>
													<?php
														$bdate = $profile{0}->birthdate;
														echo date('M d, Y', strtotime($bdate));
													?>
												</td>
											</tr>
											<tr>
												<td width="200">Civil Status</td>
												<td>
													<?php
														$cs = $profile{0}->civil_stat;

														if($cs == 1)
															echo 'Single';
														else if($cs == 2)
															echo 'Married';
														else if($cs == 3)
															echo 'Separated Divorce';
														else if($cs == 4)
															echo 'Single Parent';
														else if($cs == 5)
															echo 'Widow/Widower';
													?>
												</td>
											</tr>
											<tr>
												<td width="200">Email</td>
												<td> {{ Auth::user()->email }} </td>
											</tr>
											<tr>
												<td width="200">Phone No.</td>
												<td> {{ $profile{0}->tel_no }} </td>
											</tr>
											<tr>
												<td width="200">Mobile No.</td>
												<td> {{ $profile{0}->mobile_no }} </td>
											</tr>
											<tr>
												<td width="200">Region of Origin</td>
												<td>
													<?php
														$r_id = $profile{0}->region_id;
														$r = DB::select('SELECT name FROM regions WHERE id = ?', array($r_id));
														echo $r{0}->name;
													?>
												</td>
											</tr>
											<tr>
												<td width="200">Province</td>
												<td>
													<?php
														$p_id = $profile{0}->province_id;
														$p = DB::select('SELECT name FROM provinces WHERE id = ?', array($p_id));
														echo $p{0}->name;
													?>
												</td>
											</tr>
											<tr>
												<td width="200">Complete Address</td>
												<td> {{ $profile{0}->address }} </td>
											</tr>
											<tr>
												<td width="200">Course</td>
												<td>
													<?php
														$c_id = $profile{0}->course_id;
														$c = DB::select('SELECT title FROM course WHERE id = ?', array($c_id));
														echo $c{0}->title;
													?>
												</td>
											</tr>
											<tr>
												<td width="200">Year Graduated</td>
												<td> {{ $profile{0}->year_graduated }} </td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						@endif
						</div><br>
	
						
						<div id="education">
							
							<div class="modal fade" id="add_degree_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">Degree</h4>
										</div>

										<div class="modal-body">
											<div class="row">
												<div class="col-md-4">
													<label>Program</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="d_program">
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-4">
													<label>Title</label>
												</div>
												<div class="col-md-8">
													<!-- <input type="text" class="form-control"> -->
													<select class="form-control" name="d_title">
														<option>SELECT</option>
														@foreach($deg_title as $dt)
															<option value="{{ $dt->id }}">{{ $dt->value }}</option>
														@endforeach
													</select>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-4">
													<label>Year Graduated</label>
												</div>
												<div class="col-md-8">
													<select class="form-control" name="d_year_graduated">
														<option>SELECT</option>
														<option value="0">ON-GOING</option>
														<?php
															$yr = date('Y');

															for ($i=1950; $i <= $yr  ; $i++) { 
																echo "<option value='".$i."'>".$i."</option>";
															}
														?>
													</select>
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-4">
													<label>School Attended</label>
												</div>
												<div class="col-md-8">
													<select class="form-control" name="d_school">
														<option>SELECT</option>
														@foreach($school as $sch)
															<option value="{{ $sch->id }}">{{ $sch->name }}</option>
														@endforeach
													</select>
													<div class="row">
														<div class="col-md-4">
															<button style="display: none;" name="cancel_add_school_btn" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-remove"></span></button>
															<button name="show_add_school_btn" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span></button>
															<button style="display: none;" name="save_add_school_btn" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-floppy-disk"></span></button>
														</div>
														<div class="col-md-8">
															<input type="text" style="display: none;" class="form-control" name="add_school_name" placeholder="School Name">
														</div>
													</div>
													
												</div>
											</div>
											<br>
											<div class="row">
												<div class="col-md-4">
													<label>Awards Received</label>
													<p class="text-danger">Leave blank if not applicable.</p>
												</div>
												<div class="col-md-8">
													<textarea class="form-control" rows="2" name="d_awards"></textarea>
												</div>
											</div>
																							
										</div>

										<div class="modal-footer">
											<button class="btn btn-success" type="button" name="d_save_btn">Save</button>
										</div>
									</div>
								</div>
							</div>


							<h4 class="pull-left">Degree</h4>
							<button class="btn btn-md btn-success pull-right" id="add_degree_btn" data-toggle="modal" data-target="#add_degree_form">Add</button><br>
							<hr>
						
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Title</th>
										<th>Program</th>
										<th>School Attended</th>
										<th>Year Graduated</th>
										<th>Awards</th>
									</tr>
								</thead>
								<tbody>
									@if($degree == null)
										<tr>
											<td colspan="5" align="center">No Data</td>
										</tr>
									@else
										@foreach($degree as $dgree)
											<tr>
												<td>
													<?php
														$d_t = DB::select('SELECT value FROM degree_title WHERE id = ?', array($dgree->deg_title_id));
														echo $d_t{0}->value;
													?>
												</td>
												<td>{{ $dgree->program }}</td>
												<td>
													<?php
														$s_a = DB::select('SELECT name FROM school WHERE id = ?', array($dgree->school_id));
														echo $s_a{0}->name;
													?>
												</td>
												<td>
													@if($dgree->year_graduated == 0)
														{{ 'ON-GOING' }}
													@else
														{{ $dgree->year_graduated }}
													@endif
												</td>
												<td>{{ $dgree->awards }}</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
							<br>

							<div class="modal fade" id="add_cert_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">Add New</h4>
										</div>

										<div class="modal-body">
											<div class="alert alert-danger" style="display: none;" id="cert_error">

											</div>

											<div class="row">
												<div class="col-md-4">
													<label for="cert_name">Name of Examination</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="cert_name">
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label for="cert_date_taken">Date Taken</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="cert_date_taken">
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label for="cert_rating">Rating</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="cert_rating">
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label for="cert_desc">Description <span class="text-muted">optional</span></label>
												</div>
												<div class="col-md-8">
													<textarea rows="2" class="form-control" name="cert_desc"></textarea>
												</div>
											</div>

										</div>

										<div class="modal-footer">
											<button class="btn btn-md btn-success" name="add_cert_save">Save</button>
										</div>
									</div>
								</div>
							</div>

							<h4 class="pull-left">Professional Examination Passed</h4>
							<button class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add_cert_form">Add</button><br>
							<hr>
							<table class="table table-bordered table-hover" id="cert_table">
								<thead>
									<tr>
										<th>Name of Examination</th>
										<th>Date Taken</th>
										<th>Rating</th>
									</tr>
								</thead>
								<tbody>
									@if($certificate == null)
										<tr>
											<td colspan="3" align="center">No Data</td>
										</tr>
									@else
										@foreach($certificate as $cert)
											<tr>
												<td>
													<a href="#" class="text-primary" title="{{ $cert->description }}">{{ $cert->title }}</a>
												</td>
												<td>{{ $cert->date_taken }}</td>
												<td>{{ $cert->rating }}</td>
											</tr>

										@endforeach
									@endif
								</tbody>
							</table>
						
						</div><br>
						

						<div id="work_exp">

							<div class="modal fade" id="add_company_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Add Company</h4>
										</div>

										<div class="modal-body">
											<div class="row">
												<div class="col-md-4">
													<label>Company Name</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="comp_name" class="form-control">
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Email / Website</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="comp_email" class="form-control">
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Address</label>
												</div>
												<div class="col-md-8">
													<textarea name="comp_address" class="form-control" rows="2"></textarea>
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Telephone No.</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="comp_tel">
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Mobile No.</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="comp_mobile">
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Major line business of the company.</label>
												</div>
												<div class="col-md-8">
													<select class="form-control" name="comp_field">
														<option>SELECT</option>
														@foreach($field as $fld)
															<option value="{{ $fld->id }}">{{ $fld->name }}</option>
														@endforeach
													</select>
												</div>
											</div>

										</div>

										<div class="modal-footer">
											<button class="btn btn-default" name="add_comp_bck_btn">Back</button>
											<button class="btn btn-success" name="add_comp_save_btn">Save</button>
										</div>
									</div>
								</div>
							</div>

							<div class="modal fade" id="add_work_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">Work Experience</h4>
										</div>

										<div class="modal-body">
											<div class="row">
												<div class="col-md-4">
													<label>Company</label>
												</div>
												<div class="col-md-8">
													<select class="form-control" name="wrk_company">
														<option>SELECT</option>
														@foreach($company as $comp)
															<option value="{{ $comp->id }}">{{ $comp->name }}</option>

														@endforeach
													</select>
													<button class="btn btn-sm btn-default" name="show_add_company_form"><span class="glyphicon glyphicon-plus"></span></button>
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Occupation</label>
												</div>
												<div class="col-md-8">
													<select class="form-control" name="wrk_occupation">
														<option>SELECT</option>

														@foreach($jobs as $job)
															<option value="{{ $job->id }}">{{ $job->job }}</option>
														@endforeach

													</select>
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Place of Work</label>
												</div>
												<div class="col-md-8">
													<select class="form-control" name="wrk_place">
														<option>SELECT</option>
														<option value="1">Local</option>
														<option value="2">Abroad</option>
													</select>
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Date Hired</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="wrk_date_hired">
												</div>
											</div><br>
											<div class="row">
												<div class="col-md-4">
													<label>Date Finished</label><p>Leave blank if on going.</p>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="wrk_date_finished">
												</div>
											</div>
																							
										</div>

										<div class="modal-footer">
											<button class="btn btn-success" type="button" name="wrk_save_btn">Save</button>
										</div>
									</div>
								</div>
							</div>

							<h4 class="pull-left">Work Experience</h4>
							<button class="btn btn-md btn-success pull-right" data-toggle="modal" data-target="#add_work_form">Add</button><br>
							<hr>
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Company</th>
										<th>Occupation</th>
										<th>Place of Work</th>
										<th>Date Hired</th>
										<th>Date Finish</th>
									</tr>
								</thead>
								<tbody>
									@if($work_exp == null)
									<tr>
										<td colspan="5" align="center">No Data</td>
									</tr>
									@else
										@foreach($work_exp as $w_e)
											<tr>
												<td>
													<?php
														$i = $w_e->company_id;
														$wr_e = DB::select("SELECT * FROM company WHERE id = ?", array($i));
														echo $wr_e{0}->name;
													?>
												</td>
												<td>
													<?php
														$in = $w_e->occupation_id;
														$wr_e1 = DB::select("SELECT * FROM occupation WHERE id = ?", array($in));
														echo $wr_e1{0}->title;
													?>
												</td>
												<td>
													@if($w_e->place_of_work == 1)
														Local
													@else
														Abroad
													@endif
												</td>
												<td>{{ $w_e->date_hired }}</td>
												<td>
													@if($w_e->date_finished == null)
														present
													@else
														{{ $w_e->date_finished }}
													@endif
												</td>
											</tr>

										@endforeach
									@endif
								</tbody>
							</table>
						</div>


						<div id="tracer_survey" style="display: none;">
							<h4>Tracer Survey</h4>
							<hr>
							<div style="display: none; text-align: center;" id="loading_area"><img src='{{ URL::to("images/ajax-loader.gif") }}' width="80" height="80"></div>
							@if($a_tracer == null)
								<div id="survey_form">
									<div id="accordion">
										@foreach($questions as $s_q)
											@if($s_q->id != 0)
											<?php
												$q_i = $s_q->id;
												$name_q = "question".$s_q->id;
												$cc = DB::select("SELECT * FROM survey_choices WHERE question_id = ?", array($q_i));
											?>
											
												<h3 class="question_copy" rel="{{ $s_q->id }}" id="{{ $name_q }}">{{ $s_q->question }}</h3>
												<div id="{{ $name_q }}">
													
													@if($s_q->type == 0)
														<textarea class="form-control" rows="2" name="{{ $name_q }}"></textarea>
													@elseif($s_q->type == 1)
														@foreach($cc as $c)
															<input type="radio" name="{{ $name_q }}" value="{{ $c->id }}">&nbsp;{{ $c->choice }}<br>
														@endforeach
													@elseif($s_q->type == 2)
														@foreach($cc as $c)
															<input type="checkbox" name="{{ $name_q }}" value="{{ $c->id }}">&nbsp;{{ $c->choice }}<br>
														@endforeach
															<!-- <input type="checkbox" name="{{ $name_q }}">&nbsp;Other -->
													@endif
												</div>
											
											@endif
										@endforeach
									</div><br>
									<button class="btn btn-md btn-success pull-right" id="survey_submit_btn">Submit</button>
								</div>
							@else
								
								<table class="table table-bordered table-striped">
									<?php
										$chck_id = null;
									?>
									@foreach($a_tracer as $t_answer)
										
										<tr>
											<td width="60%"><span class='text-primary'>{{ $t_answer->question }}</span></td>
											<td width="40%">
												@if($t_answer->choice_id == 0)
													{{ $t_answer->answer }}
												@else
													{{ $t_answer->choice }}
												@endif
												
											</td>
										</tr>

									@endforeach

								</table>
									
							@endif
							
						</div>
						
					</div>
				</div>

				<div class="panel-footer">&nbsp;</div>
			</div>	
		</div>

		<div class="container"></div>
	@endsection
@stop