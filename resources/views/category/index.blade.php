

@extends('layouts.app')

@section('content')
<div class="container">
@if(Auth::user() && Auth::user()->isAdmin()) 
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
            <form class="d-flex">
              <div class="dropdown">
                
                <div id="myDropdown" class="dropdown-content show">
                    <input class="form-control me-2" type="search" placeholder="Search.." id="searchBar" autocomplete="off">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                    <div id="lines"></div>
                </div>
              </div>
          </form>

            

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
            @if( (!Auth::user() && $item->status==0) ||
            (Auth::user() && !Auth::user()->isAdministrator() && $item->status==0) )
              @continue
            @endif  
              <!-- <a href="##sis_varijantas_disablina_ir_kortele"  class="{{($item->status==0)?"avoid-clicks":""}}"> -->
                <a href="{{route('item.show', ( ( (  ( (  ($item->id*3)  +6)  *3)  +7) *13) +6)* 124) }}">
                <div class="Item {{   ($item->status==0)? " bg-red " :( ($item->quantity==0)?" inactive ":"" )   }}" >
                  <div style="text-align:center;">{{$item->name}}</div>
                  <div style=" margin-left:25px; width: 230px; height:230px; position: relative;">
                    @if(count($item->photos) > 0)
                        <img  style="max-height:230px; max-width:100%; position:absolute"  src="{{asset("/images/items/small/".$item->photos[0]->name)}}" alt="">
                    @else
                        <img style="max-height:230px; max-width:200px; position:absolute"  src="{{asset("/images/icons/defaultPlaceholder.png")}}" >
                   @endif 
                  </div>

                @if($item->discount > 0)        
                  <div style="margin-left:25px; text-decoration:line-through; text-decoration-thickness: 2px; font-weight:900; font-size:18px; position:relative">{{$item->price}}€
                    <div class="discount" style="position:absolute; padding: 0 7px;  background-color:#868B8E; border-radius: 20px; color:yellow;  transform: rotate(-12deg); font-size:25px; bottom:35px; right:20px;">{{$item->discountPrice()}}€</div>
                  @else
                  <div style="margin-left:25px; font-weight:900; font-size:18px; position:relative">{{$item->price}}€
                @endif
                  </div>

                  <div style="margin-left:25px;" >Gamintojas: {{$item->manufacturer}}</div>
                  <div style="margin-left:25px;" >Prekės likutis: {{$item->quantity}}</div>
                  <object><a style="margin-left:80px;"  {{($item->status==0)?"avoid-clicks":""}}  class="btn btn-outline-secondary" href="">Į krepšelį</a> </object>
                  <!-- <button style="margin-left:80px; z-index:99" class="btn btn-outline-secondary">Į krepšelį</button>  -->
                  <div class="heart"></div>
                </div>
              </a>  
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
<script>

  let urlSearchBar = "{{route('item.searchBar')}}";

</script>