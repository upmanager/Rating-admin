@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Manage Notifications</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					@if (Auth::user()->role == 0)
					<button type="button" class="btn btn-success add-user" data-toggle="modal" data-target="#notify-form"> Send notification</button>
					@endif
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<table class="table table-bordered table-hover dataTable dtr-inline">
			<thead>
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Content</th>
					<th>Type</th>
					<th>Sent date</th>
					<th>Attachmenets</th>
					@if (Auth::user()->role == 0)
					<th>Action</th>
					@endif
				</tr>
			</thead>
			<tbody>
				@foreach ($notifications as $index => $notification)
				<tr>
					<td>{{$index + 1}}</td>
					<td>{{$notification->user->name}}</td>
					<td>{{$notification->content}}</td>
					<td>{{$notification->type == 0 ? "Notification" : "SMS"}}</td>
					<td>{{date('H:i d M Y', strtotime($notification->created_at))}}</td>
					<td>
						@if ($notification->attach)
						@foreach (explode(',', $notification->attach) as $item)
						<a href="{{$item}}" download="{{$item}}">
							<i class="nav-icon fa fa-download" style="font-size: 30px"></i>
						</a>
						@endforeach
						@endif
					</td>
					@if (Auth::user()->role == 0)
					<td>
						<form action="{{ route('notifications.destroy', $notification) }}" method="post">
							@csrf
							@method('delete')
							<button rel="tooltip" type="button" class="btn btn-danger" data-original-title="Delete comment" title="Delete comment"
								onclick="deleteItem(this)">Delete</button>
						</form>
					</td>
					@endif
				</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- /.container-fluid -->
</div>

<div class="modal fade" id="notify-form" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{route('notifications.store')}}" method="post" id="notification-form" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="id" id="userid">
				<div class="modal-body">
					<div class="card-body">
						<div class="form-group">
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" id="fcm_notify" value="fcm" name="rad_notify" checked="">
								<label for="fcm_notify" class="custom-control-label">Send Push Notification</label>
							</div>
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" id="email_notify" value="email" name="rad_notify">
								<label for="email_notify" class="custom-control-label">Send Email</label>
							</div>
							<div class="custom-control custom-radio">
								<input class="custom-control-input" type="radio" id="sms_notify" value="sms" name="rad_notify">
								<label for="sms_notify" class="custom-control-label">Send SMS</label>
							</div>
						</div>
						<div class="form-group hide sms_container">
							<label for="sms_users">Select Users sms</label>
							<select class="form-control" id="sms_users" name="sms_users[]" multiple="true" style="height: 140px">
								@foreach ($sms_users as $user)
								<option value="{{$user->id}}">{{$user->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group hide email_container">
							<label for="email_users">Select Users fcm</label>
							<select class="form-control" id="email_users" name="email_users[]" multiple="true" style="height: 140px">
								@foreach ($email_users as $user)
								<option value="{{$user->id}}">{{$user->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group fcm_container">
							<label for="fcm_users">Select Users fcm</label>
							<select class="form-control" id="fcm_users" name="fcm_users[]" multiple="true" style="height: 140px">
								@foreach ($fcm_users as $user)
								<option value="{{$user->id}}">{{$user->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="content">Content</label>
							<textarea name="content" class="form-control" id="content" rows="10" required></textarea>
						</div>
						<div class="form-group hide email_container">
							<label for="attach_file">Attach file</label>
							<div class="input-group">
								<input type="file" name="file[]" multiple class="form-control" style="padding: 4px" id="attach_file">
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Close" />
						<input type="submit" class="btn btn-primary" value="Send" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /.content -->
@endsection
@section('addJavascript')
<script src="{{asset('js/pages/notifications.js')}}"></script>
@endsection