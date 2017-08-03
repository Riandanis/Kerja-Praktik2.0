@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Agenda</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Agenda Rapat</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add-agenda">
                                <i class="fa fa-plus-circle"></i> Tambah Agenda
                            </button>
                        </div>
                        <div id="add-agenda" class="modal fade" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Tambah Agenda</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" method="post" action="#">
                                            {{ csrf_field() }}
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label for="NamaAgenda" class="col-sm-3 control-label">Nama Agenda <span style="color: red">*</span></label>

                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" placeholder="Nama Agenda" name="nama" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success pull-right">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <table class="table table-condensed">
                        <?php $i=0?>
                        <thead>
                            <tr>
                                <th style="width: 50px">No.</th>
                                <th>Agenda</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>00{{++$i}}</td>
                                <td>nama agenda</td>
                                <td style="width:30px;">
                                    <button class="btn btn-default" data-widget="Tambah topik" data-toggle="tooltip" title="Tambah topik">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                <td style="width:30px;">
                                    <button class="btn btn-default" data-widget="Lihat topik" data-toggle="tooltip" title="Lihat topik">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>00{{++$i}}</td>
                                <td>nama agenda</td>
                                <td style="width:30px;">
                                    <button class="btn btn-default" data-widget="Tambah topik" data-toggle="tooltip" title="Tambah topik">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                <td style="width:30px;">
                                    <button class="btn btn-default" data-widget="Lihat topik" data-toggle="tooltip" title="Lihat topik">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>00{{++$i}}</td>
                                <td>nama agenda</td>
                                <td style="width:30px;">
                                    <button class="btn btn-default" data-widget="Tambah topik" data-toggle="tooltip" title="Tambah topik">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                                <td style="width:30px;">
                                    <button class="btn btn-default" data-widget="Lihat topik" data-toggle="tooltip" title="Lihat topik">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop


