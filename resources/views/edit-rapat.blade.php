@extends('adminlte::page')

@section('title', 'MeetTRA - Tambah Rapat')

@section('content_header')
    <h1>Dashboard</h1>
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
                    <h3 class="box-title">Edit Minutes of Meeting</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" action="{{url('rapat/update/'.$rpt->id_rapat)}}" method="post">
                        {{csrf_field()}}
                        <div class="box-body">
                            <input type="hidden" id="id_rap" value="{{$rpt->id_rapat}}" data-id="{{$rpt->id_rapat}}">
                            <div class="form-group">
                                <label for="HeadlineRapat" class="col-sm-2 control-label">Headline Rapat </label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Headline Rapat" name="headline" value="{{$rpt->headline}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="DateRapat" class="col-sm-2 control-label">Tanggal Rapat </label>

                                <div class="col-sm-8">
                                    <input type="date" class="form-control" placeholder="YYYY-MM-DD" name="tanggal_rapat" value="{{$wkt[0]}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TimeRapat" class="col-sm-2 control-label">Waktu Rapat</label>

                                <div class="col-sm-8">
                                    <input type="time" class="form-control" placeholder="HH:MM" name="waktu_rapat" value="{{$wkt[1]}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TempatRapat" class="col-sm-2 control-label">Tempat Rapat</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Tempat Rapat" name="tempat" value="{{$rpt->tempat_rapat}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="NamaLeader" class="col-sm-2 control-label">Nama Leader</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Nama Leader" name="leader" value="{{$rpt->leader}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="EmailLeader" class="col-sm-2 control-label">Email Leader</label>

                                <div class="col-sm-8">
                                    <input type="email" class="form-control" placeholder="Email Leader" name="email_leader" value="{{$rpt->email_leader}}">
                                </div>
                            </div>
                            @if(count($atd) > 0)
                            <div id="attendee-section">
                                <div class="form-group" id="dynamicInput">
                                    <label for="AttendeeRapat" class="col-sm-2 control-label">Attendee</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" placeholder="Attendee" name="peserta[]" value="{{$atd[0]->ket_attendee}}">
                                    </div>
                                    <div class="col-sm-2" style="display:none">
                                        <button type="button" class="btn btn-default fa fa-times" id="delete-attendee-button" style="margin-left:10px; margin-top: 0px; height: 34px"></button>
                                    </div>  
                                </div>
                            </div>
                            @else

                            <div id="attendee-section">
                                <div class="form-group" id="dynamicInput">
                                    <label for="AttendeeRapat" class="col-sm-2 control-label">Attendee</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Attendee" name="peserta[]">
                                        </div>
                                        <div class="col-sm-2" style=" display:none;">
                                            <button type="button" class="btn btn-default fa fa-times" id="delete-attendee-button" style="margin-left:10px; margin-top: 0px; height: 34px;"></button>
                                        </div>
                                </div>
                            </div>
                            
                            @endif
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
            var totalAttendee=1;
            var max_field = 99;
           
            var parentDiv = $("#attendee-section");

            var id_rapat = $('#id_rap').data('id');
            $.ajax ({
                type: "GET",
                url: "/getRapat",
                data: {
                    idrapat: id_rapat,
                },
                success: function(data) {
                    data = JSON.parse(data);
                    var i=0;

                    for (i=1; i<data.length; i++){
                        console.log(data[i].ket_attendee);
                        var theDiv = $("#dynamicInput")[0].outerHTML
                        .replace('<label for="AttendeeRapat" class="col-sm-2 control-label">Attendee</label>', '<label for="AttendeeRapat" class="col-sm-2 control-label"></label>')
                        .replace('<div class="form-group" id="dynamicInput">', '<div class="form-group">')
                        .replace('value="{{$atd[0]->ket_attendee}}"', 'value="'+data[i].ket_attendee+'"')
                        .replace('name="peserta[]"', 'name="peserta['+i+']"')
                        .replace('style="display:none"', '');
                        $(parentDiv).append(theDiv);
                        totalAttendee++;
                        console.log(totalAttendee);
                    }
                }
            })


            $("#add-attendee-button").on('click', function(e){
                e.preventDefault();
                var x = totalAttendee+1;
                 var newdiv = $("#dynamicInput")[0].outerHTML
                 .replace('<label for="AttendeeRapat" class="col-sm-2 control-label">Attendee</label>', '<label for="AttendeeRapat" class="col-sm-2 control-label"></label>')
                 .replace('<div class="form-group" id="dynamicInput">', '<div class="form-group">')
                 .replace('value="{{$atd[0]->ket_attendee}}"', '')
                 .replace('name="peserta[]"', 'name="peserta['+x+']"')
                 .replace('style="display:none"', '');
                if(totalAttendee < max_field) {
                    $(parentDiv).append(newdiv);
                    totalAttendee++;
                    console.log(totalAttendee);

                }
            })

             $(document).on('click', '#delete-attendee-button', function(e) {
                var btnParent = $(e.target).parents()[1];
                console.log(btnParent);
                totalAttendee--;
                 console.log(totalAttendee);

                 btnParent.remove();
            });


        })

    </script>
@stop


