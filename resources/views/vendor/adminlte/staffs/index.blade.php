@extends('adminlte::layouts.app')

@section('htmlheader_title')
Staffs
@endsection

@section('contentheader_title')
Staffs Index
@endsection

@section('main-content')
    <div id="staff" class="container-fluid spark-screen">
        <div class="box">
            <!-- /.box-header -->
            <staff></staff>
            <!-- /.box-body -->
        </div>
    </div>
@endsection

@section('main-script')
@endsection
