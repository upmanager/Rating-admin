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
				<h1 class="m-0 text-dark">{{__('commons.Analysis')}}</h1>
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
@endphp
<!-- Main content -->
<div class="content">
	<div class="container-fluid row">
		<div class="col-md-5">
			<input type="text" class="daterange form-control" value="{{($start_date && $end_date) ? $start_date." - ".$end_date : ''}}" />
		</div>
		<div class="col-md-5">
			<select class="facilities-picker forn-control" multiple>
				@foreach ($facilities as $item)
				<option value="{{$item->id}}" {{ in_array($item->id, $facilityids) ? 'selected' : '' }}>{{$item->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-2">
			<input type="button" value="{{__('commons.filter')}}" class="btn btn-primary btn-filter">
		</div>
		<br><br><br>
		<div class="col-md-8 col-lg-8 row">
			<div class="col-md-12">
				<canvas id="mixedChart"> </canvas>
			</div>
			<div class="col-md-12">
				<canvas id="chartbydate"> </canvas>
			</div>
		</div>
		<div class="com-md-4 col-lg-4">
			<table class="table table-bordered table-hover dataTable dtr-inline" style="width: 100%">
				<thead>
					<tr>
						<th>{{__('commons.No')}}</th>
						<th>{{__('commons.Facility')}}</th>
						<th>{{__('commons.Rating')}}</th>
						<th>{{__('commons.total-rate')}}</th>
					</tr>
				</thead>
				<tbody>
					@php
					$i = 0;
					@endphp
					@foreach ($rates as $rate)
					@php
					$i ++;
					@endphp
					<tr>
						<td>{{$i}}</td>
						<td>{{$rate['name']}}</td>
						<td>{{$rate['rate']}}</td>
						<td>{{$rate['total_rate']}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div><!-- /.container-fluid -->
</div>




@endsection
@section('addJavascript')
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	const rates = Object.values(@json($rates));
	const rate_by_facility = Object.values(@json($rate_by_facility));
	const rate_by_date = Object.values(@json($rate_by_date));
</script>
<script src="{{asset('js/pages/analysis.js')}}"></script>
@endsection