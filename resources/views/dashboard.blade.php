@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">{{__('commons.dashboard')}}</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item active">{{__('commons.dashboard')}}</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box">
					<span class="info-box-icon bg-info elevation-1"><i class="fas users"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">{{__('commons.total-admin')}}</span>
						<span class="info-box-number">
							{{$admin}}
							{{-- <small>%</small> --}}
						</span>
					</div>

				</div>

			</div>

			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">{{__('commons.total-clients')}}</span>
						<span class="info-box-number">{{$clients}}</span>
					</div>

				</div>

			</div>


			<div class="clearfix hidden-md-up"></div>
			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">{{__('commons.total-worker')}}</span>
						<span class="info-box-number">{{$worker}}</span>
					</div>

				</div>

			</div>

			<div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-building"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">{{__('commons.facilities')}}</span>
						<span class="info-box-number">{{$facilities}}</span>
					</div>

				</div>

			</div>

		</div>
	</div>
</div>
<!-- /.content -->
@endsection