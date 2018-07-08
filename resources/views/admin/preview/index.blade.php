
 Upload Modal
<div class="modal fade" id="modal-info">
    <div class="modal-dialog" style='width:95%;'>
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h1 class="modal-title">预览</h1>
            </div>
            <div class="modal-body">
                <div  id="upload" >
                    <div class='ac'>

                        <div id="upcontent" >
                            {{--<iframe name="" id="iframeId"  src="/" width="100%"  frameborder="0" scrolling="no" onload="getHeight(this)"></iframe>--}}
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="/{{$route}}" ></iframe>
                                {{--{{$route}}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="" id="delaction">
					{!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        取消
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>







