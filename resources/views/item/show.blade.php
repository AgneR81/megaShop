@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="javascript:history.back()">< Grįžti atgal</a></div>
                <div class="card-body">
                <table class="table">
                    <thead>
                        <a style="font-size:30px;font-weight:500; font-family:Montserat Bold;">{{$item->name}}</a>
                        <tr>
                            <th scope="row">Kaina</th>
                            <th scope="row">{{$item->price}}€</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">Nuolaida</td>
                            <td scope="row">{{$item->discount}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Kaina po nuolaidos</td>
                            <td scope="row">{{$item->discountPrice()}}€</td>
                        </tr>
                        <tr>
                            <td scope="row">Gamintojas</td>
                            <td scope="row">{{$item->manufacturer}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Aprašymas</td>
                            <td scope="row">{{$item->description}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Rodyti preke</td>
                            <td scope="row">
                            <input type="checkbox" name="{{($item->status==0)?"disabled":""}}" id=""> 
                            </td>
                        </tr>
                        @foreach ($item->parameters as $parameter)
                            <tr>
                                <td scope="row">{{$parameter->title}}</td>
                                <td scope="row">{{$parameter->pivot->data}} {{$parameter->data_type}}</td>
                            </tr>
                        @endforeach
                       
                    </tbody>
                    
                </table>
                    <form action="{{route('item.softDelete',$item)}}" method="post">
                             @csrf
                            @if ($item->status == 10)
                                 <button class="btn btn-primary" type="submit" name="softDelete" value=1 >disable</button>   
                            @else
                                <button class="btn btn-success" type="submit" name="softDelete" value=0 >enable</button>
                             @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection