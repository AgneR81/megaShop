@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Atnaujinti prekę</div>
                <div class="card-body">
                    <form method="POST" action="{{route('item.update',[$item])}}">
                    <div class="form-group">
                        <label>Prekes pavadinimas</label>
                        <input type="text" name="name" value="{{$item->name}}" class="form-control"><br>
                        <label>Gamintojas</label>
                        <input type="text" name="manufacturer" value="{{$item->manufacturer}}" class="form-control"><br>
                        <label>Kaina</label>
                        <input type="text" name="price" value="{{$item->price}}" class="form-control"><br>
                        <label>Aprašymas</label>
                        <input type="text" name="description" value="{{$item->description}}" class="form-control"><br>
                        <label>Kiekis</label>
                        <input type="text" name="quantity" value="{{$item->quantity}}" class="form-control"><br>
                        <label>Nuolaida</label>
                        <input type="text" name="discount" value="{{$item->discount}}" class="form-control"><br>
                        <input type="hidden" name="item_id" value="{{$item->id}}">
                        <input type="hidden" name="category_id" value="{{$category->id}}">
                        @foreach ($item->parameters as $parameter)
                            <label>{{$parameter->title}} ({{$parameter->data_type}})</label>
                            <input type="text" name="{{$parameter->id}}" value="{{$parameter->pivot->data}}" class="form-control"><br>
                        @endforeach
                        <div>
                            <label>Nuotraukos</label>
                            <br>
                            <input type="file" name="photos[]" multiple>
                            <br>
                            <small class="form-text text-muted">Pasirinkite prekės nuotraukas</small>
                        </div>

                    </div>
                        @csrf
                        <br>
                        <button class="btn btn-success" type="submit">Atnaujinti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection