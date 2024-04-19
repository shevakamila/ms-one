@extends('layouts.main.main')


@section('body')
    
<body id="page-top">
  <div id="wrapper">

    {{-- SIDEBAR --}}
    @include('partials.dashboard-admin.sidebar')
    {{-- END SIDEBAR --}}


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">

        {{-- TOP BAR / NAVBAR  --}}
        @include('partials.dashboard-admin.navbar')
        {{-- END TOP BAR /NAVBAR --}}



        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
      

          
          @yield('content-dashboard')

          
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/logout" method="post">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" >Logout</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- LINK JQUERY ONLINE --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  {{-- LINK BOOTSRAP ONLINE --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


  {{-- LINK TEMPLATE DASHBOARD --}}
 <script src="{{ asset('dashboard-admin/vendor/jquery/jquery.min.js') }}"></script>
 <script src="{{ asset('dashboard-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

 <script src="{{ asset('dashboard-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

 <script src="{{ asset('dashboard-admin/js/sb-admin-2.min.js') }}"></script>

 <script src="{{ asset('dashboard-admin/vendor/chart.js/Chart.min.js') }}"></script>

 <script src="{{ asset('dashboard-admin/js/demo/chart-area-demo.js') }}"></script>
 <script src="{{ asset('dashboard-admin/js/demo/chart-pie-demo.js') }}"></script>


 <script src="{{ asset('dashboard-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('dashboard-admin/vendor/datatables/dataTables.bootstrap4.min.j') }}s"></script>
 <script src="{{ asset('dashboard-admin/js/demo/datatables-demo.js') }}"></script>

  @stack('js')

  

</body>
@endsection