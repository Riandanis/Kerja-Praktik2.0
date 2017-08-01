<html>
	<head>
		<body>
		<form class="form-horizontal" method="post" action="{{url('rapatnya/store')}}">
				{{ csrf_field() }}
				<input type="hidden" name="id" required>
				Nama Topik
				<input type="text" name="nama" required>
				
				Due date
				<input type="date" name="tgl_selesai">
				<div class="form-group" id="dynamicInput">
                                <label for="TlpAccMgr" class="col-sm-3 control-label">Hasil Diskusi</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="diskusi[]" placeholder="Diskusi">
                                </div>
                </div>
				<input type="button" value="+" onClick="addInput('dynamicInput')">
				<div class="form-group" id="dynamicInput2">
                                <label for="TlpAccMgr" class="col-sm-3 control-label">Action</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="action[]" placeholder="Action">
                                </div>
                            </div>
				<input type="button" value="+" onClick="addInput2('dynamicInput2')">
				<!-- <input type="file" name="image" required> -->
				<button type="submit">Create Kontrak</button> 
			</form>
			<script>
            var counter1 = 1;
            var counter2 = 1;
            var limit = 99;
            function addInput(divName){
                 if (counter == limit)  {
                      alert("You have reached the limit of adding " + counter + " inputs");
                 }
                 else {
                      var newdiv = document.createElement('div');
                      newdiv.innerHTML =" <br><input type='text' name='myInputs[]' placeholder='Peserta'>";
                      document.getElementById(divName).appendChild(newdiv);
                      counter1++;
                      // var newdiv2 = document.createElement('div');
                      // newdiv2.innerHTML = "Peserta " + (counter2 + 1) + " <br><input type='text' name='myInputs[]' placeholder='Peserta'>";
                      // document.getElementById(divName).appendChild(newdiv);
                      // counter2++;
                 }
            }
            function addInput2(divName){
                 if (counter == limit)  {
                      alert("You have reached the limit of adding " + counter + " inputs");
                 }
                 else {
                      var newdiv = document.createElement('div');
                      newdiv.innerHTML = "Peserta " + (counter2 + 1) + " <br><input type='text' name='myInputs[]' placeholder='Peserta'>";
                      document.getElementById(divName).appendChild(newdiv);
                      counter2++;
                 }
            }
            </script>    
		</body>
	</head>
</html>