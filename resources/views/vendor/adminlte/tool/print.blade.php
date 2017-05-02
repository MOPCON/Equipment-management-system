@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Barcode Print Tool
@endsection

@section('contentheader_title')
    Barcode Print Tool
@endsection

@section('main-content')
    <div id="print" class="container-fluid spark-screen">
        <div class="box">
            <!-- /.box-header -->
            <print></print>
            <!-- /.box-body -->
        </div>
    </div>
@endsection

@section('main-script')
@endsection
