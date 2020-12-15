@extends ('layout')

@section ('content')
  <div class="container">
    <form action="{{ route('appointments.update', $appointment) }}" method="post">
      @method('PUT')
      @csrf
      @include('appointments.form', ['readonly' => false])
      <div class="row mt-4">
        <div class="col-3"></div>
        <div class="col-6">
          <button type="submit" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-check-circle"></i> Save</button>
          <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-lg btn-outline-danger btn-block" role="button"><i class="far fa-times-circle"></i> Cancel Appointment</a>
        </div>
        <div class="col-3"></div>
      </div>
    </form>
  </div>
@endsection
