@extends('adminlte::page')

@section('title', 'MeetTRA - Target')

@section('content_header')
    <h1>List Target</h1>
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
                    <h3 class="box-title">List Target</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    
                    <br>
                    @if(count($action)>0)
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th style="width: 50px">No. </th>
                                <th>Pekerjaan</th>
                                <th>Email PIC</th>
                                <th>Deadline</th>
                                <th>Solusi</th>
                                <th>Agenda Rapat</th>
                                <th>Topik Rapat</th>
                                <th>Diskusi Rapat</th>
                                <th>Actions</th>
                                <th colspan="3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1?>
                            @foreach($action as $a)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$a->deskripsi}}</td>
                                <td>{{$a->email_pic}}</td>
                                <td>{{$a->due_date}}</td>
                                <td>{{$a->solusi}}</td>
                                <td>{{$a->nama_agenda}}</td>
                                <td>{{$a->nama_topik}}</td>
                                <td>{{$a->nama_diskusi}}</td>
                                <td style="width:30px;">
                                    <span data-widget="Input Solusi" data-toggle="tooltip" title="Input Solusi">
                                        <button id="btn-edit" type="button" class="btn btn-default edit-button" 
                                        data-toggle="modal" data-target="#modal-default" 
                                        data-id="{{$a->id_action}}" 
                                        data-deskripsi="{{$a->deskripsi}}" 
                                        data-email="{{$a->email_pic}}"
                                        data-solusi="{{$a->solusi}}"
                                        data-duedate="{{$a->due_date}}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </span>
                                </td>
                                <td align="center" width="30px">
                                    <span data-widget="Hapus agenda" data-toggle="tooltip" title="Hapus agenda">
                                         <button type="button" class="btn btn-default delete-button" 
                                         data-id="{{$a->id_action}}" 
                                         data-toggle="modal" data-target="#modal-danger">
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
                                <button type="button" class="close" data-dismiss="modal" 
                                aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Action</h4>
                            </div>
                            <div class="modal-body">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="IDAgenda" class="col-sm-2 control-label">
                                            ID Action</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" 
                                                id="idaction"
                                                 name="id" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Hdline" class="col-sm-2 control-label">
                                            Pekerjaan</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" 
                                                id="deskripsi" name="deskripsi" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Hdline" class="col-sm-2 control-label">
                                            Email PIC</label>

                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" 
                                                id="pic" name="pic" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Nama" class="col-sm-2 control-label">
                                            Deadline</label>

                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" 
                                                id="due_date"  name="duedate" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="Nama" class="col-sm-2 control-label">
                                            Solusi</label>

                                            <div class="col-sm-10">
                                                <textarea class="form-control" type="text" 
                                                id="solusi"  name="solusi" style="height:200px" required>   
                                                </textarea> 
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
                                <button type="button" class="close" 
                                data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Hapus Agenda</h4>
                            </div>
                            <div class="modal-body">
                                <p id="show-name"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default" 
                                data-dismiss="modal">Batal</button>
                                <a id="del-btn">
                                    <button type="submit" class="btn btn-danger pull-right" 
                                    style="margin-left: 4px ;">Hapus</button>
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
            var id_action = $(this).data('id');
            var deskripsi = $(this).data('deskripsi');
            var pic = $(this).data('email');
            var solusi = $(this).data('solusi');
            var due_date = $(this).data('duedate');
            // console.log(id_agenda);
            $("#idaction").val(id_action);
            $("#deskripsi").val(deskripsi);
            $("#pic").val(pic);
            $("#solusi").val(solusi);
            $("#due_date").val(due_date);

            $("#form-edit").attr('action','{{url('/action/update')}}' + '/' + id_action);
        });
        $(document).on("click",".delete-button", function () {
            var id_action = $(this).data('id');
            //var nama_agenda = $(this).data('name');
            $("#del-btn").attr('href','{{url('action/delete')}}' + '/' + id_action)
            $("#show-name").html('Anda yakin ingin menghapus agenda ' + id_action + '?')
        });

    </script>
@stop


