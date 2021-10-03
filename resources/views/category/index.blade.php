

@extends('layouts.app')

@section('content')
<div class="container">
@if(Auth::user()->isAdmin())
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card"> 
                <div class="card-header">
                    Admino panele
                </div>
                <div class="card-body">
                @if ((count($chain) > 0))
                    
                    <a style="font-size:20px" style="font-family: Montserat Bold" href="{{route('item.create',[ $chain[count($chain)-1] ] )}}">Įdėti prekę į "{{$chain[count($chain)-1]->name}}" kategoriją</a><br>
                    <?php $category =  $chain[count($chain)-1] ; ?>
                        
                    @else
                    <?php $category =  0; ?>
                    @endif
                    <a style="font-size:20px" href="{{route('category.create',[ $category ] )}}">sukurti kategoriją šiame gylyje</a> 

                </div>
            </div>
        </div>
    </div>
    @endif
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
      <div class="card-header" >
        <h1 style="font-family: Montserat Bold">{{(count($chain) > 0)?$chain[count($chain)-1]->name :""}}</h1>
        </div>
        <div class="card-header" >
                    @if (count($chain)==0)
                    HOME
                    @endif
                        @foreach ($chain as $item)
  
                            
                            @if(next($chain))
                            <a class="chain" href="{{route('category.map',$item)}}"> {{$item->name}} ></a>
                            @else
                            <a class="chain chain-last" href="{{route('category.map',$item)}}"> {{$item->name}} </a>
                            @endif
                        @endforeach
        </div>
          <div class="card-body">
            <table class="table table-striped">
            <tbody>  
              
            
            
              @foreach ($categories as $category)
              <tr>
                <td><a href="{{route('category.map',$category)}}"> {{$category->name}} </a></td>
              
                <td class="align-middle text-center">
                  <a class="btn btn-primary" href="{{route('category.edit',[$category])}}">EDIT</a>
                  <form style="display: inline-block" method="POST" action="{{route('category.destroy', $category)}}">
                    @csrf
                    <button class="btn btn-danger" type="submit">DELETE</button>
                  </form>
                </td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>

        <div class="card-body">
        @if(isset($items))
            <!-- <table class="table table-striped"> -->
               <!-- <tbody>
                  <tr>
                    <th>pavadinimas</th>
                    <th class="text-center">kaina</th>
                    <th class="text-center">valdymas</th>
                  </tr>   -->


                    <!--1!!!!! KORTELIU ATVAIZDAVIMAS  !!!!!!!-->
              
              @foreach ($items as $item)
              <div class="Item" style="background-color: #E7D2CC; width: 250px; height: 350px; margin: 5px 5px; display: inline-block;">
              <div style="text-align:center;">{{$item->name}}</div>
              <div style="border: solid grey 1px; margin-left:25px; width: 200px; height:200px">
              @if(count($item->photos) > 0)
              <img  style="max-height:230px; max-width:198px;"  src="{{asset("/images/items/small/".$item->photos[0]->name)}}" alt="">
              @else
              <img style="max-height:230px; max-width:198px;"  src="{{asset("/images/icons/defaultPlaceholder.png")}}" >
              @endif 
            </div>
                      
              <div style="margin-left:25px; font-weight:900; font-size:18px; position:relative">{{$item->price}}€</div>
              <div style="margin-left:25px;" >Gamintojas: {{$item->manufacturer}}</div>
              <div style="margin-left:25px;" >Prekės likutis: {{$item->quantity}}</div>
              <button style="margin-left:80px; z-index:99" class="btn btn-outline-secondary">Į krepšelį</button> 
            </div>
              <!-- <tr>
               <td>{{$item->name}}</td>
               <td>{{$item->price}}</td>
              {{-- <td class=""> <a href="{{route('item.map',$item)}}"> {{$item->name}}</a></td> --}}
              {{-- <td class="align-middle text-center">{{$parameter->data_type}}</td> --}}
                <td class="align-middle text-center">
                  <a class="btn btn-outline-primary" href="{{route('item.show',[$item])}}">SHOW</a>
                  <a class="btn btn-primary" href="{{route('item.edit',[$item])}}">EDIT</a>
                  <form style="display: inline-block" method="POST" action="{{route('item.destroy', $item)}}">
                    @csrf
                    <button class="btn btn-danger" type="submit">DELETE</button>
                  </form>
                </td>
            </tr> -->
            @endforeach
            @endif
            <!-- </tbody>
          </table> -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection