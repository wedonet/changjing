

@if (count($errors) > 0)
<!-- Form Error List -->
<div class="alarm alert-warning messagePrompt" >
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
				if(is_array(Session::get('success'))) {
					foreach (Session::get('success') as $v){
						echo '<li>'. $v .'</li>';
					}

				}else{
					echo '<li>'. Session::get('sucinfo') .'</li>';
				}
			?>	

		</ul>



    </div>
@endif