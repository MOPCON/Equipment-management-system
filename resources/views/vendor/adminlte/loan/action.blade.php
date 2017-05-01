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
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                    like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
            </div>
        </div>
    </div>
@endsection

@section('main-script')
@endsection
