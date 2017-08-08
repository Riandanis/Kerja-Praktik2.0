@extends('adminlte::page')

@section('title', 'MOTRA - Tambah Topik')

@section('content_header')
    <h1>Agenda</h1>
@stop

@section('content')
    <style>
        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tambah Topik</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{url('topik/store/'.$rapat.'/'.$agenda)}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Topik" class="col-sm-2 control-label">Topik <span style="color: red">*</span></label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="topik" placeholder="Topik" required>
                                </div>
                            </div>
                            <div id="form-section">
                                <div id="discussion-coy">
                                    <div id="discussion-section" style="display: none">
                                        <br>
                                        <br>
                                        <hr>
                                        <div class="form-group">
                                            <label for="HasilDiskusi" class="col-sm-2 control-label">Hasil Diskusi</label>

                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="diskusi[0]" placeholder="Hasil Diskusi" diskusi="0">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-default fa fa-times" id="delete-discussion-button" style="margin-left:10px; margin-top: 0px; height: 34px"></button>
                                            </div>
                                        </div>
                                        <div id="discussion-action">
                                            <div id="action-section" style="margin-top: 40px">
                                                <div class="form-group">
                                                    <label for="Action" class="col-sm-2 control-label">Action</label>

                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" name="action[0][]" placeholder="Action"></textarea>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-default fa fa-times" id="delete-action-button" style="margin-left:10px; margin-top: 0px; height: 34px"></button>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group" style="margin-left: 75px">
                                                            <label for="KeteranganAct" class="col-sm-4 control-label">Keterangan</label>

                                                            <div class="col-sm-8">
                                                                <select class="form-control" name="keterangan[0][]" style="width: 105px">
                                                                    <option>Informasi</option>
                                                                    <option>Target</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4" style="margin-left: -110px">
                                                        <div class="form-group">
                                                            <label for="PICAct" class="col-sm-4 control-label">PIC</label>

                                                            <div class="col-sm-8">
                                                                <input type="email" name="pic[0][]" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4" style="margin-left: -30px;">
                                                        <div class="form-group">
                                                            <label for="DueDate" class="col-sm-4 control-label">Due Date</label>

                                                            <div class="col-sm-8">
                                                                <input type="date" name="due_date[0][]" placeholder="Due Date" class="form-control" id="datepicker1" style="width: 170px">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-default pull-right" id="add-action-button" style="margin-right: 20px">Tambah Action</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-default pull-right" id="add-discussion-button" style="margin-right: 3px">Tambah Hasil Diskusi</button>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{url('agenda/'.$rapat)}}">
                                <button type="button" class="btn btn-default">Batal</button>
                            </a>
                            <button type="submit" class="btn btn-success pull-right">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){

            var MAX_FIELDS = 11;
            var totalDiscussion = 0;
            var ind = 0;
            var totalAction = 0;
            var discussionSectionClone = $("#discussion-section")[0].outerHTML.replace('<button type="button" class="btn btn-default fa fa-times" id="delete-discussion-button" style="margin-left:10px; margin-top: 0px; height: 34px"></button>','').replace('diskusi[0]', 'diskusi['+totalDiscussion+']').replace('action[0][]', 'action['+totalDiscussion+']['+totalAction+']').replace('style="display: none"', '').replace('diskusi="0"', 'diskusi="'+totalDiscussion+'"').replace('name="keterangan[0][]"', 'name="keterangan['+totalDiscussion+']['+totalAction+']"').replace('name="pic[0][]"', 'name="pic['+totalDiscussion+']['+totalAction+']"').replace('name="due_date[0][]"', 'name="due_date['+totalDiscussion+']['+totalAction+']"');
            var formContent = $('#form-section');
            var discussionActionFieldsClone = $('#action-section')[0].outerHTML.replace('<button type="button" class="btn btn-default fa fa-times" id="delete-action-button" style="margin-left:10px; margin-top: 0px; height: 34px"></button>');
            var actionFieldsClone = $('#discussion-action')[0].outerHTML;

            if (totalDiscussion==0) {
                $(formContent).append(discussionSectionClone);
                console.log(discussionSectionClone);
                totalDiscussion++;
                ind++;
            }

            $('#add-discussion-button').on('click', function(e){ //on add input button click
                e.preventDefault();
                discussionSectionClone = $("#discussion-section")[0].outerHTML.replace('diskusi[0]', 'diskusi['+totalDiscussion+']').replace('action[0][]', 'action['+totalDiscussion+'][]').replace('style="display: none"', '').replace('diskusi="0"', 'diskusi="'+totalDiscussion+'"').replace('name="keterangan[0][]"', 'name="keterangan['+totalDiscussion+'][]"').replace('name="pic[0][]"', 'name="pic['+totalDiscussion+'][]"').replace('name="due_date[0][]"', 'name="due_date['+totalDiscussion+'][]"');
//                console.log(discussionSectionClone);
                if( totalDiscussion < MAX_FIELDS){ //max input box allowed
                    $(formContent).append(discussionSectionClone);
                    console.log(discussionSectionClone);
                    totalDiscussion++;
                    ind++;
                }
            });

            $(document).on('click', '#add-action-button', function(e) {
                var btnParent = $(e.target.parentNode.childNodes[9]);
                var nthDiscussion = $(e.target.parentNode.childNodes[7].childNodes[3].childNodes[1]).attr('diskusi');
                console.log(btnParent);
                discussionActionFieldsClone = $(actionFieldsClone)[0].outerHTML.replace('action[0][]', 'action['+nthDiscussion+'][]').replace('keterangan[0][]', 'keterangan['+nthDiscussion+'][]').replace('pic[0][]', 'pic['+nthDiscussion+'][]').replace('due_date[0][]', 'due_date['+nthDiscussion+'][]');
                totalAction++;
                console.log(btnParent);

                btnParent.append(discussionActionFieldsClone);
            });

            $(document).on('click', '#delete-action-button', function(e) {
                var btnParent = $(e.target.parentNode.parentNode.parentNode);
                totalAction--;
                btnParent.remove();
            });

            $(document).on('click', '#delete-discussion-button', function(e) {
                var btnParent = $(e.target.parentNode.parentNode.parentNode);
                totalDiscussion--;
                btnParent.remove();
            });

        })


    </script>
@stop


