<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ url('css/error-styling.css') }}">
</head>
<body>
<div class="container">
    <div class="content">
    @yield('content')
    </div>
</div>
</body>
</html>