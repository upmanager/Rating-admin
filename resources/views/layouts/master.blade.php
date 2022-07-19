<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', App::getLocale()) }}">

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
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
	{{-- Toast --}}
	<link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('plugins/flag-icons/css/flag-icons.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/pages.css')}}">
	@yield('addCss')
</head>

<body class="hold-transition sidebar-mini sidebar-open">
	{{-- dir='{{App::getLocale() == 'en' ? 'ltr' : 'rtl' }}' --}}
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
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

	<!-- AdminLTE App -->
	<script src="{{asset('js/adminlte.min.js')}}"></script>
	<!-- Sweetalert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	{{-- Toast --}}
	<script src="{{asset('js/toastr.min.js')}}"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
	<script>
		$(function () {
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var phones = [{ "mask": "## #######"}];
		$('.phonenumber').inputmask({ 
				mask: phones,
				greedy: false, 
				definitions: { '#': { validator: "[0-9]", cardinality: 1}}
		});
	})
	const _JSLANGS = @json(__('javascripts'));
	
	function updateUrlParams(obj) {
		let curParams = new URLSearchParams(window.location.search);

		Object.entries(obj).map(([key, value]) => {
			if (!value || value == null || value == '') curParams.delete(key);
			else curParams.set(key, value);
		})

		const { protocol, host, pathname } = window.location;
		const url = `${protocol}//${host}${pathname}?${curParams.toString()}`;
		return url;
	}

	</script>
	@yield('addJavascript')
</body>

</html>