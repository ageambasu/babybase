@extends ('layout')

@section ('content')
	<form class="text-center" method="GET" action="{{ route('babies.index') }}">
		@csrf

		<div class="container">

			@foreach($fieldsOnDatabase as $key => $fieldOnDatabase)

				@php ($fieldName = $fieldsOnDatabase[$key][0])
				@php ($fieldNameOnForm = ucfirst(str_replace ("_", " ", $fieldName)))
				@php ($fieldType = $fieldsOnDatabase[$key][1])
				@php ($fieldValues = $fieldsOnDatabase[$key][2])
				@php ($fieldOnForm = $fieldsOnDatabase[$key][3])
				@php ($fieldRequiredOnForm = $fieldsOnDatabase[$key][4])
				@php ($fieldOnIndex = $fieldsOnDatabase[$key][5])
				@php ($fieldOnFilter = $fieldsOnDatabase[$key][6])
				
				@if ($fieldOnFilter)

					<div class="row">
						<div class="col-3"></div>
						<div class="col-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">{{ $fieldNameOnForm }}</span>
								</div>

								@switch($fieldType)

									@case('multiselect')
										<select class="custom-select form-control @error($fieldName) is-invalid @enderror" name="{{ $fieldName }}[]" multiple="multiple">

											@foreach($fieldValues as $key => $fieldValue)

												<option value="{{ $fieldValue }}">{{ $fieldValue }}</option>

											@endforeach

										</select>
									@break

									@default
										<select class="custom-select form-control @error($fieldName) is-invalid @enderror" name="{{ $fieldName }}">
											<option value=''>Filter by...</option>

													@foreach($allValueTypes as $key => $values)

														@if($key == $fieldName)

															@foreach($values as $value)

																<option value="{{ $value }}">{{ $value }}</option>

															@endforeach

														@endif

													@endforeach

										</select>
								
								@endswitch

								@error($fieldName)
									<div class="invalid-feedback">{{ $errors->first($fieldName) }}</div>
								@enderror
							</div>
						</div>
						<div class="col-3"></div>
					</div>

				@endif
				
			@endforeach

			@foreach($studyFieldsOnDatabase as $key => $fieldOnDatabase)

				@php ($fieldName = $studyFieldsOnDatabase[$key][0])
				@php ($fieldNameOnForm = ucfirst(str_replace ("_", " ", $fieldName)))
				@php ($fieldType = $studyFieldsOnDatabase[$key][1])
				@php ($fieldValues = $studyFieldsOnDatabase[$key][2])
				@php ($fieldOnForm = $studyFieldsOnDatabase[$key][3])
				@php ($fieldRequiredOnForm = $studyFieldsOnDatabase[$key][4])
				@php ($fieldOnIndex = $studyFieldsOnDatabase[$key][5])
				@php ($fieldOnFilter = $studyFieldsOnDatabase[$key][6])
				
				@if ($fieldOnFilter)

					<div class="row">
						<div class="col-3"></div>
						<div class="col-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">{{ $fieldNameOnForm }}</span>
								</div>

								<select class="custom-select form-control @error($fieldName) is-invalid @enderror" name="{{ $fieldName }}">
									<option value=''>Filter by...</option>

											@foreach($allValueTypes as $key => $values)

												@if($key == $fieldName)

													@foreach($values as $value)

														<option value="{{ $value }}">{{ $value }}</option>

													@endforeach

												@endif

											@endforeach

								</select>

								@error($fieldName)
									<div class="invalid-feedback">{{ $errors->first($fieldName) }}</div>
								@enderror
							</div>
						</div>
						<div class="col-3"></div>
					</div>

				@endif
				
			@endforeach

			<div class="row mt-4">
				<div class="col-3"></div>
				<div class="col-6">
					<button class="btn btn-lg btn-outline-primary btn-block" type="submit">Search</button>
				</div>
				<div class="col-3"></div>
			</div>
		</div>
	</form>
@endsection