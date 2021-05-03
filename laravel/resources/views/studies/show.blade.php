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

                                                @if($fieldType == 'boolean')
                                                  <input class="form-control" name="{{ $fieldName }}" value="{{ $study->$fieldName?'Yes':'No' }}" readonly>
                                                @else
                                                  <input type="{{ $fieldType }}" class="form-control" name="{{ $fieldName }}" value="{{ $study->$fieldName }}" readonly>
                                                @endif

					</div>
				</div>
				<div class="col-3"></div>
			</div>

		@endfor

		<br>

		<div class="row">
			<div class="col-3"></div>
			<div class="col-6">
				<h1 class="display-5 text-center">Enrolled babies</h1>
			</div>
			<div class="col-3"></div>
		</div>

		@forelse ($study->babies as $baby)
			@for ($i = 0; $i < count($babyFieldsOnDatabase); $i++)

				@php ($babyFieldName = $babyFieldsOnDatabase[$i][0])
				@php ($babyFieldNameOnForm = ucfirst(str_replace ("_", " ", $babyFieldName)))
				@php ($babyFieldType = $babyFieldsOnDatabase[$i][1])
				@php ($babyFieldValues = $babyFieldsOnDatabase[$i][2])
				@php ($babyFieldOnForm = $babyFieldsOnDatabase[$i][3])
				@php ($babyFieldRequiredOnForm = $babyFieldsOnDatabase[$i][4])
				@php ($babyFieldOnIndex = $babyFieldsOnDatabase[$i][5])
				@php ($babyFieldOnFilter = $babyFieldsOnDatabase[$i][6])

				@if($babyFieldName == 'name')
					<div class="row">
						<div class="col-3"></div>
						<div class="col-6">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">{{ $babyFieldNameOnForm }}</span>
								</div>

								<input type="{{ $babyFieldType }}" class="form-control" name="{{ $babyFieldName }}" value="{{ $baby->$babyFieldName }}" readonly>

								<a href="{{ route('babies.show', $baby) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>

							</div>
						</div>
						<div class="col-3"></div>
					</div>
				@endif
				
			@endfor

		@empty
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">No enrolled babies yet.</div>
				<div class="col-3"></div>
			</div>
		@endforelse

		<div class="row mt-4">
			<div class="col-3"></div>
			<div class="col-6">
				<a href="{{ route('studies.edit', $study) }}" class="btn btn-lg btn-outline-info btn-block" role="button"><i class="far fa-edit"></i> Edit</a>
			</div>
			<div class="col-3"></div>
		</div>
	</div>
@endsection
