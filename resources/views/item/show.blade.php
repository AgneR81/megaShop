@extends('layouts.app')

@section('content')
<div id="showItem"></div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="javascript:history.back()">< Grįžti atgal</a></div>

                    @if(count($item->photos)>0)
                    <div class="container__photos">
                        <div class="photos__column">
                            <form name="form" action="" method="get">
                                <div class="text-center imgpadding">
                                    @foreach ($item->photos as $photo)
                                    <img class="rounded mx-auto d-block" src="{{asset("/images/items/small/".$item->photos[0]->name)}}" alt="">
                                    @endforeach
                                </div>    
                            </form>
                        </div>

                    </div>

                    @endif

                    @if(Auth::user() && Auth::user()->isAdmin())

                    <table class="table-striped">
                        <tr >
                            <td class=" text-right">
                                <a class="btn btn-primary" href="{{route('item.edit',[$item])}}">Atnaujinti preke</a>
                                <form style="display: inline-block" method="POST" action="{{route('item.destroy', $item)}}">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Istrinti preke is DB</button>
                                </form>    
                            </td>
                        </tr>    
                    </table>
                    @endif

                <div class="card-body">
                <table class="table">
                    <thead>
                        <a class="itemName">{{$item->name}}</a>
                        <tr>
                            <th scope="row">Kaina</th>
                            <th scope="row">{{$item->price}}€</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">Nuolaida</td>
                            <td scope="row">{{$item->discount}}%</td>
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
                            <td scope="row">Prekiu kiekis vnt.</td>
                            <td scope="row">{{$item->quantity}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Rodyti preke</td>
                            <td scope="row">
                            <input type="checkbox" name="{{($item->status==0)?"disabled":""}}" id=""> 
                            </td>
                        </tr>
                        
                        
                       
                    </tbody>
                    
                </table>

                    @if(Auth::user() && Auth::user()->isAdmin())

                    <form action="{{route('item.softDelete',$item)}}" method="post">
                             @csrf
                            @if ($item->status == 10)
                                 <button class="btn btn-primary" type="submit" name="softDelete" value=1 >disable</button>   
                            @else
                                <button class="btn btn-success" type="submit" name="softDelete" value=0 >enable</button>
                             @endif
                    </form>

                    @endif

                    <table>
                        <tbody>
                            <thead>
                                <tr>
                                    <p class="itemName">Parametrai</p>
                                </tr>
                                @foreach ($item->parameters as $parameter)
                                <tr>
                                    <td scope="row">{{$parameter->title}}</td>
                                    <td scope="row">{{$parameter->pivot->data}} {{$parameter->data_type}}</td>
                                </tr>
                        @endforeach
                            </thead>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="{{ asset('js/fromPublic.js') }}"></script> -->
@endsection