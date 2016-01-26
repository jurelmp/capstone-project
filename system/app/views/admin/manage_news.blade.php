@extends('layout.index')

	@section('pagetitle')
		Manage News
	@endsection

	@section('head')

		<script>
			$(document).ready(function(){
				var g_title = '';
				var g_content = '';

				// $('#news_table').tablesorter();
				$('#news_table').dataTable();

				tinymce.init({
					selector: "textarea#n_content, #u_content",
					plugins: [
				        "lists print autolink preview table textcolor hr link",
				    ],
				    tools: "inserttable",
					toolbar: " undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ",
					autosave_ask_before_unload: false,
					height: 300
				});


				$('#create_news').on('click', function(){
					$('#n_title').val('');
					tinyMCE.activeEditor.setContent('');
				});

				$('#btn_create_news').on('click', function(){
					var title = $('#n_title').val();
					var content = tinyMCE.activeEditor.getContent();
					var chck = "{{ Auth::check() }}";
					if(chck == 1){
						var acc_id = "{{ Auth::user()->id }}";
					}
					// var name = '';
					
					var lnkpath1 = "{{ URL::to('admin/accountname') }}";
					var lnkpath2 = "{{ URL::to('admin/createnews') }}";

					$.ajax({
						url: lnkpath1,
						type: 'GET',
						dataType: 'JSON',
						success: function(name){
							name = name[0].firstname + name[0].midname + name[0].lastname;
						}
					});

					if((title != '') && (content != '')){
						$.ajax({
							url: lnkpath2,
							type: 'POST',
							data: {
								'title': title,
								'content': content,
								'account_id': acc_id
							},
							success: function(data){
								if(data == 1){
									alert('Successfully Created.');
									window.location.reload();
								} else {
									alert('Something went wrong.')
								}
							}
						});
						
					} else {
						alert('The fields are need to be filled in.');
					}

				});

				
				$('.update_news').on('click', function(){
					var up_id = $(this).attr('rel');
					var lnkpath = "{{ URL::to('admin/newsinfo') }}";

					$.ajax({
						url: lnkpath,
						type: 'GET',
						data: {
							'id': up_id
						},
						dataType: 'JSON',
						success: function(data){
							var t = data[0].title;
							var c = data[0].content;
							var i = data[0].id;

							g_content = c;
							g_title = t;

							$('#u_id').val(i);
							$('#u_title').val(t);
							tinyMCE.activeEditor.setContent(c);
						}
					});
					// alert(n_id);
				});


				$('.del_news').on('click', function(){
					var del_id = $(this).attr('rel');
					var lnkpath = "{{ URL::to('admin/deletenews') }}";

					if(confirm('Are you sure you want to delete this post?')){
						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'del_id': del_id
							},
							success: function(data){
								if(data == 1){
									// alert('Successfully deleted.');
									window.location.reload();
								}
							}
						});
					}
					
					// alert(n_id);
				});


				$('#btn_update_news').on('click', function(){
					var title = $('#u_title').val();
					var content = tinyMCE.activeEditor.getContent();
					var id = $('#u_id').val();
					var lnkpath = "{{ URL::to('admin/updatenews') }}";

					if(g_title == title && g_content === content){
						$('#update_close').click();
						alert('No changes.');
					} else {
						$.ajax({
							url: lnkpath,
							type: 'POST',
							data: {
								'id': id,
								'title': title,
								'content': content
							},
							success: function(data){
								if(data == 1){
									alert('success');
									window.location.reload();
								}
								else
									alert('Something went wrong.');
							}
						});
					}
					// alert(id);
				});


				$('#search_news').keyup(function(){
					var value = this.value.toLowerCase().trim();

					$('#news_table tr').each(function(index){
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


				// $('#create_news').click(function(){
				// 	// $('#news_form').show();
				// 	$.fancybox({
				// 		href: '#news_form',
				// 		onComplete: function(){
				// 			tinyMCE.execCommand('mceAddControl', true, 'news_form');
				// 		},
				// 		// onCleanup: function(){
				// 		// 	tinyMCE.EditorManager.execCommand('mceRemoveControl', true, 'news_form');
				// 		// },
				// 		onClosed: function() {
				// 	        tinyMCE.execCommand("mceRemoveControl", false, "news_form");
				// 	    }
				// 	});
				// 	// $.fancybox.open('#news_form');
				// });

			});

		</script>

	@endsection

	@section('content')

		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading">News</div>

				<div class="panel-body">
					<div class="row">
						<!-- <div class="col-md-4">
							<div class="input-group">
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-search"></span>
								</div>
								<input type="text" placeholder="Search" class="form-control" id="search_news">
							</div>
						</div> -->
					</div>
					<br>
					<div class="row">
						<div class="col-md-4">
							<button class="form-control btn btn-md btn-success" id="create_news" data-toggle="modal" data-target="#news_form">
								<span class="glyphicon glyphicon-plus"></span>&nbsp;
								New
							</button>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-hover default-table" id="news_table">
								<thead>
									<tr>
										<th style="width: 200px;">Posted by</th>
										<th style="width: 600px;">Title</th>
										<th>Date posted</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@if($news != null)

										@foreach($news as $n)

											<tr>
												<td>{{ $n->firstname }} {{ $n->midname }} {{ $n->lastname }}</td>
												<?php
													$str = 'alumni/viewnews/'.$n->id;
													$url = URL::to($str);
												?>
												<td><a href="{{ $url }}" class="text-primary"> {{ $n->title }} </a></td>
												<?php
													$d = strtotime($n->created_at);
													$n_date = date('M-d-Y h:i A', $d);
												?>
												<td>{{ $n_date }}</td>
												<td>
													@if(Auth::check())
														
														<a href="#" title="Update this news." class="update_news" rel="{{ $n->id }}" data-toggle="modal" data-target="#update_news_form">
															<span class="glyphicon glyphicon-file"></span>
														</a> &nbsp;&nbsp;
														
														<a href="#" title="Delete this news." class="del_news" rel="{{ $n->id }}">
															<span class="glyphicon glyphicon-trash"></span>
														</a>
													@endif
												</td>
											</tr>

										@endforeach
									@else
										<!-- <tr>
											<td colspan="4">No Data.</td>
										</tr> -->
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

		
		<div class="modal fade" id="news_form" tabindex="-1" role="dialog" aria-labelledby="news_form_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header modal-style">
						
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="create_close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="news_form_label">News &amp; Announcements</h4>
					</div>
					<div class="modal-body">
						
						<input type="text" class="form-control" id="n_title" placeholder="Title">
						<br>
						<textarea id="n_content" rows="20" cols="15"></textarea>
					</div>
					<div class="modal-footer">
						<button class="btn btn-md btn-success" id="btn_create_news">Create</button>
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade" id="update_news_form" tabindex="-1" role="dialog" aria-labelledby="update_form_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

					<div class="modal-header modal-style">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="update_close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="update_form_label">Update</h4>
					</div>

					<div class="modal-body">
						<input type="hidden" id="u_id">
						<input type="text" class="form-control" id="u_title">
						<br>
						<textarea id="u_content" rows="20" cols="15"></textarea>
					</div>

					<div class="modal-footer">
						<button class="btn btn-md btn-success" id="btn_update_news"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Save</button>
					</div>
				</div>
			</div>
		</div>

		<div class="container"></div>

		<script>
			// var pager = new Pager('news_table', 6); 
	  //       pager.init(); 
	  //       pager.showPageNav('pager', 'pageNavPosition'); 
	  //       pager.showPage(1);
		</script>
	@endsection
@stop 