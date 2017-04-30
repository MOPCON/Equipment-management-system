@extends('adminlte::layouts.app')

@section('htmlheader_title')
Groups
@endsection

@section('contentheader_title')
Groups Index
@endsection

@section('main-content')
    <div id="group" class="container-fluid spark-screen">
        <div class="box">
            <!-- /.box-header -->
            <group></group>
            <!-- /.box-body -->
        </div>
    </div>
@endsection

@section('main-script')
@endsection
