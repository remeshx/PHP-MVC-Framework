<html>
	<head>
		@include('web/layouts/head-tag')
		@yield('head-tag')
	</head>
	<body>
		@include('web/layouts/header')

		@yield('content')

		@include('web/layouts/footer')

		@include('web/layouts/scripts')
		@yield('script')
	</body>
</html>