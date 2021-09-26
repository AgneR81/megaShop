@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header">Atnaujinti</div>

            <div class="card-body">
               <form method="POST" action="{{route('category.update',$category)}}" enctype="multipart/form-data">
                  <div class="form-group">
                      <label>Augalo pavadinimas</label>
                      <input type="text" name="name" value="{{$category->title}}" class="form-control">
                      <small class="form-text text-muted">Augalo pavadinimas.</small>
                  </div>
                  <div class="form-group">
                      <label>Augalo pavadinimas</label>
                      <input type="text" name="name" value="{{$category->data_type}}" class="form-control">
                      <small class="form-text text-muted">Augalo pavadinimas.</small>
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
