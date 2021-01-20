@extends ('layout')

@section ('content')
  <style>
   .canceled {
       text-decoration:line-through;
   }
  </style>
	<div class="container">

		@for ($i = 0; $i < count($fieldsOnDatabase); $i++)

			@php ($fieldName = $fieldsOnDatabase[$i][0])
			@php ($fieldNameOnForm = ucfirst(str_replace ("_", " ", $fieldName)))
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

						@switch($fieldName)
							@case('age_today')
								<input type="{{ $fieldType }}" class="form-control" name="{{ $fieldName }}" value="{{ $baby->getBabyAgeToday() }}" readonly>
							@break

							@case('age_at_appointment')
								@if($baby->appointment_date)
									<input type="{{ $fieldType }}" class="form-control" name="{{ $fieldName }}" value="{{ $baby->getBabyAgeAtAppointment() }}" readonly>
								@endif
							@break

                                                        @case('other_languages')
                                                          <select class="custom-select form-control" multiple="multiple" readonly>
                                                          @foreach ($baby->languages as $lang)
                                                            <option value="{{$lang->id}}">{{ $lang->name }}</option>
                                                          @endforeach
                                                          </select>
                                                        @break
                                                        @default
                                                                <input type="{{ $fieldType }}" class="form-control" name="{{ $fieldName }}" value="{{ $baby->$fieldName }}" readonly>
						@endswitch

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
                    <h1 class="display-5 text-center">Appointments</h1>
                  </div>
                  <div class="col-3"></div>
                </div>
                @forelse ($baby->appointments as $appointment)
                  <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">{{ $appointment->study->study_name }}</span>
                        </div>

                        <span class="{{ $appointment->canceled()?'canceled':'' }} form-control">{{ $appointment->prettyDateTime() }}</span>
                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>

                      </div>
                    </div>
                    <div class="col-3"></div>
                  </div>
		@empty
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">No appointments yet.</div>
				<div class="col-3"></div>
			</div>
                @endforelse
                <div class="row mt-4">
			<div class="col-3"></div>
			<div class="col-6">
				<a href="{{ route('appointments.create', $baby) }}" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="fas fa-plus-circle"></i> Add appointment</a>
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
