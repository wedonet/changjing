



@if (Session::has('success'))

    <div class="alert alert-success messagePrompt">
       
        <strong>
            <i class="fa fa-check-circle fa-lg fa-fw">Success. </i> 
        </strong>

		<ul>
			<?php
				if(is_array(Session::get('success'))) {
					foreach (Session::get('success') as $v){
						echo '<li>'. $v .'</li>';
					}

				}else{
					echo '<li>'. Session::get('success') .'</li>';
				}
			?>	

		</ul>



    </div>
@endif