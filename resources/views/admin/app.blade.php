<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Laravel') }}</title>

   <!-- Fonts -->
   <link rel="dns-prefetch" href="//fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

   <!-- Styles -->
   <link href="public/css/app.css" rel="stylesheet">

   @yield('admin_css')

</head>
<body>
   <div id="app">

      <main class="py-4">
         @include('admin.partials.navbar')
         @yield('content')
      </main>
   </div>

   <script type="text/javascript" src="public/js/app.js"></script>

</body>
</html>
