    <h2>Appointment</h2>
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Baby</span>
          </div>
          <input class="form-control" value="{{ $appointment->baby->name }}" readonly>
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
            <span class="input-group-text">Date</span>
          </div>
          <input type="date" name="date" class="form-control" value="{{ $appointment->date }}" {{ $readonly?'readonly':'' }}>
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
          <input class="form-control" name="time" value="{{ $appointment->time }}" {{ $readonly?'readonly':'' }}>
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
          <input class="form-control" value="{{ $appointment->study->study_name }}" readonly>
        </div>
      </div>
      <div class="col-3"></div>
    </div>
