@extends('adminlte::page')

@section('title', 'SIRapat')

@section('content_header')
    <h1>Account Manager</h1>
@stop

@section('content')
    <div class="row">
        @if(Session::has('alert-success'))
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Sukses!</h4>
                    {{Session::get('alert-success')}}. <a href="{{url('accmgr')}}">Kembali</a>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">Tambah Rapat</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{url('accmgr/store')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="IDAccMgr" class="col-sm-3 control-label">Topik<span style="color: red">*</span></label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="id_accm" placeholder="NIK Account Manager" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="NamaAccMgr" class="col-sm-3 control-label">Action<span style="color: red">*</span></label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_accm" placeholder="Nama Account Manager"required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="EmailAccMgr" class="col-sm-3 control-label">Due Date</label>

                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email_accm" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TlpAccMgr" class="col-sm-3 control-label">PIC</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tlp_accm" placeholder="No. Telepon">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="TlpAccMgr" class="col-sm-3 control-label">Keterangan</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="tlp_accm" placeholder="No. Telepon">
                                </div>
                            </div>                               
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route('accmgr')}}">
                                <button type="button" class="btn btn-default">Batal</button>
                            </a>
                            <button type="submit" class="btn btn-success pull-right">Simpan</button>


                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop