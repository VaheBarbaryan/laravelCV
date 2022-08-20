<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
          content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
          content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{--@yield('title')--}}ITResources </title>
    <link rel="shortcut icon" href="{{ asset('/img/itr_favicon.png') }}" type="image/png">
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite"/>
    <!-- Custom CSS -->
    <link href="{{asset('/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/create_cv.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.6/css/selectize.bootstrap4.min.css" integrity="sha512-VL5zQAJyFw5RL9wN3a5nF508dBqgOAYOZeww5RuEq8A8JQLiWy20iG2lLyiTuF6bv7gz48UGMcxuMlUycoHfJw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
<!-- CSS only -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('plugins/bower_components/chartist/dist/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    @stack('style')
{{--    <link rel="stylesheet" href="{{ asset('/css/intlTelInput.css') }}">--}}
    <!-- Custom CSS -->
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
{{--    <![endif]-->--}}
    <style>
        .page-wrapper {
            background: none !important;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            border: none;
            outline: none;
            background: none;
            transition: all .1s linear;
        }

        body {
            font-family: 'Nunito', sans-serif;
            font-size: 18px;
        }

        a {
            text-decoration: none !important;
        }
        button {
            border: none
        }
        button:focus,
        button:active {
            border: none;
        }

        .styled-table tbody tr:hover {
            background-color: #d8d8d8;
        }

        /*.form-control {*/
        /*    background-color: #f8f9fa;*/
        /*    padding: 15px 10px;*/
        /*    margin-bottom: 1.3rem;*/
        /*}*/

        /*.form-control:focus {*/

        /*    color: #000000;*/
        /*    background-color: #ffffff;*/
        /*    border: 3px solid #3490dc;*/
        /*    outline: 0;*/
        /*    box-shadow: none;*/

        /*}*/

        .ripples {
            overflow: hidden;
            position: relative;
        }

        .waves {
            position: absolute;
            display: block;
            border-radius: 100%;
            background-color: rgba(255, 255, 255, 0.3);
            -webkit-transform: scale(0);
            -moz-transform: scale(0);
            -o-transform: scale(0);
            transform: scale(0);
        }

        .ripple {
            -webkit-animation: ripple 0.65s linear;
            -moz-animation: ripple 0.65s linear;
            -ms-animation: ripple 0.65s linear;
            -o-animation: ripple 0.65s linear;
            animation: ripple 0.65s linear;
        }

        @-webkit-keyframes ripple {
            100% {
                opacity: 0;
                -webkit-transform: scale(2.5);
            }
        }

        @-moz-keyframes ripple {
            100% {
                opacity: 0;
                -moz-transform: scale(2.5);
            }
        }

        @-o-keyframes ripple {
            100% {
                opacity: 0;
                -o-transform: scale(2.5);
            }
        }

        @keyframes ripple {
            100% {
                opacity: 0;
                transform: scale(2.5);
            }
        }


        .hide-menu {
            font-size: 17px;
        }
    </style>
</head>
<body>
<div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
     data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <header class="topbar" data-navbarbg="skin5" style="    position: fixed; top: 0;left: 0;width: 100%;" >
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin6">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="{{ route('dashboard') }}" >
                    <!-- Logo icon -->
                    <b class="logo-icon" >
                        <!-- Dark Logo icon -->
{{--                        <img src="{{asset('plugins/images/logo-icon.png')}}" alt="homepage"/>--}}
                        <img src="{{asset('img/itr.png')}}" alt="homepage" height="50px" style="filter: invert(1);"/>
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
{{--                    <span class="logo-text">--}}
{{--                            <!-- dark Logo text -->--}}
{{--                            <img src="{{asset('plugins/images/logo-text.png')}}" alt="homepage" style="width: 100%;height: 100%;object-fit: cover;"/>--}}
{{--                    </span>--}}
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                   href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <ul class="navbar-nav d-none d-md-block d-lg-none">
                    <li class="nav-item">
                        <a class="nav-toggler nav-link waves-effect waves-light text-white"
                           href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    </li>
                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav ms-auto d-flex align-items-center">

                    <!-- ============================================================== -->
                    <!-- Search -->
                    <!-- ============================================================== -->
{{--                    <li class=" in">--}}
{{--                        <form role="search" class="app-search d-none d-md-block me-3">--}}
{{--                            <input type="text" placeholder="Search..." class="form-control mt-0">--}}
{{--                            <a href="" class="active">--}}
{{--                                <i class="fa fa-search"></i>--}}
{{--                            </a>--}}
{{--                        </form>--}}
{{--                    </li>--}}
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li>
                        <a class="profile-pic" href="{{ route('dashboard') }}"><span class="text-white font-medium">{{((\Illuminate\Support\Facades\Auth::user()) ? \Illuminate\Support\Facades\Auth::user()->name : '') }}</span></a>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar" data-sidebarbg="skin6" style="position: fixed;left: 0;top: 0;">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar" style="background-color: #fff !important;">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <!-- User Profile-->
                    <li class="sidebar-item pt-2" style="max-width: 100%;">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}"
                           aria-expanded="false">
                            <i class="fa-regular fa-calendar"></i>
                            <span class="hide-menu">Վահանակ({{ $employers_count }})</span>
                        </a>
                    </li>
                    <li class="sidebar-item pt-2" style="max-width: 100%;">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('create_cv') }}"
                           aria-expanded="false">
                            <i class="fa-solid fa-address-card"></i>
                            <span class="hide-menu">Ստեղծել նոր ռեզյումե</span>
                        </a>
                    </li>
                    <li class="sidebar-item pt-2" style="max-width: 100%;">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="{{ route('education_dash') }}"
                           aria-expanded="false">
                            <i class="fa-solid fa-building-columns"></i>
                            <span class="hide-menu">Կրթություն</span>
                        </a>
                    </li>
                    <li class="sidebar-item pt-2" style="max-width: 100%;">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link"
                           href="{{ route('create_education') }}"
                           aria-expanded="false">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span class="hide-menu ">Ավելացնել համալսարան</span>
                        </a>
                    </li>
{{--                    <li class="sidebar-item pt-2" style="max-width: 100%;">--}}
{{--                        <a class="sidebar-link waves-effect waves-dark sidebar-link"--}}
{{--                           href="{{ route('roles') }}"--}}
{{--                           aria-expanded="false">--}}
{{--                            <i class="fa-solid fa-image-portrait"></i>--}}
{{--                            <span class="hide-menu">Դերեր</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="sidebar-item pt-2" style="max-width: 100%;">--}}
{{--                        <a class="sidebar-link waves-effect waves-dark sidebar-link"--}}
{{--                           href="{{ route('terminal') }}"--}}
{{--                           aria-expanded="false">--}}
{{--                            <i class="fa-solid fa-terminal"></i>--}}
{{--                            <span class="hide-menu">Տերմինալ</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="sidebar-item pt-2" style="max-width: 100%;">
                        <div id="logout" class="sidebar-link waves-effect waves-dark sidebar-link"
                                aria-expanded="false" style="width: 100%;">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hide-menu">Դուրս Գալ</span>
                        </div>
                    </li>
                </ul>

            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <div class="page-wrapper">
        <div class="container-fluid" style="position: relative; padding-bottom: 80px; padding-top: 80px;">
            @yield('content')
        </div>
    </div>
</div>
<!-- JavaScript Bundle with Popper -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/app-style-switcher.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('js/custom.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8-beta.17/jquery.inputmask.min.js" integrity="sha512-zdfH1XdRONkxXKLQxCI2Ak3c9wNymTiPh5cU4OsUavFDATDbUzLR+SYWWz0RkhDmBDT0gNSUe4xrQXx8D89JIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>

    $(document).ready(function () {
        $('.date').datepicker({
            dateFormat: 'dd-mm-yy',
            firstDay: 1,
            closeText: 'Փակել',
            prevText: 'Նախորդ',
            nextText: 'Հաջորդ',
            currentText: 'Այսօր',
            monthNames: ['Հունվար','Փետրվար','Մարտ','Ապրիլ','Մայիս','Հունիս', 'Հուլիս','Օգոստոս','Սեպտեմբեր','Հոկտեմբեր','Նոյեմբեր','Դեկտեմբեր'],
            monthNamesShort: ['Հունվ','Փետր','Մարտ','Ապր','Մայիս','Հունիս', 'Հուլ','Օգս','Սեպ','Հոկ','Նոյ','Դեկ'],
            dayNames: ['կիրակի','եկուշաբթի','երեքշաբթի','չորեքշաբթի','հինգշաբթի','ուրբաթ','շաբաթ'],
            dayNamesShort: ['կիր','երկ','երք','չրք','հնգ','ուրբ','շբթ'],
            dayNamesMin: ['կիր','երկ','երք','չրք','հնգ','ուրբ','շբթ'],
            weekHeader: 'ՇԲՏ',
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',
            changeMonth: true,
            changeYear: true,
            minDate: new Date(1950, 1 - 1, 1),
            maxDate: "+6M"
        });
        $('.date').inputmask({"mask": "99/99/9999"});
        $('#logout').click(function (e) {
            e.preventDefault();
            swal({
                title: "Դուք վստահ ե՞ք որ ուզում եք դուրս գալ",
                icon: "warning",
                buttons: ["Չեղարկել", "Դուրս գալ"],
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "GET",
                            url: '/logout1',
                            success: function () {
                                location.reload();
                            },
                        });
                    }
                });
        });
        $(document).on('change', '.education_name', function (e) {
            var $id = e.target.value;
            $.ajax({
                url: "/addEducationForEmp/" + $id,
                type: 'GET',
                success: function (data) {
                    $(e.target).parent().next('td').find('.faculty_name:first').empty();
                    Object.keys(data).forEach((row) => {
                        $(e.target).parent().next('td').find('.faculty_name:first').append(`<option value="${data[row].id}"> ${data[row].faculty_name} </option>`);
                    });
                }
            });
        });

    });
</script>
@stack('script')
</body>
</html>