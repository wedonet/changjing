
<?php
if(!isset($nav)){
    $nav = '';
}
?>

<div class="collapse dianji">
    <ul class="list-unstyled">
        @if(empty(session('pdgl')))
        <li class="<?php if('pd1'==$nav){echo ' hover';} ?>"><a  href=""></a>无频道</li>
        @else
        @foreach(session('pdgl') as $data)
            @if(isset($c_ic))
        <li  class="<?php if($data->ic == $c_ic){echo ' hover';} ?>"><a  href="/adminconsole/channelAdmin?c_ic={{$data->ic}}">{{$data->name}}</a></li>
            @else
                    <li  class="<?php if('pd1'==$nav){echo ' hover';} ?>"><a  href="/adminconsole/channelAdmin?c_ic={{$data->ic}}">{{$data->name}}</a></li>
            @endif
        @endforeach
            @endif

    </ul>
</div>

