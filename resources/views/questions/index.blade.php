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
		<div class="col-md-3 form-group" style="max-height: 80vh; overflow-y:scroll">
			<table class="table table-bordered table-hover facilities">
				<tbody>
					<tr tag="0">
						<td class="{{getParams('category') == 0 ? 'active' : ''}}" onclick="onChangeFacility(0)">
							<span>Show All</span>
						</td>
					</tr>
					@foreach ($categories as $index => $item)
					<tr tag="{{$item->id}}">
						<td class="{{getParams('category') == $item->id ? 'active' : ''}}" onclick="onChangeFacility({{$item->id}})">
							<form action="{{ route('questions.destroy', $item) }}" method="post">
								<span>{{$item->title}}</span>
								<span class="btn btn-danger btn-sm" onclick="deleteItem(this)">Delete</span>
								@csrf
								<input type="hidden" value="category" name="type">
								@method('delete')
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-9">
			<table class="table table-bordered table-hover dataTable dtr-inline">
				<thead>
					<tr>
						<th style="width:30px">No</th>
						<th>Question</th>
						<th style="width: 140px">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($questions as $index => $question)
					<tr>
						<td>{{$index + 1}}</td>
						<td>{{$question->question}}</td>
						<td>
							<form action="{{ route('questions.destroy', $question) }}" method="post">
								@csrf
								@method('delete')
								<input type="button" class="btn btn-primary" onclick="editItem({{$question}})" value="Edit">
								<button rel="tooltip" type="button" class="btn  btn-danger" data-original-title="Delete comment" title="Delete comment"
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