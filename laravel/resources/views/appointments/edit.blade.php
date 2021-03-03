@extends ('layout')

@section ('content')
  <div class="container">
    @include('errors')
    <form action="{{ route('appointments.update', $appointment) }}" method="post">
      @method('PUT')
      @csrf
      @include('appointments.form', ['readonly' => false])
      <div class="row mt-4">
        <div class="col-3"></div>
        <div class="col-6">
          <button type="submit" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-check-circle"></i> Save</button>
        </div>
        <div class="col-3"></div>
      </div>
    </form>
    <div class="row mt-4">
      <div class="col-3"></div>
      <div class="col-6">
        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST">
          @csrf
          @method('DELETE')
          <button style="margin-top:7px;" class="btn btn-lg btn-outline-danger btn-block" role="button"><i class="far fa-times-circle"></i> Cancel Appointment</button>
        </form>
      </div>
      <div class="col-3"></div>
    </div>
@endsection
