<html>
	<head>
		<body>
			<h3>Terdapat {{$total}} pekerjaan mendekati deadline!</h3>
			@foreach($action as $tmp)
			<li>Pekerjaan {{$tmp->deskripsi}} dengan PIC {{$tmp->email_pic}} memiliki deadline {{$tmp->due_date}}</li>
			@endforeach
		</body>
	</head>
</html>