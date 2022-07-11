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

$workerids = getParams('workers');
if($workerids != '') $workerids = explode(',', $workerids);
else $workerids = [];
@endphp
<!-- Main content -->
<div class="content">
	<div class="container-fluid row">
		<div class="col-md-5">
			<select class="facilities-picker forn-control" multiple>
				@foreach ($facilities as $item)
				<option value="{{$item->id}}" {{ in_array($item->id, $facilityids) ? 'selected' : '' }}>{{$item->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-5">
			<select class="workers-picker forn-control" multiple>
				@foreach ($workers as $item)
				<option value="{{$item->id}}" {{ in_array($item->id, $workerids) ? 'selected' : '' }}>{{$item->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-2">
			<input type="button" value="{{__('commons.filter')}}" class="btn btn-primary btn-filter">
			<br><br>
		</div>
		<div class="col-md-12" style="margin-top: 30px; overflow-x:scroll">
			<div id="action-buttons" style="text-align: right; margin-bottom:20px;">
				<input type="button" value="{{__('commons.PDF')}}" class="btn btn-primary btn-export-pdf">
			</div>
			<table id="report_table" class="table table-bordered table-hover dtr-inline" style="width:100%;   font-family: DejaVu Sans, sans-serif;">
				<thead>
					<tr>
						<td>Facility Name</td>
						@foreach ($workers as $item)
						@if (in_array($item->id, $workerids))
						<td>{{$item->name}}</td>
						@endif
						@endforeach
						<td>Total</td>
					</tr>
				</thead>
				<tbody>
					@php
					@endphp
					@foreach ($facilities as $facility)
					@if (in_array($facility->id, $facilityids))
					@php
					$tmpQuery = collect($reports)->where('facilityid', $facility->id);
					$cur_sum = 0;
					@endphp
					<tr>
						<td>{{$facility->name}}</td>
						@foreach ($workers as $worker)
						@if (in_array($worker->id, $workerids))
						@php
						$qItem = $tmpQuery->where('workerid', $worker->id)->first();
						$cur = $qItem['visit'] ?? 0;
						$cur_sum += $cur;
						@endphp
						<td>{{$cur}}</td>
						@endif
						@endforeach
						<td>{{$cur_sum}}</td>
					</tr>
					@endif
					@endforeach
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