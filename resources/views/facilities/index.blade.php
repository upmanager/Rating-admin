@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Manage Facilities</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					@if (Auth::user()->role == 0)
					<button type="button" class="btn btn-success add-facility"> Add Facility</button>
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
					<th style="width: 50px">No</th>
					<th>Name</th>
					<th>Manager</th>
					<th>Email</th>
					<th>Phone Number</th>
					<th>Qty</th>
					<th>Record number</th>
					<th>License number</th>
					<th style="max-width: 50px">Content</th>
					<th style="width: 140px">Create date</th>
					<th style="width: 160px">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($facilities as $index => $facility)
				<tr>
					<td>{{$index + 1}}</td>
					<td>{{$facility->name}}</td>
					<td>{{$facility->Manager->name}}</td>
					<td>{{$facility->Manager->email}}</td>
					<td>{{$facility->Manager->phonenumber}}</td>
					<td>{{$facility->qty}}</td>
					<td>{{$facility->record_number}}</td>
					<td>{{$facility->license_number}}</td>
					<td>{{$facility->content}}</td>

					<td>{{date('H:i d M Y', strtotime($facility->created_at))}}</td>
					<td>
						@if (Auth::user()->role == 0)
						<form action="{{ route('facilities.destroy', $facility) }}" method="post">
							@csrf
							@method('delete')
							<input type="button" class="btn btn-sm btn-primary" onclick="editItem({{$facility}})" value="Edit">
							<a href="/ratings?facility={{$facility->id}}" class="btn btn-sm btn-success">Ratings</a>
							<button rel="tooltip" type="button" class="btn btn-sm btn-danger" data-original-title="Delete comment" title="Delete comment"
								onclick="deleteItem(this)">Delete</button>
						</form>
						@else
						<a href="/ratings?facility={{$facility->id}}" class="btn btn-sm btn-success">Ratings</a>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- /.container-fluid -->
</div>

<div class="modal fade" id="update-form" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{route('facilities.store')}}" method="post">
				@csrf
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="card-body">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
						</div>
						<div class="form-group">
							<label for="useremail">Manager</label>
							<select class="form-control" id="managerid" name="managerid" required>
								@foreach ($users as $user)
								<option value="{{$user->id}}">{{$user->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="name">Quantity of branches</label>
							<input type="number" min="0" class="form-control" id="qty" name="qty" placeholder="Quantity of branches" required>
						</div>
						<div class="form-group">
							<label for="name">Commercial Record number</label>
							<input type="text" class="form-control" id="record_number" name="record_number" placeholder="Commercial Record number" required>
						</div>
						<div class="form-group">
							<label for="name">Facility license number</label>
							<input type="text" class="form-control" id="license_number" name="license_number" placeholder="Facility license number" required>
						</div>
						<div class="form-group">
							<label for="name">Facilities page content</label>
							<textarea name="content" id="content" class="form-control" rows="6"></textarea>
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
<script src="{{asset('js/pages/facilities.js')}}"></script>
@endsection