@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Jadwal Rapat</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div id="calendar">

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


