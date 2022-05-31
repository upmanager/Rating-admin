<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="{{asset('css/fontawesome.min.css')}}">
	{{-- Datatable --}}
	<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
	{{-- Toast --}}
	<link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('css/pages.css')}}">
	@yield('addCss')
</head>

<body class="hold-transition sidebar-mini sidebar-open">
	<div class="wrapper">

		@include('layouts.navbar')
		@include('layouts.sidebar')

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			@yield('content')
		</div>
		<!-- /.content-wrapper -->

		@include('layouts.footer')
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="{{asset('js/jquery.min.js')}}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
	{{-- Datatable --}}
	<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
	<!-- AdminLTE App -->
	<script src="{{asset('js/adminlte.min.js')}}"></script>
	<!-- Sweetalert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	{{-- Toast --}}
	<script src="{{asset('js/toastr.min.js')}}"></script>

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
	@yield('addJavascript')
</body>

</html>