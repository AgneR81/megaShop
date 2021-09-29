@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header">Atnaujinti</div>

            <div class="card-body">
               <form method="POST" action="{{route('parameter.update',$parameter)}}" enctype="multipart/form-data">
                  <div class="form-group">
                      <label>Parametras</label>
                      <input type="text" name="name" value="{{$parameter->title}}" class="form-control">
                      <small class="form-text text-muted">Parametras</small>
                  </div>
                  <div class="form-group">
                      <label>Matavimo vienetai</label>
                      <input type="text" name="name" value="{{$parameter->data_type}}" class="form-control">
                      <small class="form-text text-muted">Matavimo vienetai</small>
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
