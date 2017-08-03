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
  <p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p> @if(count($rapat))
    <table class="table">
      <thead>
        <tr>
          <th>ID Rapat</th>
          <th>Judul Rapat</th>
          <th>Waktu Rapat</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rapat as $r)
        <tr>
          <td>{{$r->id_rapat}}</td>
          <td>{{$r->headline}}</td>
          <td>{{$r->waktu_rapat}}</td>
          <td><a href="{{url('agenda',$r->id_rapat)}}" class='btn btn-default'> Agenda</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endif           
  
</div>

</body>
</html>
