@extends('layouts.main.main')


@section('body')
    
<body>

  
  @yield('container')




  {{-- LINK JQUERY ONLINE --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  {{-- LINK BOOTSRAP ONLINE --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  {{-- LINK TEMPLATE DASHBOARD --}}
 <script src="{{ asset('dashboard-admin/vendor/jquery/jquery.min.js') }}"></script>
 <script src="{{ asset('dashboard-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('dashboard-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
 <script src="{{ asset('dashboard-admin/js/sb-admin-2.min.js') }}"></script>

  @stack('js')

  

</body>
@endsection