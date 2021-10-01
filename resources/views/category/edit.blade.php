@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header">Atnaujinti kategorija</div>

            <div class="card-body">
               <form method="POST" action="{{route('category.update',$category)}}" enctype="multipart/form-data">
                  <div class="form-group">
                      <label>Kategorijos pavadinimas</label>
                      <input type="text" name="name" value="{{$category->name}}" class="form-control">
                      <small class="form-text text-muted">Kategorijos pavadinimas.</small>
                  </div>
                  <div class="form-group">
                     <label>Subkategorija</label>
                     <select class="custom-select" name="category_id">
                        
                        @foreach ($categories as $categoriesOne)
                            <option value="{{$categoriesOne->id}}">{{$categoriesOne->name}}</option>
                        @endforeach
                     </select>
                     {{-- <input type="text" name="name" value="{{$category->data_type}}" class="form-control"> --}}
                     <small class="form-text text-muted">Kategorijos pakeitimas</small>
                 </div>
                 <div class="form-group">
                    <label>Parametrai</label>
                    <select class="custom-select" name="parameters[]" multiple>
                       
                       @foreach ($parameters as $parameter)
                           <option value="{{$parameter->id}}">{{$parameter->title}} {{$parameter->data_type}}</option>
                       @endforeach
                    </select>
                    {{-- <input type="text" name="name" value="{{$category->data_type}}" class="form-control"> --}}
                    <small class="form-text text-muted">parametras</small>
                </div>
                  @csrf
                  <button class="btn btn-success" type="submit">EDIT</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection