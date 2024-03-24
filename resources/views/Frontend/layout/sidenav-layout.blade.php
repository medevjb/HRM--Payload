<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title></title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}" />
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/datatables-select.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}"
        rel="stylesheet" />

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatables-select.min.js') }}"></script>
    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js') }}"></script>
</head>

<body>

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <nav class="navbar fixed-top px-0 shadow-sm bg-white">
        <div class="container-fluid">

            <a class="navbar-brand d-flex justify-content-center">
                <span class="icon-nav m-0 h5" onclick="MenuBarClickHandler()">
                    <img class="nav-logo-sm mx-2" src="{{ asset('images/menu.svg') }}" alt="logo" />
                </span>
                {{-- <img class="nav-logo  mx-2" src="{{ asset('images/logo.png') }}" alt="logo" /> --}}
                <span class="h3 text-primary primaryLogo">H R M</span>
            </a>

            <div class="float-right h-auto d-flex">
                <div class="user-dropdown">
                    <img class="icon-nav-img profilePic" src="{{ asset('images/user.webp') }}" alt="" />
                    <div class="user-dropdown-content ">
                        <div class="mt-4 text-center">
                            <img class="icon-nav-img profilePic" src="{{ asset('images/user.webp') }}"
                                alt="" />
                            <h6 id="userName">User Name</h6>
                            <hr class="user-dropdown-divider  p-0" />
                        </div>
                        <a href="{{ url('/profileingo') }}" class="side-bar-item">
                            <span class="side-bar-item-caption">Profile</span>
                        </a>
                        <a href="{{ url('/logout') }}" class="side-bar-item">
                            <span class="side-bar-item-caption">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <div id="sideNavRef" class="side-nav-open">

        <a href="{{ url('/dashboard') }}" class="side-bar-item">
            <div class="row ">
                <div class="col-md-2">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="col-md-10 ">
                    <span class="side-bar-item-caption">Dashboard</span>
                </div>
            </div>
        </a>

        <a href="{{ url('/employee') }}" class="side-bar-item d-none" id="employee-menu-item">
            <div class="row ">
                <div class="col-md-2">
                    <i class="bi bi-people"></i>
                </div>
                <div class="col-md-10">
                    <span class="side-bar-item-caption">Employee</span>
                </div>
            </div>
        </a>

        <a href="{{ url('/attendence') }}" class="side-bar-item">
            <div class="row ">
                <div class="col-md-2">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="col-md-10">
                    <span class="side-bar-item-caption">My Attendence</span>
                </div>
            </div>
        </a>
        <a href="{{ url('/all-attendence') }}" class="side-bar-item">
            <div class="row ">
                <div class="col-md-2">
                    <i class="bi bi-person-bounding-box"></i>
                </div>
                <div class="col-md-10">
                    <span class="side-bar-item-caption">All Attendence</span>
                </div>
            </div>
        </a>

        <a href="{{ url('/leave') }}" class="side-bar-item">
            <div class="row ">
                <div class="col-md-2">
                    <i class="bi bi-arrow-up-right-circle"></i>
                </div>
                <div class="col-md-10">
                    <span class="side-bar-item-caption">Leave</span>
                </div>
            </div>
        </a>


    </div>


    <div id="contentRef" class="content">
        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script>
        function MenuBarClickHandler() {
            let sideNav = document.getElementById('sideNavRef');
            let content = document.getElementById('contentRef');
            if (sideNav.classList.contains("side-nav-open")) {
                sideNav.classList.add("side-nav-close");
                sideNav.classList.remove("side-nav-open");
                content.classList.add("content-expand");
                content.classList.remove("content");
            } else {
                sideNav.classList.remove("side-nav-close");
                sideNav.classList.add("side-nav-open");
                content.classList.remove("content-expand");
                content.classList.add("content");
            }
        }


        getProfileforUpdate()
        async function getProfileforUpdate() {

            showLoader();
            let res = await axios.post('/user-profile-full');
            hideLoader()

            console.log(res.data)

            if (res.data['role'] === 'admin') {
                $('#userHeadding').html("Admin Dashboard");
                $('#employee-menu-item').removeClass("d-none");
                // alert("admin");
            } else if (res.data['role'] === 'manager') {
                $('#userHeadding').html("Manager Dashboard");
                $('#employee-menu-item').removeClass("d-none");
                // alert("manager");
            }else{
                $('#userHeadding').html("User Dashboard");
                // $('#employee-menu-item').addClass("d-none");
                // alert("user");
            }

            if (res.status === 200 && res.data['status'] === 'success') {
                let data = res.data['data'];
                // console.log(data);

                if (data['user_detail']['profile']) {
                    $('.profilePic').attr("src", data['user_detail']['profile']);
                } else {
                    $('.profilePic').attr("src", 'images/user.webp');
                }
                document.getElementById('userName').innerHTML = data['firstName'] + " " + data['lastName'];


            } else if (res.data['status'] === 'failed') {
                errorToast("Something Went Wrong");
            }




        }
    </script>

</body>

</html>
