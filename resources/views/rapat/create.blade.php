<html>
<head></head>
<body>
    <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{url('rapatnya/store')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="JudulRapat" class="col-sm-3 control-label">Judul Rapat<span style="color: red">*</span></label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="Judul_Rapat" placeholder="Judul Rapat"required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="TTW" class="col-sm-3 control-label">Tanggal, Waktu</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="Tanggal" placeholder="Tempat, waktu">
                                </div>
                            </div>
                            <div class="form-group" id="dynamicInput">
                                <label for="TlpAccMgr" class="col-sm-3 control-label">Peserta 1</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="Peserta[]" placeholder="Peserta">
                                </div>
                            </div>
                             <input type="button" value="+" onClick="addInput('dynamicInput')">
                             <div class="box-footer">
                            <a href="{{route('rapatnya')}}">
                                <button type="button" class="btn btn-default">Batal</button>
                            </a>
                            <button type="submit" class="btn btn-success pull-right">Simpan</button>
                            
                            <script>
                            var counter = 1;
                            var limit = 99;
                            function addInput(divName){
                                 if (counter == limit)  {
                                      alert("You have reached the limit of adding " + counter + " inputs");
                                 }
                                 else {
                                      var newdiv = document.createElement('div');
                                      newdiv.innerHTML = "Peserta " + (counter + 1) + " <br><input type='text' name='Peserta[]' placeholder='Peserta'>";
                                      document.getElementById(divName).appendChild(newdiv);
                                      counter++;
                                 }
                            }
                            </script>                                
                        </div>

</body>
</html>