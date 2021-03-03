    <h2>Appointment</h2>
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Baby</span>
          </div>
          <input class="form-control" value="{{ $appointment->baby->name }}" readonly>
          <input name="baby" type="hidden" value="{{ $appointment->baby->id }}">
          <a href="{{ route('babies.show', $appointment->baby) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>
        </div>
      </div>
      <div class="col-3"></div>
    </div>
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Study</span>
          </div>
          @if ($appointment->study)
            <input class="form-control" value="{{ $appointment->study->study_name }}" readonly>
          @else
            <select class="form-control" name="study">
            @foreach ($all_studies as $study)
              <option value="{{ $study->id }}">{{ $study->study_name }}</option>
            @endforeach
            </select>
          @endif
        </div>
      </div>
      <div class="col-3"></div>
    </div>
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Date</span>
          </div>
          <input class="datepicker form-control @error("date") is-invalid @enderror" name="date" required value="{{ $appointment->date?$appointment->date->format('d/m/Y'):\Carbon\Carbon::now()->format("d/m/Y") }}"
                 data-date-today-btn="linked" data-default-view-date="0"
          {{ $readonly?'readonly':'data-provide=datepicker' }}>
        </div>
      </div>
      <div class="col-3"></div>
    </div>
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Time</span>
          </div>
          <input type="time" class="form-control" name="time" value="{{ date('H:i', strtotime($appointment->time)) }}" {{ $readonly?'readonly':'' }} required>
        </div>
      </div>
      <div class="col-3"></div>
    </div>
    @if ($appointment->id)
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Status</span>
          </div>
          @if (!$appointment->editable() || $readonly)
            <input class="form-control" value="{{ $appointment->prettyStatus() }}" readonly>
          @else
            <select class="form-control" name="status">
            @foreach (constant('App\Appointment::Status') as $key=>$value)
              <option value="{{ $key }}" {{ $key==$appointment->status?'selected':'' }}>{{ $value }}</option>
            @endforeach
            </select>
          @endif
        </div>
      </div>
      <div class="col-3"></div>
    </div>
    @elseif ($appointment->status !== null)
    <input type="hidden"  name="status" value="{{ $appointment->status }}">
    @endif
