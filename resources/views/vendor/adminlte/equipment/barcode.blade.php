@extends('adminlte::layouts.app')

@section('htmlheader_title')
Equipments Barcode
@endsection

@section('contentheader_title')
Equipments Barcode Index
@endsection

@section('main-content')
    <div id="equipment" class="container-fluid spark-screen">
        <div class="box">
            <!-- /.box-header -->
            <equbarcode></equbarcode>
            <!-- /.box-body -->
        </div>
    </div>
@endsection

@section('main-script')
@endsection
