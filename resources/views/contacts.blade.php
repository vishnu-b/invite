@extends('app')

@section('content')

	<div class="container">
	    <div class="row">
			<div class="col-md-12">
	            <div class="panel with-nav-tabs panel-success">
	                <div class="panel-heading">
	                        <ul class="nav nav-tabs">
	                            <li class="col-md-4 text-center active"><a href="#tab1success" data-toggle="tab">Invite Friends</a></li>
	                            <li class="col-md-4 text-center"><a href="#tab2success" data-toggle="tab">Pending Invites</a></li>
	                            <li class="col-md-4 text-center"><a href="#tab3success" data-toggle="tab">Members</a></li>
	                        </ul>
	                </div>
	                <div class="panel-body">
	                    <div class="tab-content">
	                        <div class="tab-pane fade in active" id="tab1success">
	                        	@if (isset($contacts['not_invited']))
	                        		<table class="table table-striped">
										<tbody>
											@foreach ($contacts['not_invited'] as $contact)
												<tr>
													<td class="col-md-4">
														{{ $contact['title'] }}
													</td>
													<td class="col-md-4">
														{{ $contact['email'] }}
													</td>
													<td class="col-md-4 text-center">
														<button class='btn btn-primary invite'>
															invite
														</button>
													</td>
												</tr>
											@endforeach
										</tbody>
	                        		</table>
	                        	@else
	                        		You have invited all of your contacts.
	                        	@endif
	                        </div>
	                        <div class="tab-pane fade" id="tab2success">
	                        	@if (isset($contacts['invited']))
	                        		<table class="table table-striped">
										<tbody>
											@foreach ($contacts['invited'] as $contact)
												<tr>
													<td class="col-md-4">
														{{ $contact['title'] }}
													</td>
													<td class="col-md-4">
														{{ $contact['email'] }}
													</td>
													<td class="col-md-4 text-center">
														<button class='btn btn-primary invite'>
															Invite Again
														</button>
													</td>
												</tr>
											@endforeach
										</tbody>
	                        		</table>
	                        	@else
	                        		No pending invites from you
	                        	@endif
	                        </div>
	                        <div class="tab-pane fade" id="tab3success">
	                        	@if (isset($contacts['member']))
	                        		<table class="table table-striped">
										<tbody>
											@foreach ($contacts['invited'] as $contact)
												<tr>
													<td class="col-md-4">
														{{ $contact['title'] }}
													</td>
													<td class="col-md-4">
														{{ $contact['email'] }}
													</td>
												</tr>
											@endforeach
										</tbody>
	                        		</table>
	                        	@else
	                        		No one in your contacts is a member
	                        	@endif
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
		</div>
	</div>

@stop

@section('footer')
	<script>
		$(document).ready(function () {
			$('.invite').click(function () {
				var element = $(this).parent().parent();
				var email = $.trim(element.children()[1].innerHTML);

				var url = 'http://springverse.com/invite/invite/' + email;
				console.log(url);
				$.get(url, function(data) {
				  element.hide();
				});
			});
		});
	</script>
@stop
