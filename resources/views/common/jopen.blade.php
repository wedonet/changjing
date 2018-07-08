<!-- Form Error List -->
<div class="alert alert-warning messagePrompt" >
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>