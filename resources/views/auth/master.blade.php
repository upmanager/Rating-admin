<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', App::getLocale()) }}">
    {{-- dir='{{App::getLocale() == ' en' ? 'ltr' : 'rtl' }}' --}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('css/fontawesome.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    @yield('addCss')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            {{config('app.name')}}
        </div>

        @yield('content')
    </div>
    <!-- /.login-box -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>

    <script>
        $(function () {
		var phones = [{ "mask": "## #######"}];
		$('.phonenumber').inputmask({ 
				mask: phones, 
				greedy: false, 
				definitions: { '#': { validator: "[0-9]", cardinality: 1}}
		});
	})
    
    function updateUrlParams(obj) {
        let curParams = new URLSearchParams(window.location.search);

        Object.entries(obj).map(([key, value]) => {
            if (value == null || value == '') curParams.delete(key);
            else curParams.set(key, value);
        })

        const { protocol, host, pathname } = window.location;
        const url = `${protocol}//${host}${pathname}?${curParams.toString()}`;
        return url;
    }
    </script>
</body>

</html>