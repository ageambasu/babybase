@extends ('layout')

@section ('content')
  <div class="container">
  @include('appointments.form', ['readonly' => true])
    <div class="row mt-4">
      <div class="col-3"></div>
      <div class="col-6">
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-edit"></i> Edit</a>
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-lg btn-outline-danger btn-block" role="button"><i class="far fa-times-circle"></i> Cancel Appointment</a>
      </div>
      <div class="col-3"></div>
    </div>
  </div>
@endsection
