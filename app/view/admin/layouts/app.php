<html>
	<head>
		@include('admin/layouts/head-tag')
		@yield('head-tag')
	</head>
	<body>
		@include('admin/layouts/header')

		@yield('content')

		@include('admin/layouts/footer')

		@include('admin/layouts/scripts')
		@yield('script')
	</body>
</html>