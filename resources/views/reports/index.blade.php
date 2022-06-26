@extends('layouts.master')

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

<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<table class="table table-bordered table-hover dataTable dtr-inline">
			<thead>
				<tr>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div><!-- /.container-fluid -->
</div>


<!-- /.content -->
@endsection
@section('addJavascript')
<script>
	const UPDATEPATH = "{!! route('ratings.update', 0) !!}";
	const ASSETSURL = "{{asset('storage/')}}";

	const _LANLABELS = {
		Worker:`{{__('commons.worker')}}`,
		Facility:`{{__('commons.Facility')}}`,
		Name:`{{__('commons.Name')}}`,
		Email:`{{__('commons.Email')}}`,
		Phone:`{{__('commons.Phone')}}`,
		manager_name:`{{__('commons.manager-name')}}`,
		record_number:`{{__('commons.record-number')}}`,
		description:`{{__('commons.Description')}}`,
		license_number:`{{__('commons.license-number')}}`,
		rating_detail: `{{__('commons.rating-detail')}}`,
		Location:`{{__('commons.Location')}}`,
		no_match:`{{__('commons.no-match')}}`,
		match:`{{__('commons.match')}}`,
	}
</script>
<script src="{{asset('js/pages/ratings.js')}}"></script>
@endsection