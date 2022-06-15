@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Settings</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
	<div class="container row">
		<div class="col-md-2"></div>
		<div class="col-md-2">
			<div class="input-group mb-3">
				<P>Name</P>
			</div>
			<div class="input-group mb-3">
				<P>Phone number</P>
			</div>
			<div class="input-group mb-5">
				<P>Email</P>
			</div>
			<div class="input-group mb-3">
				<P>Update Password</P>
			</div>
			<div class="input-group mb-3">
				<P>Password</P>
			</div>
			<div class="input-group mb-3">
				<P>Confirm Password</P>
			</div>
		</div>
		<form class="col-md-6" action="{{route('settings.update', Auth::user())}}" method="POST">
			@csrf
			@method('put')
			<div class="input-group mb-3">
				<input type="text" name="name" id="name" class="form-control" value="{{Auth::user()->name}}">
				<div class="input-group-append input-group-text">
                    <span class="fa fa-user"></span>
                </div>
			</div>
			<div class="input-group mb-3">
                <div class="input-group-prepend input-group-text">
                    +966
                </div>
				@php
					$phone = Auth::user()->phonenumber;
					$phone = str_replace("+966", "", $phone);
				@endphp
                <input id="phonenumber" type="phone" class="form-control phonenumber @error('phonenumber') is-invalid @enderror" name="phonenumber" id="phonenumber"
				    placeholder="Phone Number" required autocomplete="phonenumber"
					value="{{$phone}}">
                <div class="input-group-append input-group-text">
                    <span class="fa fa-phone"></span>
                </div>
            </div>
			<div class="input-group mb-5">
				<input type="email" name="email" id="email" class="form-control" value="{{Auth::user()->email}}">
				<div class="input-group-append input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
			</div>
			<div class="input-group mb-3">
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="update_password" name="update_password">
					<label class="custom-control-label" for="update_password"></label>
				</div>
			</div>
			<div class="input-group mb-3">
				<input type="password" name="password" id="password" class="form-control " disabled>
				<div class="input-group-append input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
			</div>
			<div class="input-group mb-3">
				<input type="password" name="c_password" id="c_password" class="form-control" disabled>
				<div class="input-group-append input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
			</div>
			<button type="submit" class="btn btn-success"> Save </button>
		</form>
</div><!-- /.container-fluid -->
</div>

<!-- /.content -->
@endsection
@section('addJavascript')
<script>
	$("#update_password").on('change', e => {
		$( "#password" ).val('');
		$( "#c_password" ).val('');
		$( "#password" ).prop("disabled", !e.target.checked);
		$( "#c_password" ).prop("disabled", !e.target.checked);
	})
</script>
@endsection