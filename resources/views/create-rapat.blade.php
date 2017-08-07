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
                    <h3 class="box-title">Tambah Minutes of Meeting</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" action="{{url('rapat/store')}}" method="post">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="HeadlineRapat" class="col-sm-2 control-label">Headline Rapat <span style="color: red">*</span></label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Headline Rapat" name="headline" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="DateRapat" class="col-sm-2 control-label">Tanggal Rapat </label>

                                <div class="col-sm-10">
                                    <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="tanggal_rapat" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TimeRapat" class="col-sm-2 control-label">Waktu Rapat</label>

                                <div class="col-sm-10">
                                    <input type="time" class="form-control" placeholder="HH:MM" name="waktu_rapat">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TempatRapat" class="col-sm-2 control-label">Tempat Rapat</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Tempat Rapat" name="tempat">
                                </div>
                            </div>
                            <div id="attendee-section">
                                <div class="form-group" id="dynamicInput">
                                    <label for="AttendeeRapat" class="col-sm-2 control-label">Attendee</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="Attendee" name="peserta[]">
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-default pull-right" id="add-attendee-button" style="margin-right: 0px">Tambah Attendee</button>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{url('home')}}">
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

    <script>
        $(document).ready(function(){
            var totalAttendee=0;
            var max_field = 99;
            var newdiv = $("#dynamicInput")[0].outerHTML.replace('<label for="AttendeeRapat" class="col-sm-2 control-label">Attendee</label>', '<label for="AttendeeRapat" class="col-sm-2 control-label"></label>').replace('<div class="form-group" id="dynamicInput">', '<div class="form-group">');
            var parentDiv = $("#attendee-section");

            $("#add-attendee-button").on('click', function(e){
                e.preventDefault();
                if(totalAttendee < max_field) {
                    $(parentDiv).append(newdiv);
                    totalAttendee++;
                }
            })

        })

    </script>
@stop


