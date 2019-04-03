<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EMS</title>
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <link rel="stylesheet" href="css/adminlte-skin-purple-light.min.css">
    <link href="{{ asset('/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.3.911/styles/kendo.common-bootstrap.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.3.911/styles/kendo.bootstrap.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2018.3.911/styles/kendo.bootstrap.mobile.min.css" />
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="skin-purple-light sidebar-mini sidebar-collapse">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>EMS</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>EMS</b></span>
        </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- 將網站放大至全螢幕 -->
                    <li onclick="toogleFullscreen()">
                        <a>
                            <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                        </a>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ Gravatar::get($user->email) }}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ $user->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ $user->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- Optionally, you can add icons to the links -->
                <li>
                    <a><i class="fa fa-user" aria-hidden="true"></i><span>工人管理</span></a>
                    <ul class="treeview-menu">
                        <li><a href="/#/staffs"><i class="fa fa-user" aria-hidden="true"></i><span>工人管理</span></a></li>
                        <li><a href="/#/groups"><i class="fa fa-users" aria-hidden="true"></i><span>組別管理</span></a></li>
                    </ul>
                </li>
                <li>
                    <a><i class="fa fa-hdd-o" aria-hidden="true"></i><span>器材管理</span></a>
                    <ul class="treeview-menu">
                        <li><a href="/#/equipments"><i class="fa fa-hdd-o" aria-hidden="true"></i><span>器材管理</span></a></li>
                        <li><a href="/#/equipments/raise"><i class="fa fa-suitcase" aria-hidden="true"></i><span>募集物資管理</span></a></li>
                        <li><a href="/#/equipments/barcode"><i class="fa fa-barcode" aria-hidden="true"></i><span>條碼管理</span></a></li>
                    </ul>
                </li>
                <li>
                    <a><i class="fa fa-id-card" aria-hidden="true"></i><span>驗票系統</span></a>
                    <ul class="treeview-menu">
                        <li><a href="/#/student-verify"><i class="fa fa-id-card"></i><span>學生驗票</span></a></li>
                    </ul>
                </li>
                <li>
                    <a><i class="fa fa-exchange" aria-hidden="true"></i><span>借還系統</span></a>
                    <ul class="treeview-menu">
                        <li><a href="/#/loan/action"><i class="fa fa-exchange" aria-hidden="true"></i><span>物品借還</span></a></li>
                        <li><a href="/#/loan"><i class="fa fa-clock-o" aria-hidden="true"></i><span>批量管理</span></a></li>
                    </ul>
                </li>
                <li>
                    <a><i class='fa fa-telegram'></i> <span>Telegram Bot</span></a>
                    <ul class="treeview-menu">
                        <li><a href="/#/telegram-message"><i class="fa fa-commenting" aria-hidden="true"></i><span>訊息發送</span></a></li>
                        <li><a href="/#/telegram-channel"><i class="fa fa-users" aria-hidden="true"></i><span>頻道管理</span></a></li>
                    </ul>
                </li>
                <li>
                    <a><i class='glyphicon glyphicon-cog'></i> <span>設定</span></a>
                    <ul class="treeview-menu">
                        <li><a href="/#/user"><i class="fa fa-user-secret" aria-hidden="true"></i><span>使用者管理</span></a></li>
                        <li><a href="/#/tool/print"><i class="fa fa-barcode" aria-hidden="true"></i><span>條碼列印</span></a></li>
                        <li><a href="/#/tool/imexport"><i class="fa fa-exchange fa-rotate-90" aria-hidden="true"></i><span>匯入匯出</span></a></li>
                    </ul>
                </li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div id="app"></div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            <a href="https://github.com/puckwang/Equipment-management-system"><i class="fa fa-github" aria-hidden="true"></i>
                Equipment Management System</a>
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016-{{ date("Y") }} <a href="https://github.com/puckwang">PuckWang</a> & <a href="https://github.com/yuuuna">ChienYun</a>.</strong> All rights reserved.
        <a href="https://github.com/puckwang/Equipment-management-system/blob/master/LICENSE">LICENSE</a>
    </footer>
</div>

<!-- AdminLTE App -->
<script>
    const helper = {
        deleteConfirm: function deleteConfirm(callback) {
            swal({
                title: '確定要刪除?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(callback);
        },
        alert: function alert(message, type = 'success') {
            $.notify({
                // options
                icon: 'glyphicon glyphicon-warning-sign',
                message: message
            }, {
                // settings
                type: type,
                delay: 2500,
            });
        }
    };

    let elem = document.documentElement;

    function toogleFullscreen() {

        const isFullScreen = document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;

        if (isFullScreen) {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        } else {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { /* Firefox */
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE/Edge */
                elem.msRequestFullscreen();
            }
        }
    }
</script>
<script src="{{ mix('/js/manifest.js') }}" charset="utf-8"></script>
<script src="{{ mix('/js/vendor.js') }}" charset="utf-8"></script>
<script src="{{ mix('/js/app.js') }}" charset="utf-8"></script>
<script src="js/adminlte.js" charset="utf-8"></script>
<script src="{{ asset('/js/sweetalert2.min.js') }}" charset="utf-8"></script>
<script src="https://kendo.cdn.telerik.com/2018.3.911/js/kendo.all.min.js"></script>
<script src="{{ asset('/js/bootstrap-notify.min.js')}}" charset="utf-8"></script>
<script src="{{ asset('/js/JsBarcode.all.min.js') }}" charset="utf-8"></script>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</html>
