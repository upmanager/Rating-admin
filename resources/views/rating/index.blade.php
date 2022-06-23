@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Manage Rating</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right" style="padding-right: 30px">
					{{-- @if (getParams('facility') != 0)
					<a href="{{route('ratings.create', 'facilityid='.getParams('facility'))}}" class="btn btn-success">Export PDF</a>
					@endif --}}
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
		<div class="col-md-3 form-group" style="margin-top:50px; max-height: 80vh; overflow-y:scroll">
			<table class="table table-bordered table-hover facilities">
				<tbody>
					<tr tag="0">
						<td class="{{getParams('facility') == 0 ? 'active' : ''}}" onclick="onChangeFacility(0)">
							<span>Show All</span>
							<span>></span>
						</td>
					</tr>
					@foreach ($facilities as $index => $item)
					@if (count($item->rating) > 0)
					<tr tag="{{$item->id}}">
						<td class="{{getParams('facility') == $item->id ? 'active' : ''}}" onclick="onChangeFacility({{$item->id}})">
							<span>{{$item->name}}</span>
							<span>></span>
						</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-9">
			<table class="table table-bordered table-hover dataTable dtr-inline">
				<thead>
					<tr>
						<th style="width:30px">No</th>
						<th>Worker</th>
						<th>Rating</th>
						<th>Create date</th>
						@if (Auth::user()->role == 0)
						<th style="width: 60px">Status</th>
						<th style="width: 140px">Action</th>
						<th style="width: 100px">Export</th>
						<th style="width: 60px">Delete</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($ratings as $index => $rating)
					@php
					$rating->Worker;
					if($rating->Facility) {
					$rating->Facility->Manager;
					}
					if($rating->Details) {
					foreach ($rating->Details as $dt) {
					$dt->Question;
					}
					}
					@endphp
					<tr>
						<td onclick="renderModal({{$rating}})" style="cursor: pointer;">{{$index + 1}}</td>
						<td onclick="renderModal({{$rating}})" style="cursor: pointer;">{{$rating->Worker ? $rating->Worker->name : ''}}</td>
						<td onclick="renderModal({{$rating}})" style="cursor: pointer;">{{$rating->rating}}</td>
						<td onclick="renderModal({{$rating}})" style="cursor: pointer;">{{date('H:i d M Y', strtotime($rating->created_at))}}</td>
						@if (Auth::user()->role == 0)
						<td style="cursor: pointer;">
							@if($rating->status == 0)
							Pending
							@elseif($rating->status == 1)
							Approved
							@else
							Blocked
							@endif
						</td>
						<td>
							@if($rating->status == 0)
							<input type="button" value="Approve" class="btn btn-sm btn-success approve-rating" onclick="ratingAction({{$rating->id}}, true)">
							<input type="button" value="Block" class="btn btn-sm btn-danger block-rating" onclick="ratingAction({{$rating->id}}, false)">
							@elseif($rating->status == 1)
							<input type="button" value="Block" class="btn btn-sm btn-danger block-rating" onclick="ratingAction({{$rating->id}}, false)">
							@else
							<input type="button" value="Approve" class="btn btn-sm btn-success approve-rating" onclick="ratingAction({{$rating->id}}, true)">
							@endif
						</td>
						<td>
							<a href="{{route('ratings.create', 'type=0&id='.$rating->id)}}" class="btn btn-sm btn-success">PDF</a>
							<a href="{{route('ratings.create', 'type=1&id='.$rating->id)}}" class="btn btn-sm btn-success">EXCEL</a>
						</td>
						<td>
							<form action="{{ route('ratings.destroy', $rating) }}" method="post">
								@csrf
								@method('delete')
								{{-- <input type="button" class="btn btn-primary" onclick="editItem({{$rating}})" value="Edit"> --}}
								<button rel="tooltip" type="button" class="btn btn-sm btn-danger" data-original-title="Delete comment" title="Delete comment"
									onclick="deleteItem(this)">Delete</button>
							</form>
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div><!-- /.container-fluid -->
</div>



<div class="modal fade" id="detail_modal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Rating Detail</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card-body" id="detail-container">

				</div>
				<div class="modal-footer ">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Close" />
				</div>
			</div>
		</div>
	</div>
</div>



<!-- /.content -->
@endsection
@section('addJavascript')
<script>
	const UPDATEPATH = "{!! route('ratings.update', 0) !!}";
	const ASSETSURL = "{{asset('storage/')}}";
</script>
<script src="{{asset('js/pages/ratings.js')}}"></script>
@endsection