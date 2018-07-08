{{-- ajaxerr Modal 错误提示框 --}}
<div class="modal fade" id="modal-info" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">{{ $title }}</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                <ul>

                    @foreach($info as $v)
                    <li>{!! $v !!}</li>
                    @endforeach

                </ul>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">
                    关闭
                </button>
            </div>
        </div>
    </div>
</div>



@if(isset($href))
	@if('reload' == $href)
		<script type="text/javascript">
		<!--
			$(document).ready(function () {
	

				mytimeout = setTimeout(function () {
				   window.location.reload();
				}, {{$mytimeout}})           

			})
		//-->
		</script>
	@else
		<script type="text/javascript">
		<!--
			$(document).ready(function () {

				mytimeout = setTimeout(function () {
				   window.location.href = '{{$href}}';
				}, {{$mytimeout}})            

			})
		//-->
		</script>
	@endif

@endif

