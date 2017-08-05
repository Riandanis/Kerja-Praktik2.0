@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Agenda</h1>
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
                    <h3 class="box-title">Agenda Rapat </h3>
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
                                        <form class="form-horizontal" method="post" action="{{url('agenda/store', $rapat->id_rapat)}}">
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
                    @if(count($agenda)>0)
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th style="width: 50px">No. </th>
                                <th>Agenda</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1?>
                            @foreach($agenda as $a)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$a->nama_agenda}}</td>
                                <td style="width:30px;">
                                    <a href="{{url('topik/tambah/'.$rapat->id_rapat.'/'.$a->id_agenda)}}">
                                        <button class="btn btn-default" data-widget="Tambah topik" data-toggle="tooltip" title="Tambah topik">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                </td>
                                <td style="width:30px;">
                                <span data-widget="Lihat topik" data-toggle="tooltip" title="Lihat topik">
                                    <button class="btn btn-default topik-button" data-toggle="modal" data-target="#modal-topik" data-id="{{$a->id_agenda}}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </span>

                                </td>
                                <td style="width:30px;">
                                    <span data-widget="Edit agenda" data-toggle="tooltip" title="Edit agenda">
                                        <button id="btn-edit" type="button" class="btn btn-default edit-button" data-toggle="modal" data-target="#modal-default" data-id="{{$a->id_agenda}}" data-rapat="{{$rapat->headline}}" data-name="{{$a->nama_agenda}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </span>

                                </td>
                                <td align="center" width="30px">
                                    <span data-widget="Hapus agenda" data-toggle="tooltip" title="Hapus agenda">
                                         <button type="button" class="btn btn-default delete-button" data-name="{{$a->nama_agenda}}" data-id="{{$a->id_agenda}}" data-toggle="modal" data-target="#modal-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    </span>
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
                <div id="modal-topik" class="modal fade" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Hapus Agenda</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-condensed">
                                    <tbody id="insert-topik">

                                    </tbody>
                                </table>
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

                </div>
                @else
                    <p>Data tidak ditemukan</p>
                @endif

            </div>
        </div>
    </div>
    <?php $tes=1;?>
    
    <script>
        $(document).on("click", ".edit-button", function(){
            var id_agenda = $(this).data('id');
            var headline = $(this).data('rapat')
            var nama_agenda = $(this).data('name');
            // console.log(id_agenda);
            $("#idagenda").val(id_agenda);
            $("#hdline").val(headline);
            $("#namaagenda").val(nama_agenda);

            $("#form-edit").attr('action','{{url('/agenda/edit')}}' + '/' + id_agenda);
        });
        $(document).on("click",".delete-button", function () {
            var id_agenda = $(this).data('id');
            var nama_agenda = $(this).data('name');
            $("#del-btn").attr('href','{{url('agenda/delete')}}' + '/' + id_agenda)
            $("#show-name").html('Anda yakin ingin menghapus agenda ' + nama_agenda + '?')
        });

        $(document).on("click", ".topik-button", function() {
            var id_agenda = $(this).data('id');
            console.log(id_agenda);
            $.ajax({
                type: "GET",
                url: "/topik",
                data: {
                    q: id_agenda
                },
                success: function (data) {
                    $('#insert-topik').append('<tr><td><strong>Topik</strong></td><td></td></tr>');
                    data = JSON.parse(data);
                    data.forEach(function(obj){
                        $('#insert-topik').append('<tr><td>'+obj.nama_topik+'</td><td>Edit</td></tr>');
                    });
                }
            })

        })
    </script>
@stop


