@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">Augalai</div>

        <div class="card-body">
        <table class="table table-striped">
            <thead>
            <tr>
              <th class="align-middle text-center">pavadinimas</th>
              <th class="align-middle text-center">matmens vienetas</th>
              <th class="align-middle text-center">actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($parameters as $parameter)
            <tr>
              <td class="align-middle text-center">{{$parameter->title}}</td>
              <td class="align-middle text-center">{{$parameter->data_type}}</td>
              <td class="align-middle text-center">
                <a class="btn btn-primary" href="{{route('parameter.edit',[$parameter])}}">EDIT</a>
                <form style="display: inline-block" method="POST" action="{{route('parameter.destroy', $parameter)}}">
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