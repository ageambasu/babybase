@extends ('layout')

@section ('content')
  <div class="container">
  @include('appointments.form', ['readonly' => true])
  @if ($appointment->editable())
    <div class="row mt-4">
      <div class="col-3"></div>
      <div class="col-6">
            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-edit"></i> Edit</a>
        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST">
          @csrf
          @method('DELETE')
          <button style="margin-top:7px;" class="btn btn-lg btn-outline-danger btn-block" role="button"><i class="far fa-times-circle"></i> Cancel Appointment</button>
        </form>
      </div>
      <div class="col-3"></div>
    </div>
  @endif
  </div>
@endsection
