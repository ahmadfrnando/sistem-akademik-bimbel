<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/images/logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/compiled/css/app.css">
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="/assets/static/css/custom.css">
    <link rel="stylesheet" href="/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/assets/compiled/css/table-datatable-jquery.css">
    <!-- <link rel="stylesheet" href="/assets/extensions/choices.js/public/assets/styles/choices.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @stack('styles')
    @routes
</head>

<body>
    <script src="/assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo d-block">
                            <span class="fs-4">STAR ONE EC</span>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Home</li>
                        <li
                            class="sidebar-item {{ request()->is('siswa/dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('siswa.dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li
                            class="sidebar-item {{ request()->is('siswa/nilai*') ? 'active' : '' }}">
                            <a href="{{ route('siswa.nilai.index') }}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-text-fill"></i>
                                <span>Nilai</span>
                            </a>
                        </li>
                        <li class="sidebar-title">Materi</li>
                        <li
                            class="sidebar-item {{ request()->is('siswa/pembelajaran*') ? 'active' : '' }}">
                            <a href="{{ route('siswa.pembelajaran.index') }}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-text-fill"></i>
                                <span>Materi Pembelajaran</span>
                            </a>
                        </li>
                        <li
                            class="sidebar-item {{ request()->is('siswa/tugas*') ? 'active' : '' }}">
                            <a href="{{ route('siswa.tugas.index') }}" class='sidebar-link'>
                                <i class="bi bi-pencil-fill"></i>
                                <span>Tugas</span>
                            </a>
                        </li>
                        <li class="sidebar-title">Akun</li>
                        <li
                            class="sidebar-item {{ request()->is('siswa/user/edit-username') ? 'active' : '' }}">
                            <a href="{{ route('siswa.user.edit-username') }}" class='sidebar-link'>
                                <i class="bi bi-gear-fill"></i>
                                <span>Ganti Username</span>
                            </a>
                        </li>
                        <li
                            class="sidebar-item {{ request()->is('siswa/user/edit-password') ? 'active' : '' }}">
                            <a href="{{ route('siswa.user.edit-password') }}" class='sidebar-link'>
                                <i class="bi bi-gear-fill"></i>
                                <span>Ganti Password</span>
                            </a>
                        </li>
                        <li
                            class="sidebar-item">
                            <button type="button" id="logout" class="sidebar-link">
                                <i class="bi bi-arrow-bar-left"></i>
                                <span>Keluar</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>@yield('title')</h3>
                            <p class="text-subtitle text-muted">@yield('description')</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                {{ Breadcrumbs::render() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
                @yield('content')
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="/assets/static/js/components/dark.js"></script>
    <script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/compiled/js/app.js"></script>
    <!-- Need: Apexcharts -->
    <!-- <script src="/assets/extensions/apexcharts/apexcharts.min.js"></script> -->
    <script src="/assets/static/js/pages/dashboard.js"></script>
    <script src="/assets/static/js/custom.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="/assets/extensions/jquery/jquery.min.js"></script>
    <script src="/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/static/js/pages/datatables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- <script src="/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="/assets/static/js/pages/form-element-select.js"></script> -->
    <script>
        $(document).ready(function() {
            $('#logout').click(function() {
                logoutUser();
            });
        });
    </script>
    @stack('scripts')
</body>

</html>