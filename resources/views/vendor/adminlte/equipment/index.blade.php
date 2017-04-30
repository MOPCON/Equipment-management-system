@extends('adminlte::layouts.app')

@section('htmlheader_title')
Equipments
@endsection

@section('contentheader_title')
Equipments Index
@endsection

@section('main-content')
    <div id="equipment" class="container-fluid spark-screen">
        <div class="box">
            <!-- /.box-header -->
            <equipment></equipment>
            <!-- /.box-body -->
        </div>
    </div>
@endsection

@section('main-script')
@endsection
