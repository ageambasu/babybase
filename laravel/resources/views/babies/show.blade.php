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

				@php ($stuydFieldName = $studyFieldsOnDatabase[$i][0])
				@php ($stuydFieldNameOnForm = ucfirst(str_replace ("_", " ", $stuydFieldName)))
				@php ($stuydFieldType = $studyFieldsOnDatabase[$i][1])
				@php ($stuydFieldValues = $studyFieldsOnDatabase[$i][2])
				@php ($stuydFieldOnForm = $studyFieldsOnDatabase[$i][3])
				@php ($stuydFieldRequiredOnForm = $studyFieldsOnDatabase[$i][4])
				@php ($stuydFieldOnIndex = $studyFieldsOnDatabase[$i][5])
				@php ($stuydFieldOnFilter = $studyFieldsOnDatabase[$i][6])

				<div class="row">
					<div class="col-3"></div>
					<div class="col-6">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">{{ $stuydFieldNameOnForm }}</span>
							</div>

							<input type="{{ $stuydFieldType }}" class="form-control" name="{{ $stuydFieldName }}" value="{{ $study->$stuydFieldName }}" readonly>

						</div>
					</div>
					<div class="col-3"></div>
				</div>
				
			@endfor

			<br>
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