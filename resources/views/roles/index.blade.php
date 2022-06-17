@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Manage Role</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<button type="button" class="btn btn-success add-user"> Add User</button>
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
					<th>Email</th>
					<th>Phone</th>
					<th>Role</th>
					<th>Create date</th>
					<th style="width: 60px">Status</th>
					<th>Approve/Block</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $index => $user)
				<tr>
					<td>{{$index + 1}}</td>
					<td>{{$user->name}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->phonenumber}}</td>
					<td>{{$user->role == 1 ? "Client" : "Worker"}}</td>
					<td>{{$user->status == 1 ? "Client" : "Worker"}}</td>
					<td>
						@if($user->status == 0)
						Pending
						@elseif($user->status == 1)
						Approved
						@else
						Blocked
						@endif
					</td>
					<td>
						@if($user->status == 0)
						<input type="button" value="Approve" class="btn btn-sm btn-success" onclick="userAction({{$user->id}}, true)">
						<input type="button" value="Block" class="btn btn-sm btn-danger" tag="{{$user->id}}" onclick="userAction({{$user->id}}, false)">
						@elseif($user->status == 1)
						<input type="button" value="Block" class="btn btn-sm btn-danger" onclick="userAction({{$user->id}}, false)">
						@else
						<input type="button" value="Approve" class="btn btn-sm btn-success" onclick="userAction({{$user->id}}, true)">
						@endif
					</td>
					<td>
						<form action="{{ route('roles.destroy', $user) }}" method="post">
							@csrf
							@method('delete')
							<input type="button" class="btn btn-primary btn-sm" onclick="editItem({{$user}})" value="Edit">
							<button rel="tooltip" type="button" class="btn btn-danger btn-sm" data-original-title="Delete comment" title="Delete comment"
								onclick="deleteItem(this)">Delete</button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- /.container-fluid -->
</div>

<div class="modal fade" id="update-form" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{route('roles.store')}}" method="post">
				@csrf
				<input type="hidden" name="id" id="userid">
				<div class="modal-body">
					<div class="card-body row">
						<div class="form-group col-md-6">
							<label for="username">User Name</label>
							<input type="text" class="form-control" id="username" name="name" placeholder="Enter user name" required>
						</div>
						<div class="form-group col-md-6">
							<label for="useremail">Email address</label>
							<input type="email" class="form-control" id="useremail" name="email" placeholder="Enter email" required>
						</div>
						<div class="form-group mb-5  col-md-6">
							<label for="useremail">Role</label>
							<select class="form-control" id="userrole" name="role" required>
								<option value="0">Admin</option>
								<option value="1">Client</option>
								<option value="2">Worker</option>
							</select>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="update-password custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="update_password" name="update_password">
									<label class="custom-control-label" for="update_password">Update Password</label>
								</label>
								<label for="user_password" class="new-password">New Password</label>
								<input type="password" class="form-control" id="password" name="user_password" placeholder="Enter password" required>
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Close" />
						<input type="submit" class="btn btn-primary" value="Save" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /.content -->
@endsection
@section('addJavascript')
<script>
	const UPDATEPATH = "{!! route('roles.update', 0) !!}";
</script>
<script src="{{asset('js/pages/roles.js')}}"></script>
@endsection