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
									<input type="{{ $fieldType }}" class="form-control" name="{{ $fieldName }}" value="{{ $baby->getBabyAgeAtAppointment() }}" readonly>
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
			</div>
	</div>
@endsection