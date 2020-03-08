@extends ('layout')

@section ('content')
	<form class="text-center" method="POST" action="{{ route('studies.show', $study) }}">
		@csrf
		@method('PUT')
		
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
				
				@if ($fieldOnForm)

					<div class="row">
						<div class="col-3"></div>
						<div class="col-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">{{ $fieldNameOnForm }}</span>
								</div>

								@switch($fieldType)

									@case('select')
										<select class="custom-select form-control @error($fieldName) is-invalid @enderror" {{ (($fieldRequiredOnForm) ? "required":"") }} name="{{ $fieldName }}">
											<option value=''>Choose...</option>

											@foreach($fieldValues as $key => $fieldValue)

												<option value="{{ $fieldValue }}" {{ (($study->$fieldName) == $fieldValue ? "selected":"") }}>{{ $fieldValue }}</option>

											@endforeach

										</select>
									@break

									@default
										<input type="{{ $fieldType }}" class="form-control @error($fieldName) is-invalid @enderror" name="{{ $fieldName }}" {{ (($fieldRequiredOnForm) ? "required":"") }} value="{{ $study->$fieldName }}">
								
								@endswitch

								@error($fieldName)
									<div class="invalid-feedback">{{ $errors->first($fieldName) }}</div>
								@enderror
							</div>
						</div>
						<div class="col-3"></div>
					</div>

				@endif
				
			@endfor

			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Babies</span>
						</div>

						<select multiple class="custom-select form-control @error('babies') is-invalid @enderror" name="babies[]">

							@foreach($babies as $baby)
									
									@if( in_array( $baby->id, $babyStudiesIds ) )
										<option value="{{ $baby->id }}" selected>{{ $baby->name }}, {{ $baby->email }}</option>
									@else
										<option value="{{ $baby->id }}">{{ $baby->name }}, {{ $baby->email }}</option>
									@endif

							@endforeach

						</select>

						@error('babies')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror

					</div>
				</div>
				<div class="col-3"></div>
			</div>

			<div class="row mt-4">
				<div class="col-3"></div>
				<div class="col-6">
					<button class="btn btn-lg btn-outline-primary btn-block" type="submit">Submit</button>
				</div>
				<div class="col-3"></div>
			</div>
		</div>
	</form>
@endsection