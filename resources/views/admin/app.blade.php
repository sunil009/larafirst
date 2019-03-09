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
   <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">

   <link rel="stylesheet" href="{{asset('public/css/admin.css') }}">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />

   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

</head>
<body>
   <div id="app">

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
         @yield('body_title')
         <div class="col-md-12">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  @yield('breadcrumbs')
               </ol>
            </nav>
         </div>
         @include('admin.partials.navbar')

         <div class="row">            
            <div class="col-sm-12">
               @if ($errors->any())
               <div class="alert alert-danger">
                <ul style="margin-bottom: 0">
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
            @endif

            @if(session()->has('message'))
            <div class="alert alert-success">
               {{ session('message') }}
            </div>
            @endif
         </div>
      </div>
         @yield('content')
      </main>
   </div>
   
   {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
   <script type="text/javascript" src="{{asset('public/js/app.js') }}"></script>
   <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
   
   <script>      
      $(document).ready(function() { 
         // show the alert 
         setTimeout(function() {
            $(".alert-success").fadeTo(1000, 0).slideUp(1000, function(){
               // $(this).remove(); 
            });
         }, 3000);
      });
   </script>

   <script type="text/javascript">
      function confirmDelete(id) {
         var choice = confirm("Are you sure, You want to Delete this record?");
         if(choice) {
            // alert("delete-" + id);
            $("#delete-" + id).submit();
         }
      }
   </script>
   @yield('scripts')
</body>
</html>
