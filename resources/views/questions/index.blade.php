@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Manage Questions</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-category" style="margin:10px"> Add Category</button>
					<button type="button" class="btn btn-success add-question" style="margin:10px"> Add Question</button>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@php
function getParams($key) {
try {
return $_GET[$key];
} catch (\Throwable $th) {
}
return '';
}
@endphp
<!-- Main content -->
<div class="content">
	<div class="container-fluid row">
		<div class="col-md-6 form-group" style="max-height: 80vh; overflow-y:scroll">
			<table class="table table-bordered table-hover facilities">
				<thead>
					<tr>
						<th>Category</th>
						<th>Users</th>
						<th style="width:140px">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr tag="0" class="{{getParams('category') == 0 ? 'active' : ''}}" onclick="onChangeFacility(0)">
						<td colspan="3" style="text-align: center">Show All</td>
					</tr>
					@foreach ($categories as $index => $item)
					@php
					$all_checked = false;
					if(!$item->UserDetails || count($item->UserDetails) <= 0) { $all_checked=false; } else if(count($item->UserDetails) == 1 &&
						$item->UserDetails[0]->userid == -1)
						{
						$all_checked = true;
						}
						$count=count($item->UserDetails);
						@endphp

						<tr tag="{{$item->id}}" class="{{getParams('category') == $item->id ? 'active' : ''}}">
							<td onclick="onChangeFacility({{$item->id}})">{{$item->title}}</td>
							<td onclick="onChangeFacility({{$item->id}})">
								@if ($all_checked)
								All users
								@else
								{{$count == 0 ? "No users" : $count}}
								@endif
							</td>
							<td>
								<form action="{{ route('questions.destroy', $item) }}" method="post">
									<input type="button" class="btn btn-success btn-sm" value="Users" data-toggle="modal" data-target="#members_form_{{$index}}">
									<input type="button" class="btn btn-danger btn-sm" onclick="deleteItem(this)" value="Delete">
									@csrf
									<input type="hidden" value="category" name="type">
									@method('delete')
								</form>
							</td>
						</tr>
						<div class="modal fade" id="members_form_{{$index}}" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Users</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>
									<form action="{{route('questions.update', $item)}}" method="post" enctype="multipart/form-data">
										@csrf
										@method('put')

										<div class="modal-body">
											<div class="form-group icheck-primary" style="margin-left: 40px">

												<input class="form-check-input checkbox-lg checkbox-users" data-questionid="{{$item->id}}" data-id="0" type="checkbox"
													name="all_users" id="all_users_{{$item->id}}" value="-1" {{$all_checked ? "checked" : "" }}>
												<label for="all_users" style="margin-left: 20px; font-size:24px;">All Users</label>
											</div>
											<div class="card-body row">
												@foreach($users as $userIdx => $user)
												@php
												$checked = false;
												if($all_checked) {
												$checked = true;
												} else if($item->UserDetails) {
												foreach ($item->UserDetails as $dt => $value) {
												if($value->userid == $user->id) {
												$checked = true;
												break;
												}
												}
												}
												@endphp
												<div class="form-group col-md-3 icheck-primary" style="overflow: hidden; padding:10px;">
													<input class="form-check-input checkbox-lg checkbox-users checkbox-users-{{$item->id}}" data-questionid="{{$item->id}}"
														data-id="{{$user->id}}" style="width: 50px" type="checkbox" name="users[]" id="users_{{$index}}{{$userIdx}}"
														value="{{$user->id}}" {{$checked ? "checked" : "" }}>
													<label for="users_{{$index}}{{$userIdx}}" style="margin-left: 20px">
														{{$user->name}}
														<br>
														<span style="font-weight: 100; font-size:12px;">{{$user->email}}</span>
													</label>
												</div>
												@endforeach
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
						@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<table class="table table-bordered table-hover dataTable dtr-inline">
				<thead>
					<tr>
						<th style="width:30px">No</th>
						<th>Question</th>
						<th>Score</th>
						<th style="width: 100px">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($questions as $index => $question)
					<tr>
						<td>{{$index + 1}}</td>
						<td>{{$question->question}}</td>
						<td>{{$question->score}}</td>
						<td>
							<form action="{{ route('questions.destroy', $question) }}" method="post">
								@csrf
								@method('delete')
								<input type="button" class="btn btn-primary btn-sm" onclick="editItem({{$question}})" value="Edit">
								<button rel="tooltip" type="button" class="btn btn-danger btn-sm" data-original-title="Delete comment" title="Delete comment"
									onclick="deleteItem(this)">Delete</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div><!-- /.container-fluid -->
</div>

<div class="modal fade" id="add-category" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{route('questions.store')}}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="card-body">
						<div class="form-group">
							<label for="title">Category</label>
							<input type="text" name="title" id="title" class="form-control">
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

<div class="modal fade" id="update-form" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{route('questions.update', 0)}}" method="post" enctype="multipart/form-data">
				@csrf
				@method('put')
				<input type="hidden" name="id" id="question_id" value="0">
				<div class="modal-body">
					<div class="card-body">
						<div class="form-group">
							<label for="categoryid">Category</label>
							<select class="form-control" id="categoryid" name="categoryid" required>
								@foreach ($categories as $category)
								<option value="{{$category->id}}">{{$category->title}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="categoryid">Score</label>
							<input type="number" name="score" id="score" value="1" class="form-control" min="1" max="5">
						</div>
						<textarea name="question" id="question" class="form-control" rows="10" required></textarea>
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

<script src="{{asset('js/pages/question.js')}}"></script>
@endsection