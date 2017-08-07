<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Basic Table</h2>
  <p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p> @if(count($agenda))
    <table class="table">
      <thead>
        <tr>
          <th>Agenda</th>
          <th>Jtopik</th>
        </tr>
      </thead>
      <tbody>
        @foreach($agenda as $a)
        <tr>
          <td>{{$a->nama_agenda}}</td>
          <td>
            <button type="button" class="btn btn-info btn-lg edit-button" data-toggle="modal" data-target="#myModal" data-id="{{$a->id_agenda}}">Open Modal</button>
            <!-- @foreach($topik[$a->id_agenda] as $t)
              {{$t->nama_topik}}
              <br>
            @endforeach -->

            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                  </div>
                  <div class="modal-body">
                    @foreach($topik<div id=idagenda>[]</div> as $t)
                      <p>{{$t->nama_topik}}</p>
                      <br>
                    @endforeach
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
                
              </div>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif           
  
</div>
<script>
        $(document).on("click", ".edit-button", function(){
            var id_agenda = $(this).data('id');
            
            // console.log(id_agenda);
            $("#idagenda").val(id_agenda);
            
        });
       
    </script>
</body>
</html>
