
{{-- resources/views/common/errors.blade.php --}}


@if (count($errors) > 0)
    <!-- Form Error List -->
        <div class="alert alert-danger messagePromptLogin" >
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
@endif
<?php
        $_SESSION['error']='';


