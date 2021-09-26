@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header">Sukurti</div>

            <div class="card-body">
               <form method="POST" action="{{route('parameter.store')}}" >
                  <div class="form-group">
                      <label>Parametro pavadinimas</label>
                      <input type="text" name="title"  class="form-control">
                      <small class="form-text text-muted">Parametro pavadinimas.</small>
                  </div>
                  <div class="form-group">
                      <label>Matmuo</label>
                      <input type="text" name="data_type"  class="form-control" placeholder="kg,ml,cm...">
                      <small class="form-text text-muted">Matmens pavadinimas.</small>
                  </div>
                  @csrf
                  <button class="btn btn-success" type="submit">ADD</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
