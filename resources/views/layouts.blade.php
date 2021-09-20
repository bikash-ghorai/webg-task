<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>WebGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/loader.css') }}">
    <style type="text/css">
    	.error-field{
    		border: 1px solid #ff1333;
    	}
    	.error{
    		color: red;
    		display: none;
    	}
        div#productTable_filter {
            float: right;
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="loader-bg">
        <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">WebGen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Dashboard</a>
                    </li>
                </ul>
                <div class="d-flex" id="loginSection">
                    <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ url('register') }}">Register</a>
                    <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ url('login') }}">Login</a>
                </div>
                <div class="d-flex" id="userSection" style="opacity: 0;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        User Name
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="right: 25px; left: 85%;">
                        <li><a class="dropdown-item" href="#!" id="logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <br>
    @yield('content')
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('custom_script')
</body>

</html>
