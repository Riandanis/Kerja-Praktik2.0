<html>
	<head>
		<body>
		<form class="form-horizontal" method="post" action="{{url('rapatnya/store')}}">
				{{ csrf_field() }}
				<div class="box-body">
				<div class="form-group">
					<div class="col-sm-9">
					Nama Topik
					<input type="text" name="nama" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-9">
					Due date
					<input type="date" name="tgl_selesai">
					</div>
				</div>
				<div class="form-group" id="dynamicInput">
                                <label for="TlpAccMgr" class="col-sm-3 control-label">Hasil Diskusi</label><input type="button" value="+" onClick="addInput('dynamicInput')">
                

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="diskusi[]" placeholder="Diskusi">
                                </div>
                <div class="form-group" id="dynamicInput2">
                                <label for="TlpAccMgr" class="col-sm-3 control-label">Action</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="action[]" placeholder="Action">
                                </div>
                            </div>
				<input type="button" value="+" onClick="addInput2('dynamicInput2')">
                </div>
                </div>
				
				<!-- <input type="file" name="image" required> -->
				<button type="submit">Create Kontrak</button> 
			</form>
			<script>
            var counter1 = 1;
            var counter2 = 1;
            var limit = 99;
            function addInput2(divName){
            	console.log('panggil addinput2'); 
                 if (counter2 == limit)  {
                      alert("You have reached the limit of adding " + counter + " inputs");
                 }
                 else {
                      var newdiv = document.createElement('div');
                      newdiv.innerHTML = "Action " + (counter2 + 1) + " <br><input type='text' name='myInputs2[]' placeholder='Peserta'>";
                      document.getElementById(divName).appendChild(newdiv);
                      counter2++;
                 }
            	}
            function addInput(divName){

                 if (counter1 == limit)  {
                      alert("You have reached the limit of adding " + counter + " inputs");
                 }
                 else {
                 		console.log('testes');
                      var newdiv = document.createElement('div');
                      newdiv.innerHTML ="Diskusi " + (counter1 + 1) + " <br><input type='text' name='myInputs1[]' placeholder='Peserta'>";
                      document.getElementById(divName).appendChild(newdiv);
                      var newdiv2 = document.createElement('div');
                      // newdiv2.innerHTML = "Actions " + (counter2 + 1) + " <br><input type='text' name='myInputs[]' placeholder='Peserta'>";
                      // document.getElementById(divName).appendChild(newdiv2);
                      counter1++;
                      addInput2(divName);
                      var btn = document.createElement('button');
                      var t = document.createTextNode('+');
                      btn.setAttribute("type","button");
                      btn.appendChild(t);
                      btn.onclick = function(){
                      	addInput2(divName);
                      }
                      // newdiv2.setAttribute("id","dynamicInput2");
                      document.getElementById(divName).appendChild(btn)
                      // counter2++;
                 } 	
            }
            
            </script>    
		</body>
	</head>
</html>