

@extends('layouts.app')

@section('content')
<div class="container">
@if(Auth::user()->isAdmin())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card"> 
                <div class="card-header">
                    Admino panele
                </div>
                <div class="card-body">
                    <form action="{{route('category.store')}}" method="post">
                        @csrf 
                        <input type="text" name="name" autocomplete="on">
                        @php
                            if(count($chain) == 0) {
                                $categoryId = 0;
                            }else{
                                $categoryId = $chain[count($chain) -1]->id;
                            }
                        @endphp
                        <input type="hidden" name="category_id" value="{{ $categoryId}}">
                        <button type="submit">prideti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
      <div class="card-header" >
                    @if (count($chain)==0)
                    HOME
                    @endif
                        @foreach ($chain as $item)
  
                            <a href="{{route('category.map',$item)}}"> {{$item->name}} ></a>
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
      </div>
    </div>
  </div>
</div>
@endsection