<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    @php
        $token = '';
        try {
            $token =
                !empty(auth()->user()) && !empty(auth()->guard('api'))
                    ? auth()
                        ->guard('api')
                        ->login(auth()->user())
                    : null;
        } catch (\Throwable $th) {
            //throw $th;
        }
    @endphp
    {{-- barer token --}}
    <meta content="{{ $token }}" name="csrf-token">
    <!--favicon-->
    <link href="{{ asset('admin') }}/assets/images/favicon-32x32.png" rel="icon" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('admin') }}/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="{{ asset('admin') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ asset('admin') }}/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{ asset('admin') }}/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('admin') }}/assets/css/pace.min.css" rel="stylesheet" />
    <script src="{{ asset('admin') }}/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin') }}/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('admin') }}/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('admin') }}/assets/css/app.css" rel="stylesheet">
    <link href="{{ asset('admin') }}/assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link href="{{ asset('admin') }}/assets/css/dark-theme.css" rel="stylesheet" />
    <link href="{{ asset('admin') }}/assets/css/semi-dark.css" rel="stylesheet" />
    <link href="{{ asset('admin') }}/assets/css/header-colors.css" rel="stylesheet" />
    {{-- UPLOAD --}}
    <link href="{{ asset('admin') }}/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet" />


    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    {{-- chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- chart --}}
    @yield('style')
    @stack('style')
    <title>POINT OF SALES - FRUIT STORE</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img alt="logo icon" class="logo-icon"
                        src="https://icon-library.com/images/point-of-sales-icon/point-of-sales-icon-9.jpg">
                </div>
                <div>
                    {{-- <h4 class="logo-text">P O S</h4> --}}
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            @include('Template.navbar')

            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    {{-- <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box">
                            <input class="form-control search-control" placeholder="Type to search..." type="text">
                            <span class="position-absolute top-50 search-show translate-middle-y"><i
                                    class='bx bx-search'></i></span>
                            <span class="position-absolute top-50 search-close translate-middle-y"><i
                                    class='bx bx-x'></i></span>
                        </div>
                    </div> --}}

                </nav>
                <strong class="mr-10">{{ auth()->user()->username }}</strong>
            </div>
        </header>
        <!--end header -->
        <!--start page wrapper -->
        @yield('content')

        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a class="back-to-top" href="javaScript:;"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <?php
            // Dapatkan tahun sekarang menggunakan PHP
            $year = date('Y');
            ?>

            <p class="mb-0">Copyright © <?php echo $year; ?>. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->
    <!--start switcher-->

    <!--end switcher-->
    @include('sweetalert::alert')

    @yield('script')

    <!-- Bootstrap JS -->
    <script src="{{ asset('admin') }}/assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ asset('admin') }}/assets/js/jquery.min.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/chartjs/js/Chart.min.js"></script>
    <script src="{{ asset('admin') }}/assets/plugins/chartjs/js/Chart.extension.js"></script>
    <script src="{{ asset('admin') }}/assets/js/index.js"></script>
    <!--app JS-->
    <script src="{{ asset('admin') }}/assets/js/app.js"></script>

    {{-- UPLOAD --}}
    <script src="{{ asset('admin') }}/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#image-uploadify').imageuploadify();
        })
    </script>
    @stack('script')


</body>

</html>
