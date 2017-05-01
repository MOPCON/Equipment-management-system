<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get(Auth::user()->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p class="text-capitalize">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="/staffs"><i class='glyphicon glyphicon-user'></i> <span>Staffs Manager</span></a>
                <ul class="treeview-menu">
                    <li><a href="/staffs">Staff</a></li>
                    <li><a href="/group">Group</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class='glyphicon glyphicon-hdd'></i> <span>Equipments Manager</span></a>
                <ul class="treeview-menu">
                    <li><a href="/equipments">Equipments</a></li>
                    <li><a href="/equipments/barcode">Barcode</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class='glyphicon glyphicon-transfer'></i> <span>Loan Manager</span></a>
                <ul class="treeview-menu">
                    <li><a href="/loan">Loan log</a></li>
                    <li><a href="/loan/action">Lend & Return System</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='glyphicon glyphicon-cog'></i> <span>Setting</span></a>
                <ul class="treeview-menu">
                    <li><a href="/user">User Manager</a></li>
                    <li><a href="/print">Barcode Print</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
