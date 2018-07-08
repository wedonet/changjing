{{-- Upload Modal --}}
<div class="modal fade" id="modal-info">
    <div class="modal-dialog" style='width:820px'>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">选择文件</h4>
            </div>
            <div class="modal-body">
                <div  id="upload">
                    <div class='ac'>
                        <input type="text" id="focus" class="focusbug" style="margin-left:3000px;" /> <!-- 解决ie focus bug -->
                        <input type="hidden" id="obj" value="{{ $obj }}" />
                        <input type="hidden" id="preid" value="{{ $preid }}" />
                        <input type="hidden" id="fromeditor" value="" />
                        <input type="hidden" id="ispre" value="{{ $ispre }}" />
                        <input type="hidden" id="CKEditorFuncNum" value="{{ $CKEditorFuncNum }}" />
                        <div class="tabup" id="tabup" >
                            <ul class="nav nav-tabs" role="tablist">
                                <li id="ftype1" role="presentation" class="active"><a href="#img" role="tab" data-toggle="tab">图片</a></li>
                                {{--<li id="ftype2" role="presentation"><a href="#flash" role="tab" data-toggle="tab">Flash</a></li>--}}
                                {{--<li id="ftype3" role="presentation"><a href="#enclosure" role="tab" data-toggle="tab">附件</a></li>--}}
                            </ul>
                            <div class='clear'></div>
                        </div>
                        <div class="fleft" style="width:140px;height:468px;">
                            <iframe name="frameclass" id="frameclass" src="/adminconsole/upload/class?ftype=1&amp;classid=0&amp;fic=" frameborder="0" scrolling="yes" width="100%" height="100%" ></iframe>
                        </div>
                        <div id="upcontent" class="fright" style="height:460px;">
                            <!--<iframe name="main" id="main" src="/_inc/upload/upload.php?act=list&amp;ftype={$ftype}&amp;funcnum={$funcnum}&amp;fromeditor={$fromeditor}" frameborder="0" scrolling="yes" width="100%" height="100%"></iframe>-->
                            <iframe name="main" id="main" src="/adminconsole/upload/list?fic=&t={{ time() }}" frameborder="0" scrolling="yes" width="100%" height="100%"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="" id="delaction">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">   
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>







