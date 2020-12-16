@extends ('layout')

@section ('content')

  <div class="container">
    <div class="row">
      <div class="col" >
        <div class="table-responsive" >
          <table class="table table-hover table-striped">
            <thead class="thead-light">
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Baby</th>
                <th scope="col">Appointment Number</th>
                <th scope="col">Study</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            @foreach ($appointments as $appointment)
              <tr>
                <td> {{ $appointment->date }} </td>
                <td> {{ $appointment->time }} </td>
                <td>
                  <a href="{{ route('babies.show', $appointment->baby) }}">
                  {{ $appointment->baby->name }}
                  </a>
                </td>
                <td> {{ $appointment->number }} </td>
                <td> {{ $appointment->study->study_name }} </td>
                <td> {{ $appointment->prettyStatus() }} </td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
