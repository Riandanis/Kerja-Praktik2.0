<?php
ini_set('max_execution_time', 300);
?>


        <link rel="stylesheet" href="{{ asset('vendor/adminlte/bootstrap/css/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">


    <!-- <a href="#" onclick="return xepOnline.Formatter.Format('content',{render:'newwin',
            cssStyle:[{fontSize:'30px'},{fontWeight:'bold'}]});">
        <button>render</button>
    </a> -->
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
        background: url(tabletree-arrow.gif) no-repeat 2px 50%;
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
        background: url(tabletree-dots.gif) 18px 54% no-repeat;
        padding-left: 26px;
    }
    tbody th.end
    {
        background: url(tabletree-dots2.gif) 18px 54% no-repeat;
        padding-left: 26px;
    }
    #content{
        margin: 0 auto;
        width: 100%;
    }
</style>
<div style="margin-left:20%; margin-right: 20%; margin-top: 5%">
   <div id="content" align="center">
       <h3 align="left">Minutes of Meeting</h3>
        <table class="table">
            <tr>
                <td><strong>Date: </strong></td>
                <td>{{$tanggal_rapat}}</td>
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
    <p>AGENDA:</p>
        <div>
            <ol>
                {{$agn->nama_agenda}}
            </ol>
        </div>
    </div>
    <div align="center">
        <table class="table">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>Topik</th>
                    <th>Diskusi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php $no=1?>
            <tbody>
             @foreach($topik as $top)
                 @if($top->id_agenda == $agn->id_agenda)
                <tr>
                    <td>{{$no}}</td>
                    <th>{{$top->nama_topik}}</th>
                    <th>
                        @foreach($diskusi as $dis)
                            @if ($dis->id_topik == $top->id_topik)
                            {{$dis->nama_diskusi}}

                            @for($l = 1; $l < count($action); $l++)<br>
                            @endfor

                            @endif
                        @endforeach
                    </th>
                    <td>
                        @foreach($diskusi as $dis)
                            @foreach($action as $act)
                                @if($act->id_diskusi == $dis->id_diskusi && $dis->id_topik == $top->id_topik)
                                {{$act->deskripsi}}<br>
                                @endif
                            @endforeach
                            <br>
                        @endforeach
                        <br>
                    </td>
                </tr>
                     <?php $no++;?>
                @endif
                 @endforeach
            </tbody>
        </table>
    </div>
@endforeach
</div>






