@extends ('layout')

@section ('content')

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

		<br>

		<div class="row">
			<div class="col-3"></div>
			<div class="col-6">
				<h1 class="display-5 text-center">Assigned studies</h1>
			</div>
			<div class="col-3"></div>
		</div>

		@forelse ($baby->studies as $study)
			@for ($i = 0; $i < count($studyFieldsOnDatabase); $i++)

				@php ($studyFieldName = $studyFieldsOnDatabase[$i][0])
				@php ($studyFieldNameOnForm = ucfirst(str_replace ("_", " ", $studyFieldName)))
				@php ($studyFieldType = $studyFieldsOnDatabase[$i][1])
				@php ($studyFieldValues = $studyFieldsOnDatabase[$i][2])
				@php ($studyFieldOnForm = $studyFieldsOnDatabase[$i][3])
				@php ($studyFieldRequiredOnForm = $studyFieldsOnDatabase[$i][4])
				@php ($studyFieldOnIndex = $studyFieldsOnDatabase[$i][5])
				@php ($studyFieldOnFilter = $studyFieldsOnDatabase[$i][6])

				@if($studyFieldName == 'study_name')
					<div class="row">
						<div class="col-3"></div>
						<div class="col-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">{{ $studyFieldNameOnForm }}</span>
								</div>

								<input type="{{ $studyFieldType }}" class="form-control" name="{{ $studyFieldName }}" value="{{ $study->$studyFieldName }}" readonly>

								<a href="{{ route('studies.show', $study) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>

							</div>
						</div>
						<div class="col-3"></div>
					</div>
				@endif

			@endfor

		@empty
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">No assigned studies yet.</div>
				<div class="col-3"></div>
			</div>
		@endforelse


		<div class="row mt-4">
			<div class="col-3"></div>
			<div class="col-6">
				<a href="{{ route('babies.edit', $baby) }}" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-edit"></i> Edit</a>
			</div>
			<div class="col-3"></div>
		</div>
	</div>
@endsection
