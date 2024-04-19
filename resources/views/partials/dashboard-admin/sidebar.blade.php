<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center border-bottom border-3" href="index.html">
        <div class="sidebar-brand-text mx-3 fs-4 ">MS-ONE</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $data['active'] === 'dashboard' ? 'active' : "" }}">
    <a class="nav-link" href="/admin/">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a
    >
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Operational</div>


    <li class="nav-item {{ $data['active'] === 'pengguna' ? 'active' : "" }}">
    <a class="nav-link" href="/admin/pengguna">
        <i class="fa-solid fa-user"></i>
        <span>Pengguna</span></a>
    </li>
    <li class="nav-item {{ $data['active'] === 'admins' ? 'active' : "" }}">
    <a class="nav-link" href="/admin/admins">
        <i class="fa-solid fa-user-pen"></i>
        <span>admin</span></a>
    </li>

    <li class="nav-item {{ $data['active'] === 'students' ? 'active' : "" }}">
    <a class="nav-link" href="/admin/students">
        <i class="fa-solid fa-user-graduate"></i>
        <span>Siswa</span></a>
    </li>
    
    <li class="nav-item  {{ $data['active'] === 'activities' ? 'active' : "" }}">
    <a class="nav-link" href="/admin/activities">
        <i class="fa-solid fa-calendar-days"></i>
        <span>Kegiatan</span></a>
    </li>


    <li class="nav-item  {{ $data['active'] === 'classRooms' ? 'active' : "" }}">
    <a class="nav-link" href="/admin/classRoom">
        <i class="fa-solid fa-school"></i>
        <span>Kelas</span></a>
    </li>

    

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Pembayaran</div>

    <li class="nav-item  {{ $data['active'] === 'AllPayments' ? 'active' : "" }}">
        <a class="nav-link" href="/admin/payment">
            <i class="fas fa-money-bill-alt fa-2x text-green"></i>
            <span>Payment</span></a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
          
</ul>
