<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />


    <title>MS-ONE</title>

    {{-- LINK TEMPLATE DASHBOARD --}}
    <link href="{{ asset('dashboard-admin/css/sb-admin-2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard-admin/vendor/fontawesome-free/css/all.min.css ')}}" rel="stylesheet" type="text/css">
     <!-- Custom styles for this page -->
     <link href="{{ asset('dashboard-admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    
    {{-- LINK BOOTSRAP ONLINE --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- LINK FONT  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    {{-- LINK CSS PRIBADI --}}
    <link rel="stylesheet" href="{{ asset('custom-css/custom-partials.css') }}">

    {{-- LINK ICON  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    {{-- STACK UNTUK CUSTOM STYLE DI TAMPILAN MASING2 --}}

    <style>
      *{
        font-family: "Poppins",sans-serif
      }
    </style>

  </head>

  <link rel="stylesheet" href="" />
 
  @stack('style')
  @yield('body')
</html>
