@extends ('layout')

@section ('content')
  <div class="container">
   @include('errors')
    <form action="{{ route('appointments.store') }}" method="post">
      @csrf
      @include('appointments.form', ['readonly' => false])
      <div class="row mt-4">
        <div class="col-3"></div>
        <div class="col-6">
          <button type="submit" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-check-circle"></i> Save</button>
          <a href="{{ route('home.index') }}" class="btn btn-lg btn-outline-danger btn-block" role="button"><i class="far fa-times-circle"></i> Cancel</a>
        </div>
        <div class="col-3"></div>
      </div>
    </form>
  </div>
@endsection
