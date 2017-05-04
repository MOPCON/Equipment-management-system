@extends('adminlte::layouts.app')

@section('htmlheader_title')
Lend & Return System
@endsection

@section('contentheader_title')
    Lend & Return System
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#lend" data-toggle="tab" aria-expanded="true">Lend</a></li>
                <li class=""><a href="#return" data-toggle="tab" aria-expanded="false">Return (Barcode)</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="lend">
                    <lend></lend>
                </div>
                <div class="tab-pane" id="return">
                    <returnbarcode></returnbarcode>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('main-script')
@endsection
