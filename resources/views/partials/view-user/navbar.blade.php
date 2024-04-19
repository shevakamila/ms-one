<nav class="navbar navbar-expand-md navbar-light bg-transparent py-4 border-bottom-dongker ">
  <div class="container">
      <!-- Logo -->
      <img src="{{ asset('img/asset/onedek-logo.jpg') }}" alt="onedek.jpg" class="d-none d-md-block" style="max-height: 40px; margin-right: 10px;">
      <!-- Brand dan toggle button untuk mobile -->
      <a class="text-decoration-none fw-semibold fs-5 text-dongker" href="#" style="margin-right: 10px;">MS-ONE</a>
      <!-- Toggle button untuk mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu Navigasi -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link active fw-bold text-primary" aria-current="page" href="#" style="margin-right: 20px;">Beranda</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link fw-bold text-dongker" href="#" style="margin-right: 20px;">Kegiatan</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link fw-bold text-dongker" href="#" style="margin-right: 20px;">Tentang Kami</a>
              </li>
              @guest
              <li class="nav-item">
                <a class="fw-bold btn border border-2 border-primary text-primary px-4 " href="/page-registrasi" style="margin-right: 20px;">Registrasi</a>
              </li>
              <li class="nav-item">
                  <a class="fw-bold btn btn-primary px-4 border border-2 border-primary " href="/page-login" style="margin-right: 20px;">Login</a>
              </li>
              @endguest
              @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if ($data['user']->image)
                        <img src="{{ asset('img/user/' . $data['user']->image) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" alt="Default Profile">
                    @else
                        <i class="fas fa-user"></i>
                    @endif

                </a>                
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <div class="dropdown-header">{{ $data['user']->name }}</div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user fa-sm fa-fw me-2"></i>
                        Profile
                    </a>
                    <form action="/logout" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer;">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
                
                </li>
              @endauth
              
              
          </ul>
      </div>
  </div>
</nav>
