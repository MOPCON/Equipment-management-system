<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EMS | Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="css/app.css">
    <style>
        .form-signin {
            vertical-align: middle;
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

        #loginLeft {
            width: 70%;
            float: left;
            height: 100vh;
            background: url("{{ asset('/img/background.jpg') }}") no-repeat fixed center top;
            opacity: 0.6;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #loginRight {
            width: 30%;
            height: 100vh;
            float: right;
            background: #eee;
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>

<div id="loginLeft">
    <img style="width: 80%;" src="{{asset('/img/logo.png')}}">
</div>
<div id="loginRight">
    <div style="margin: auto;">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form class="form-signin" method="post" action="/login">
            {{ csrf_field() }}
            <h1 class="form-signin-heading"><i class="fa fa-database fa-2x"></i></h1>
            <h2 class="form-signin-heading">E M S
                <br><small>Login</small></h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address"
                   value="{{ old('email') }}" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="true" name="remember"> 記住
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
        </form>
        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <a href="https://github.com/puckwang/Equipment-management-system">
                <i class="fa fa-github" aria-hidden="true"></i>
                Equipment Management System
            </a>
            <br>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2016-{{ date("Y") }} <a href="https://github.com/puckwang">PuckWang</a> & <a
                        href="https://github.com/yuuuna">Yuuna</a>.</strong>
            <br>
            <span>All rights reserved.</span>
            <a href="https://github.com/puckwang/Equipment-management-system/blob/master/LICENSE">LICENSE</a><br>
            Image by <a href="https://pixabay.com/users/tingyaoh-1563812/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1698285">tingyaoh</a> from <a href="https://pixabay.com/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1698285">Pixabay</a>
        </footer>
    </div>
</div>

</body>
</html>
