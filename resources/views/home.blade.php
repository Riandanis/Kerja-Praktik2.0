@extends('adminlte::page')

@section('title', 'MOTRA')

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
            min-width: 1110px; /*harus edit di sini nih*/
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
        @if(Session::has('alert-success'))
            <div class="col-xs-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Sukses!</h4>
                    {{Session::get('alert-success')}}
                </div>
            </div>
        @elseif(Session::has('alert-danger'))
            <div class="col-xs-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-times"></i> Gagal!</h4>
                    {{Session::get('alert-danger')}}
                </div>
            </div>
        @endif
        <div class="col-xs-12">
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
                    <h5 style="margin-top: 5px"><strong></strong></h5>
                    <div>
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
    </div>
@stop


