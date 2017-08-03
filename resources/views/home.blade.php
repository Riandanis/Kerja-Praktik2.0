@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    <style>
        #detail-calendar{
            display: none;
            position: fixed;
            bottom: -20px;
            width: auto;
            min-width: 1110px;
            max-width: 1200px;
            background-color: white;
            z-index: 1;
            height: auto;
            border-top-color: #605ca8;
            max-height: 200px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>
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
            <div class="box" id="detail-calendar">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
                <div class="box-body">
                    <div class="row" style="margin-top: 20px">
                        <div class="col-md-6">
                            <a id="tambahrapat" class='btn btn-primary'><i class="fa fa-plus-circle"></i> Tambah Rapat</a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th colspan="3"></th>
                            </tr>

                        </thead>
                        <tbody id="insert_here">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop


