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


@if ('' != session('sucinfo'))
<!-- Form Error List -->
<div class="alert alert-success messagePrompt" >
	{{session('sucinfo')}}
</div>
@endif
<?php
$_SESSION['error'] = '';