@extends('layouts.master')
@section('addCss')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">{{__('commons.reports')}}</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right" style="padding-right: 30px">
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
$facilityids = getParams('facilities');
if($facilityids != '') $facilityids = explode(',', $facilityids);
else $facilityids = [];

$categoryids = getParams('categories');
if($categoryids != '') $categoryids = explode(',', $categoryids);
else $categoryids = [];

$workerids = getParams('workers');
if($workerids != '') $workerids = explode(',', $workerids);
else $workerids = [];
@endphp
<!-- Main content -->
<div class="content">
	<div class="container-fluid row">
		<div class="col-md-3">
			<select class="workers-picker forn-control" multiple>
				@foreach ($workers as $item)
				<option value="{{$item->id}}" {{ in_array($item->id, $workerids) ? 'selected' : '' }}>{{$item->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-3">
			<select class="facilities-picker forn-control" multiple>
				@foreach ($facilities as $item)
				<option value="{{$item->id}}" {{ in_array($item->id, $facilityids) ? 'selected' : '' }}>{{$item->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-3">
			<select class="categories-picker forn-control" multiple>
				@foreach ($categories as $item)
				<option value="{{$item->id}}" {{ in_array($item->id, $categoryids) ? 'selected' : '' }}>{{$item->title}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-1">
			<input type="button" value="{{__('commons.filter')}}" class="btn btn-primary btn-filter">
		</div>
		<div class="col-md-2">
			<a href="#" class="fiter-empty" data-isempty="{{getParams('empty')}}">{{getParams('empty') != '0' ? 'Show empty' : 'Hide empty'}}</a>
		</div>
		<div class="col-md-12" style="margin-top: 30px; overflow-x:scroll">
			<div id="action-buttons" style="text-align: right; margin-bottom:20px;">
				<input type="button" value="{{__('commons.PDF')}}" class="btn btn-primary btn-export-pdf">
			</div>
			<table id="report_table" class="table table-bordered table-hover dtr-inline" style="width:100%;   font-family: DejaVu Sans, sans-serif;">
				<thead>
					<tr>
						<td>Worker</td>
						<td>Facility</td>
						@foreach ($categories as $item)
						@if (in_array($item->id, $categoryids))
						<td>{{$item->title}}</td>
						@endif
						@endforeach
						<td>Total</td>
						<td>Percent</td>
					</tr>
				</thead>
				<tbody>
					@foreach ($workers as $worker)
					@if (in_array($worker->id, $workerids))
					@php
					$tmpWorkerQuery = collect($reports)->where('workerid', $worker->id);
					@endphp
					
					@foreach ($facilities as $facility)
					@php
					$tmpFacilityQuery = $tmpWorkerQuery->where('facilityid', $facility->id);
					$total = 0;
					$cur_sum = 0;
					@endphp
					@if (in_array($facility->id, $facilityids) && (getParams('empty') == '0' || $tmpFacilityQuery->count() > 0))
					<tr>
						<td >{{$worker->name}}</td>
						<td>{{$facility->name}}</td>
						@foreach ($categories as $category)
						@if (in_array($category->id, $categoryids))
						@php
						$qItem = $tmpFacilityQuery->where('categoryid', $category->id)->first();
						$cur = $qItem['cur_score'] ?? 0;
						$total += $qItem['total_score'] ?? 0;
						$cur_sum += $cur;
						@endphp
						<td>{{$cur}}</td>
						@endif
						@endforeach
						<td>{{$total}}</td>
						<td>{{number_format((float)($cur_sum / ($total < 1 ? 1 : $total) * 100), 2, '.' , '' )}}%</td>
					</tr>
					@endif
					@endforeach


					@endif
					@endforeach
					{{-- @foreach ($facilities as $facility)
					@if (in_array($facility->id, $facilityids))
					@php
					$tmpQuery = collect($reports)->where('facilityid', $facility->id);
					$total = 0;
					$cur_sum = 0;
					@endphp
					<tr>
						<td>{{$facility->name}}</td>
						@foreach ($categories as $category)
						@if (in_array($category->id, $categoryids))
						@php
						$qItem = $tmpQuery->where('categoryid', $category->id)->first();
						$cur = $qItem['cur_score'] ?? 0;
						$total += $qItem['total_score'] ?? 0;
						$cur_sum += $cur;
						@endphp
						<td>{{$cur}}</td>
						@endif
						@endforeach
						<td>{{$total}}</td>
						<td>{{number_format((float)($cur_sum / ($total < 1 ? 1 : $total) * 100), 2, '.' , '' )}}%</td>
					</tr>
					@endif
					@endforeach --}}
				</tbody>
			</table>
		</div>
	</div><!-- /.container-fluid -->
</div>


<!-- /.content -->
@endsection
@section('addJavascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
	const EXPORTPATH = "{!! route('worker-reports.store') !!}";
</script>
<script src="{{asset('js/pages/worker-reports.js')}}"></script>
@endsection