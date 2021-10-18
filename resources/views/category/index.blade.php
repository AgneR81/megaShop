

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
                tik akcijinės prekės <input type="checkbox" name="" id="discount">
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
                @if(Auth::user() && Auth::user()->isAdmin()) 
                <td class="align-middle text-center">
                  <a class="btn btn-primary" href="{{route('category.edit',[$category])}}">EDIT</a>
                  <form style="display: inline-block" method="POST" action="{{route('category.destroy', $category)}}">
                    @csrf
                    <button class="btn btn-danger" type="submit">DELETE</button>
                  </form>
                </td>
                @endif
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>

        <div id=houseOfCards class="card-body">
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
              
              {!!$item->card()!!}
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
  let itemShow = "{{route('item.show',1)}}"; 
  var url = '{{ URL::asset('/images/') }}';
  // var heart =  "{{route('item.heart')}}";
  // var url = '{{public_path()."\\images\\"}}';
  // var url = './images/';
</script>
