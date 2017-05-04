@extends('adminlte::layouts.app')

@section('htmlheader_title')
Loan log
@endsection

@section('contentheader_title')
Loan log
@endsection

@section('main-content')
    <div id="equipment" class="container-fluid spark-screen">
        <div class="box">
            <!-- /.box-header -->
            <loan></loan>
            <!-- /.box-body -->
        </div>
    </div>
@endsection

@section('main-script')
@endsection
