<html>
	<head>
		<body>
			<h1>Terdapat {{$banyak}} kontrak yang belum ditindaklanjuti</h1>
			<ol>
				@foreach($deskripsi as $tmp)
				<li>Action {{$tmp}} memiliki deadline kurang dari 3 hari</li>
				@endforeach
			</ol>
			<p>Silahkan buka aplikasi untuk lebih detailnya.</p>
		</body>
	</head>
</html>