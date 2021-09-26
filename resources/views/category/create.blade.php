<form style="display: inline-block" action="{{route('category.store')}}" method="post">
    @csrf
    <input class="form-control" type="text" name="name">   

    <select class="custom-select" name="parameters[]" multiple>
                       
        @foreach ($parameters as $parameter)
            <option value="{{$parameter->id}}">{{$parameter->title}} {{$parameter->data_type}}</option>
        @endforeach
    </select>

    <input type="hidden" name="category_id" value="{{$categoryId}}">
   <button class="btn btn-primary" type="submit">pridėti</button>
</form>