@foreach ($item->parameters as $param)
    {{$param->title}} {{$param->pivot->data}} {{$param->data_type}} <br>
@endforeach