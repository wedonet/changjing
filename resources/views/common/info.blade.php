{{-- resources/views/common/errors.blade.php --}}

@if (count($errors) > 0)
<!-- Form Error List -->
<div class="alert alert-warning messagePrompt" >
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif



@if (Session::has('sucinfo'))

    <div class="success alert-success messagePrompt">
       
        <strong>
            <i class="fa fa-check-circle fa-lg fa-fw">Ok!</i> 
        </strong>

		<ul>
			<?php
				if(is_array(Session::get('sucinfo'))) {
					foreach (Session::get('sucinfo') as $v){
						echo '<li>'. $v .'</li>';
					}

				}else{
					echo '<li>'. Session::get('sucinfo') .'</li>';
				}
			?>	

		</ul>



    </div>
@endif


@if (Session::has('location'))

    <script type="text/javascript">
    <!--
		var locatoin = '{{session("location")}}';
		setTimeout(function()
						{									
								window.location.href=locatoin;
						}, 2000);					
		
    //-->
    </script>
@endif