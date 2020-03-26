<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title> United Group - @yield('title')</title>
	<link rel="icon" type="image/png" href="{{ asset('storage/settings/icon.png') }}">
    @include('dashboard.partials.styles')
</head>
<body>
	@include('dashboard.partials.nav')
	@include('dashboard.partials.bar')
	<div class="contenedor extended">
		<div class="contenido">
		@yield('content')
		</div>
	@include('dashboard.partials.footer')
	</div>


	@include('dashboard.partials.scripts')
</body>
</html>
