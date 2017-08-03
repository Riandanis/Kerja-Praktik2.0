@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Agenda</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tambah Topik</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="#">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="Topik" class="col-sm-2 control-label">Topik <span style="color: red">*</span></label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="topik" placeholder="Topik" required>
                                </div>
                            </div>
                            <div id="form-section">
                                <div id="discussion-coy" class="wadu">
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
                                                <button type="button" class="btn btn-default" id="delete-discussion-button" style="margin-left:10px; margin-top: 0px"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div id="discussion-action">
                                            <div id="action-section">
                                                <div class="form-group">
                                                    <label for="Action" class="col-sm-2 control-label">Action</label>

                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" name="action[0][]" placeholder="Action"></textarea>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-default" id="delete-action-button" style="margin-left:10px; margin-top: 10px"><i class="fa fa-times"></i></button>
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
                            <a href="{{url('agenda')}}">
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

            const MAX_FIELDS = 10;
            var totalDiscussion = 1;
            var ind = 0;
            var totalAction = 1;
            var discussionSectionClone = $("#discussion-section")[0].outerHTML.replace('<button type="button" class="btn btn-default" id="delete-discussion-button" style="margin-left:10px; margin-top: 0px"><i class="fa fa-times"></i></button>','').replace('diskusi[0]', 'diskusi['+totalDiscussion+']').replace('action[0][]', 'action['+totalDiscussion+'][]').replace('style="display: none"', '').replace('diskusi="0"', 'diskusi="'+ind+'"');
            const formContent = $('#form-section');
            var discussionActionFieldsClone = $('#action-section')[0].outerHTML.replace('<button type="button" class="btn btn-default" id="delete-action-button" style="margin-left:10px; margin-top: 10px"><i class="fa fa-times"></i></button>');
            const actionFieldsClone = $('#discussion-action')[0].outerHTML;

            if (totalDiscussion==1) {
                $(formContent).append(discussionSectionClone);
                totalDiscussion++;
                ind++;
            }

            $('#add-discussion-button').on('click', function(e){ //on add input button click
                e.preventDefault();
                discussionSectionClone = $("#discussion-section")[0].outerHTML.replace('diskusi[0]', 'diskusi['+totalDiscussion+']').replace('action[0][]', 'action['+totalDiscussion+'][]').replace('style="display: none"', '').replace('diskusi="0"', 'diskusi="'+ind+'"');
//                console.log(discussionSectionClone);
                if( totalDiscussion < MAX_FIELDS){ //max input box allowed
                    $('#form-section').append(discussionSectionClone);
                    totalDiscussion++;
                    ind++;
                }
            });

            $(document).on('click', '#add-action-button', function(e) {
                var btnParent = $(e.target.parentNode.childNodes[9]);
                var nthDiscussion = $(e.target.parentNode.childNodes[7].childNodes[3].childNodes[1]).attr('diskusi');
                console.log(nthDiscussion);
                discussionActionFieldsClone = $('#action-section')[0].outerHTML.replace('action[0][]', 'action['+nthDiscussion+'][]');
                totalAction++;
//                console.log($(btnParent));

                btnParent.append(discussionActionFieldsClone);
            });

            $(document).on('click', '#delete-action-button', function(e) {
                var btnParent = $(e.target.parentNode.parentNode.parentNode);
                totalAction--;
                console.log(btnParent);
                btnParent.remove();
            });

            $(document).on('click', '#delete-discussion-button', function(e) {
                var btnParent = $(e.target).parents();
//                if (btnParent[0].includes("</i>")) console.log('iiiii');
//                else console.log('bbbb');
                totalDiscussion--;
//                console.log($(e.target).parents());
                console.log(btnParent);
//                btnParent.remove();
            });

        })


    </script>
@stop


