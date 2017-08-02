<html>
    <head>
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
        #content{
            margin: 0 auto;
            width: 100%;
        }
    </style>
    <a href="#" onclick="return xepOnline.Formatter.Format('content',{render:'newwin',
            cssStyle:[{fontSize:'30px'},{fontWeight:'bold'}]});">
        <button>render</button>
    </a>
   <div id="content" align="center">
       <h3>Minutes of Meeting</h3>
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
                <td><strong>Attendee: </strong></td>
                <td>
                    <ol>
                        <li>Karel Purba</li>
                        <li>Karel Purba</li>
                        <li>Karel Purba</li>
                        <li>Karel Purba</li>
                        <li>Karel Purba</li>
                    </ol>
                </td>
            </tr>
        </table>
    </div>
        <script>
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
        </script>
    </body>
</html>





