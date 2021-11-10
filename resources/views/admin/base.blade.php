<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | Kosanku</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bona+Nova:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/myStyle.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
    <!-- custom css -->

    <script src="{{ asset('js/swal.js') }}"></script>
    @yield('css')
</head>

<body>
    <style>
        .setActive {
            background-color: #ffffff26;
        }

    </style>
    <!-- Side-Nav -->
    <div class="side-navbar active-nav d-flex justify-content-between  flex-wrap flex-column" id="sidebar">
        <ul class="nav flex-column text-white w-100 h-100">
            <a href="#" class="nav-link h5 text-white my-2">
                Hi, Joko (Admin)
            </a>

            <a href="/user">
                <li href="#" class="nav-link t-white">
                    <i class='bx bx-user'></i>
                    <span class="mx-2">Master User</span>
                </li>
            </a>

            <a href="/kos" >
                <li href="#" class="nav-link t-white">
                    <i class='bx bx-building-house' ></i>
                    <span class="mx-2">Master Kos</span>
                </li>
            </a>




            <a href="/logout" class="mt-auto">
                <li href="#" class="nav-link t-white">
                    <i class="bx bx-link-external"></i>
                    <span class="mx-2">Logout</span>
                </li>

            </a>
        </ul>


    </div>

    <!-- Main Wrapper -->
    <div class="p-1 my-container active-cont ">
        <!-- Top Nav -->
        <nav class="navbar top-navbar navbar-light b-white px-5 " style="z-index: 10">
            <a class="btn border-0" id="menu-btn"><i class="bx bx-menu"></i></a>
            <a class="d-none">@yield('title')</a>
        </nav>
        <!--End Top Nav -->
        <div class="content-wrapper bg-light p-2" style="height: 100vh;">
            @yield('content')
        </div>
    </div>


    <script src="{{ asset('bootstrap/js/jquery.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/myStyle.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/dialog.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    @yield('script')
</body>

</html>
