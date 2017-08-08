<html>
    <head>
        <title>PDF</title>
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/bootstrap/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fullcalendar/fullcalendar.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fullcalendar/fullcalendar.print.min.css') }}">
        <script src="{{ asset('vendor/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.28/jspdf.plugin.autotable.js"></script>
        <script src="https://xep.cloudformatter.com/Chandra.svc/genpackage"></script>
        <script src="https://xep.cloudformatter.com/Chandra.svc/genfile"></script>
        <script src="https://xep.cloudformatter.com/Chandra.svc/genpageimages"></script>
    </head>
    <body>
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

        tr:hover, td.start:hover, td.end:hover
        {
            background: #FF9;
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
    <!-- <a href="#" onclick="return xepOnline.Formatter.Format('content',{render:'newwin',
            cssStyle:[{fontSize:'30px'},{fontWeight:'bold'}]});">
        <button>render</button>
    </a> -->
<div style="margin-left:20%; margin-right: 20%; margin-top: 5%">
   <div id="content" align="center">
       <h3 align="left">Minutes of Meeting</h3>
        <table class="table">
            <tr>
                <td><strong>Date: </strong></td>
                <td>BODY</td>
            </tr>
            <tr>
                <td><strong>Place: </strong></td>
                <td>BODY</td>
            </tr>
            <tr>
                <td><strong>Time: </strong></td>
                <td>BODY</td>
            </tr>
            <tr>
                <td rowspan="4"><strong>Attendee: </strong></td>
                <td>Rani<br>sabila<br>joko<br>tralala<br>
                   @for($r = 0; $r < 2; $r++)
                    Rian<br>
                   @endfor 
                </td>
            </tr>
        </table>
    </div>
    <div align="left">
    <p>AGENDA:</p>
        <div>
            <ol>
                @for($p = 0; $p < 4; $p++)
                   {{$p + 1}}. Bahasan di dalam rapat tersebut<br>
                @endfor
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
                <th>PIC</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <th>Rekonsiliasi Total Link</th>
                <th>
                    @for($i = 0; $i < 3; $i++) 
                    Data Awal 
                        @for($l = 0; $l < 5; $l++)<br>
                        @endfor
                    @endfor
                </th>
                <td>
                    @for($k = 0; $k < 4; $k++) 
                    total link <br>
                    @endfor
                    <br>
                    data valid<br>
                    data valid<br>
                    data valid<br>
                    data valid<br><br>

                    pengecekan<br>
                    pengecekan<br>
                    pengecekan<br>
                    pengecekan<br><br>
                </td>
                <td>
                    JOKO<br>
                    JOKO<br>
                    JOKO<br>
                    <br>
                    JOKO<br>
                    JOKO<br>
                    JOKO<br>
                    <br>
                    JOKO<br>
                    JOKO<br>
                    JOKO<br>
                    JOKO<br>
                    <br>
                </td>
                <td>
                    2 Jan<br>
                    2 Jan<br>
                    2 Jan<br>
                    <br>
                    2 Jan<br>
                    2 Jan<br>
                    2 Jan<br>
                    <br>
                    2 Jan<br>
                    2 Jan<br>
                    2 Jan<br>
                    2 Jan<br>
                    <br>
                </td>
            </tr>
        </tbody>
        </table>
    </div>
</div>
        <!-- <script>
            var doc = new jsPDF('pre', 'pt');
            var source = window.document.getElementsByTagName("body")[0];
            specialElementHandlers = {
                '#bypassme': function (element, renderer) {
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 75,
                width: 180
            };
            doc.fromHTML(
                source,
                margins.left,
                margins.top,
                {
                    'width': margins.width
                },
                function (dispose) {
                    doc.output("dataurlnewwindow");
                }
            );
        </script> -->
    </body>
</html>





