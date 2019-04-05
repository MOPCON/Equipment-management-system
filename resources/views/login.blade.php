<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EMS | Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/app.css">
    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin-heading {
            text-align: center;
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }
        .form-signin .checkbox {
            font-weight: normal;
        }
        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .main-footer {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container">
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <form class="form-signin" method="post" action="/login">
        {{ csrf_field() }}
        <h1 class="form-signin-heading"><i class="fa fa-database fa-2x"></i></h1>
        <h2 class="form-signin-heading">E M S
            <br><small><strong>E</strong>quipment <strong>M</strong>anagement <strong>S</strong>ystem</small></h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="true" name="remember">記住
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
    </form>
        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <a href="https://github.com/puckwang/Equipment-management-system"><i class="fa fa-github" aria-hidden="true"></i>
                    Equipment Management System</a><br>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2016-{{ date("Y") }} <a href="https://github.com/puckwang">PuckWang</a> & <a href="https://github.com/yuuuna">Yuuna</a>.</strong> All rights reserved.
            <a href="https://github.com/puckwang/Equipment-management-system/blob/master/LICENSE">LICENSE</a>
        </footer>
</div> <!-- /container -->

</body>
</html>
