@extends ('layout')

@section ('content')
  <style>
   .canceled {
       /* text-decoration:line-through; */
   }
  </style>
  <div class="container">

    @for ($i = 0; $i < count($fieldsOnDatabase); $i++)

      @php ($fieldName = $fieldsOnDatabase[$i][0])
      @php ($fieldNameOnForm = App\Baby::fieldName($fieldName))
      @php ($fieldType = $fieldsOnDatabase[$i][1])
      @php ($fieldValues = $fieldsOnDatabase[$i][2])
      @php ($fieldOnForm = $fieldsOnDatabase[$i][3])
      @php ($fieldRequiredOnForm = $fieldsOnDatabase[$i][4])
      @php ($fieldOnIndex = $fieldsOnDatabase[$i][5])
      @php ($fieldOnFilter = $fieldsOnDatabase[$i][6])

      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">{{ $fieldNameOnForm }}</span>
            </div>

            @if($fieldType == 'boolean')
              <input class="form-control" name="{{ $fieldName }}" value="{{ $baby->$fieldName?'Yes':'No' }}" readonly>
            @elseif($fieldType == 'date')
              <input class="datepicker form-control @error($fieldName) is-invalid @enderror" name="{{ $fieldName }}" {{ (($fieldRequiredOnForm) ? "required":"") }} value="{{ $baby->$fieldName->format('d/m/Y') }}" readonly>
            @else
              @switch($fieldName)
                @case('age_today')
                  <input type="{{ $fieldType }}" class="form-control" name="{{ $fieldName }}" value="{{ $baby->getBabyAgeToday() }}" readonly>
                                @break

                  @case('other_languages')
                    <select class="custom-select form-control" multiple="multiple" readonly>
                      @foreach ($baby->languages as $lang)
                        <option value="{{$lang->id}}">{{ $lang->name }}</option>
                      @endforeach
                    </select>
                                    @break
                    @case('notes')
                      <textarea class="form-control" readonly>{{ $baby->notes }}</textarea>
                      @break
                    @default
                    <input type="{{ $fieldType }}" class="form-control" name="{{ $fieldName }}" value="{{ $baby->$fieldName }}" readonly>
              @endswitch
            @endif

          </div>
        </div>
        <div class="col-3"></div>
      </div>

    @endfor
    <div class="row mt-4">
      <div class="col-3"></div>
      <div class="col-6">
        <a href="{{ route('babies.edit', $baby) }}" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-edit"></i> Edit</a>
      </div>
      <div class="col-3"></div>
      @if (!$baby->approved)
        <div class="col-3"></div>
        <div class="col-6">
          <form action="{{ route('signups.approve', $baby) }}" method="post">
            @method('PUT')
            @csrf
            <button type="submit" style="margin-top:7px" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-check-circle"></i> Approve Signup</button>
          </form>
        </div>
        <div class="col-3"></div>
      @endif
    </div>

    <br>
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <h1 class="display-5 text-center">History</h1>
      </div>
      <div class="col-3"></div>
    </div>
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        @if (count($baby->appointments) > 0)
          <table class="table table-striped">
            <tr>
              <th>Study</th>
              <th>Date/Time</th>
              <th>Status</th>
              <th></th>
            </tr>
            @foreach ($baby->appointments->sortBy('date') as $appointment)
              <tr>
                <td>{{ $appointment->study->study_name }}</td>
                <td><span class="{{ $appointment->canceled()?'canceled':'' }}">{{ $appointment->prettyDateTime() }}</span></td>
                <td>{{ $appointment->prettyStatus() }}</td>
                @if ($appointment->editable())
                  <td><a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> Edit</a></td>
                @else
                  <td> </td>
                @endif
              </tr>
            @endforeach
          </table>
        @else
          No appointments yet.
        @endif
      </div>
      <div class="col-3"></div>
    </div>
    <div class="row mt-4">
      <div class="col-3"></div>
      <div class="col-6">
        <a href="{{ route('appointments.contacted', $baby) }}" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="fas fa-plus-circle"></i> Log contact</a>
        <a href="{{ route('appointments.create', $baby) }}" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="fas fa-plus-circle"></i> Schedule appointment</a>
      </div>
      <div class="col-3"></div>
    </div>
    <div class="row mt-3">
      <div class="col-3"></div>
      <div class="col-6">
        <h1 class="display-5 text-center">Related babies</h1>
      </div>
      <div class="col-3"></div>
    </div>
    @foreach ($baby->related as $b)
      <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">Name</span>
            </div>

            <input type="text" class="form-control" name="name" value="{{ $b->name }}" readonly>
            <a href="{{ route('babies.show', $b) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>
          </div>
        </div>
        <div class="col-3"></div>
      </div>
    @endforeach
  </div>
@endsection
