@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Topik</h1>
@stop

@section('content')
    <div class="row">
        @if(Session::has('alert-success'))
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Sukses!</h4>
                    {{Session::get('alert-success')}}
                </div>
            </div>
        @elseif(Session::has('alert-danger'))
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-times"></i> Gagal!</h4>
                    {{Session::get('alert-danger')}}
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Topik Agenda</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{url('topik/tambah/'.$agenda->id_rapat.'/'.$agenda->id_agenda)}}">
                                <button class="btn btn-primary">
                                    <i class="fa fa-plus-circle"></i> Tambah Topik
                                </button>
                            </a>
                        </div>
                    </div>
                    <br>
                    @if(count($topik)>0)
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th style="width: 50px">No. </th>
                                <th>Topik</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1?>
                            @foreach($topik as $t)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$t->nama_topik}}</td>
                                <td style="width:30px;">
                                    <a href="#">
                                        <button class="btn btn-default" data-widget="Tambah agenda" data-toggle="tooltip" title="Tambah agenda">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </td>
                                <td style="width:30px;">
                                    <a href="#">
                                        <button class="btn btn-default" data-widget="Lihat agenda" data-toggle="tooltip" title="Lihat agenda">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                </td>
                                <td style="width:30px;">
                                    <button id="btn-edit" type="button" class="btn btn-default edit-button">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </td>
                                <td align="center" width="30px">
                                    <button type="button" class="btn btn-default delete-button" data-name="{{$t->nama_topik}}" data-id="{{$t->id_topik}}" data-toggle="modal" data-target="#modal-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php $i++?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div id="modal-default" class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Agenda</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="post" action="" id="form-edit">
                                    {{ csrf_field() }}
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="IDAgenda" class="col-sm-2 control-label">ID Agenda</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="idagenda" name="id" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Hdline" class="col-sm-2 control-label">Headline Rapat</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="hdline" name="hdline" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Nama" class="col-sm-2 control-label">Nama Agenda</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="namaagenda"  name="nama">
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
                <div id="modal-danger" class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Hapus Agenda</h4>
                            </div>
                            <div class="modal-body">
                                <p id="show-name"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <a id="del-btn">
                                    <button type="submit" class="btn btn-danger pull-right" style="margin-left: 4px ;">Hapus</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                    <p>Data tidak ditemukan</p>
                @endif

            </div>
        </div>
    </div>
    
    <script>
        $(document).on("click", ".edit-button", function(){
            var id_topik = $(this).data('id');
            //var headline = $(this).data('rapat')
            var nama_topik = $(this).data('name');
            // console.log(id_agenda);
            $("#idagenda").val(id_agenda);
            $("#hdline").val(headline);
            $("#namaagenda").val(nama_agenda);

            $("#form-edit").attr('action','{{url('/agenda/edit')}}' + '/' + id_agenda);
        });
        $(document).on("click",".delete-button", function () {
            var id_topik = $(this).data('id');
            var nama_topik = $(this).data('name');
            $("#del-btn").attr('href','{{url('topik/delete')}}' + '/' + id_topik)
            $("#show-name").html('Anda yakin ingin menghapus agenda ' + nama_topik + '?')
        })
    </script>
@stop