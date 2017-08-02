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
                    <h3 class="box-title">Tambah Topik</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="#">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Topik" class="col-sm-2 control-label">Topik <span style="color: red">*</span></label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="topik" placeholder="Topik" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="HasilDiskusi" class="col-sm-2 control-label">Hasil Diskusi</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="diskusi[][]" placeholder="Hasil Diskusi">
                                </div>
                            </div>
                            <div class="input-field">
                            </div>
                            <button type="button" class="btn btn-default add-button pull-right"style="margin-right: 3px">Tambah Hasil Diskusi</button>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{url('agenda')}}">
                                <button type="button" class="btn btn-default">Batal</button>
                            </a>
                            <button type="submit" class="btn btn-success pull-right">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var max_fields=10;
            var x=0;
            $(".add-button").click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(".input-field").append('<div class="form-group"><label for="HasilDiskusi" class="col-sm-2 control-label">Hasil Diskusi</label><div class="col-sm-9"><input type="text" class="form-control" name="diskusi[][]" placeholder="Hasil Diskusi"></div><div class="col-sm-1"><a href="#" class="remove_field"><button class="btn btn-default"><i class="fa fa-times"></i></button></a></div></div><div class="action-field'+x+'"></div>');
                }
            });

            $(".add-action-button").click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(".action-field").append('<div class="form-group"><label for="HasilDiskusi" class="col-sm-2 control-label">Hasil Diskusi</label><div class="col-sm-9"><input type="text" class="form-control" name="diskusi[][]" placeholder="Hasil Diskusi"></div><div class="col-sm-1"><a href="#" class="remove_field"><button class="btn btn-default"><i class="fa fa-times"></i></button></a></div></div>');
                }
            });

            $(".input-field").on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parents()[1].remove(); x--;
            })
        })


    </script>
@stop


