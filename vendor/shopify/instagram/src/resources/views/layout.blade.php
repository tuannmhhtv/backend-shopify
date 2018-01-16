<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type='text/javascript' src='{{ asset('/vendor/shopify/instagram/js/instafeed.js') }}'></script>
        <script type='text/javascript' src='{{ asset('/vendor/shopify/instagram/js/shopify-app.js') }}'></script>
        <script src="{{ asset('/vendor/shopify/instagram/js/modernizr-2.8.3.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('/vendor/shopify/instagram/css/style.css') }}" />
    </head>
    <body>
        @yield( 'body' )
    </body>
</html>
