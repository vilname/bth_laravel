<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    <body>
        <main role="main">
            @include('layouts.header')
            @yield('content')
        </main>
        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>
