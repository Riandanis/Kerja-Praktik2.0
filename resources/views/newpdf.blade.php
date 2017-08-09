<?php
ini_set('max_execution_time', 900);

?>


<link rel="stylesheet" href="{{ asset('vendor/adminlte/bootstrap/css/bootstrap.min.css') }}">

<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">


<!-- <a href="#" onclick="return xepOnline.Formatter.Format('content',{render:'newwin',
        cssStyle:[{fontSize:'30px'},{fontWeight:'bold'}]});">
    <button>render</button>
</a> -->
<body onload="window.start()">
<style>
    body
    {
        font-family: arial, helvetica, sans-serif;
    }
    table
    {
        border-collapse: collapse;
        margin-bottom: 3em;
        font-size: 70%;
        line-height: 1.1;
    }

    th, td
    {
        padding: .3em .5em;
    }
    th
    {
        font-weight: normal;
        text-align: left;
        padding-left: 15px;
    }
    th.name { width: 12em; }
    th.location { width: 12em; }
    th.color { width: 10em; }
    thead th
    {
        background: #c6ceda;
        border-color: #fff #fff #888 #fff;
        border-style: solid;
        border-width: 1px 1px 2px 1px;
        padding-left: .5em;
    }
    tbody th.start
    {
        padding-left: 26px;
    }
    tbody th.end
    {
        padding-left: 26px;
    }
    #content{
        margin: 0 auto;
        width: 100%;
    }
</style>
<body>
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6">
            <img src="/image/telkom_logo.png" width="100px" style="margin-left: 20px; margin-top: 20px">
        </div>
    </div>
</div>

<div style="margin-left:5%; margin-right: 5%; margin-top: 5%">
    <div id="content" align="center">
        <h5 align="left" style="font-family: 'Arial'"><strong>Minutes of Meeting</strong></h5>
        <table class="table">
            <tr>
                <td><strong>Date: </strong></td>
                <td style="font-family: 'Arial'">{{$tanggal_rapat}}</td>
            </tr>
            <tr>
                <td><strong>Place: </strong></td>
                <td>{{$rapat[0]->tempat_rapat}}</td>
            </tr>
            <tr>
                <td><strong>Time: </strong></td>
                <td>{{$waktu_rapat}}</td>
            </tr>
            <tr>
                <td rowspan="4"><strong>Attendee: </strong></td>
                <td>
                    @foreach($attendee as $att)
                        {{$att->ket_attendee}}<br>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
    @foreach($agenda as $agn)
        <div align="left">
            <p><strong>Agenda:</strong></p>

            <p><span style="font-size: smaller;font-family: 'Arial'">{{$agn->nama_agenda}}</span></p>

        </div>
        <br>
        <div align="center">
            <table class="table" width="100%">
                <thead>
                <tr>
                    <th style="width: 30px">No.</th>
                    <th>Topik</th>
                    <th>Hasil Diskusi</th>
                    <th>Action</th>
                </tr>
                </thead>
                <?php $no=1?>
                <tbody>
                <?php
                $beforeDis = null;
                $beforeTop = null;
                ?>
                @foreach($topik as $top)
                    @if($agn->id_agenda == $top->id_agenda)
                        @foreach($diskusi as $dis)
                            @if($top->id_topik == $dis->id_topik)
                                @foreach($action as $act)
                                    @if($act->id_diskusi == $dis->id_diskusi)
                                        <tr>
                                            <td>
                                                @if($beforeTop != $act->id_topik)
                                                    {{$no++}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($beforeTop != $act->id_topik)
                                                    {{$act->nama_topik}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($beforeDis != $act->id_diskusi)
                                                    {{$act->nama_diskusi}}
                                                @endif
                                            </td>
                                            <td>
                                                {{$act->deskripsi}}
                                            </td>
                                        </tr>
                                    @endif
                                    <?php
                                    $beforeDis = $act->id_diskusi;
                                    $beforeTop = $act->id_topik;
                                    ?>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>
</body>






