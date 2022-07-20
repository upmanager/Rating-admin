@extends('layouts.master')
@section('addCss')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
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
$start_date = getParams('start_date');
$end_date = getParams('end_date');

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
		<div class="col-md-8 mb-3">
			<select class="workers-picker forn-control" multiple>
				@foreach ($workers as $item)
				<option value="{{$item->id}}" {{ in_array($item->id, $workerids) ? 'selected' : '' }}>{{$item->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-4 mb-3">
			<input type="button" value="Select" class="btn btn-primary btn-select">
		</div>
		<div class="col-md-3">
			<input type="text" class="daterange form-control" value="{{($start_date && $end_date) ? $start_date." - ".$end_date : ''}}" />
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
						<td>No</td>
						<td>Worker</td>
						<td>Facility</td>
						@foreach ($categories as $item)
						@if (in_array($item->id, $categoryids))
						<td>{{$item->title}}</td>
						@endif
						@endforeach
						<td>Visit</td>
					</tr>
				</thead>
				<tbody>
					@php
					$index = 1;
					@endphp
					@foreach ($workers as $worker)
						@if (in_array($worker->id, $workerids))
							@php
								$befWorker = null;
								$tmpWorkerQuery = collect($reports)->where('workerid', $worker->id);
								$facs = [];
								$worker_total = 0;
								$worker_sum = 0;
								$isExists = false;
							@endphp

							@foreach ($facilities as $facility)
								@php
									$tmpFacilityQuery = $tmpWorkerQuery->where('facilityid', $facility->id);
									$workerQuery = collect($facility_users)
									->whereIn('userid', [$worker->id, -1])
									->where('id', $facility->id)
									->count();
								@endphp
								@if (in_array($facility->id, $facilityids) && $workerQuery > 0 && (getParams('empty') == '0' || $tmpFacilityQuery->count() > 0))
									@php
										$total = 0;
										$cur_sum = 0;
										$cat_index = 0;
										$isExists = true;
									@endphp
									<tr>
										<td>{{$index++}}</td>
										@if ($befWorker != $worker->name)
										@php
										$befWorker = $worker->name;
										@endphp
										<td>{{$worker->name}}</td>
										@else
										<td></td>
										@endif
										<td>{{$facility->name}}</td>
										@foreach ($categories as $category)
										@if (in_array($category->id, $categoryids))
										@php
										$cur = $tmpFacilityQuery->where('categoryid', $category->id)->count();
										$cur_sum += $cur;
										if(count($facs) <= $cat_index) $facs[] = $cur;
										else $facs[$cat_index] += $cur;
										$cat_index ++;
										@endphp
										<td>{{$cur}}</td>
										@endif
										@endforeach
										<td>{{$cur_sum}}</td>
										@php
											$worker_sum += $cur_sum;
										@endphp
									</tr>
								@endif
							@endforeach
							@if ($isExists)
								<tr style="background-color: aqua">
									<td style="color: transparent">{{$index}}</td>
									<td style="text-align:center" >{{$worker->name}}</td>
									<td></td>
									@foreach ($facs as $fac)
										<td>{{$fac}}</td>
									@endforeach
									<td>{{$worker_sum}}</td>
								</tr>
							@endif
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
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script>
	const EXPORTPATH = "{!! route('worker-reports.store') !!}";
</script>
<script src="{{asset('js/pages/worker-reports.js')}}"></script>
@endsection