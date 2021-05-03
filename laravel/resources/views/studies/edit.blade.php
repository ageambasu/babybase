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
          @if ($fieldName == 'study_age_range_start')
            @php ($fieldNameOnForm = 'Age range start (days)')
          @elseif ($fieldName == 'study_age_range_end')
            @php ($fieldNameOnForm = 'Age range end (days)')
          @endif
	  <div class="row">
	    <div class="col-3"></div>
	    <div class="col-6">
	      <div class="input-group mb-3">
		<div class="input-group-prepend">
		  <span class="input-group-text">{{ $fieldNameOnForm }}</span>
		</div>

		@switch($fieldType)

                    @case('boolean')
                      <select class="custom-select form-control @error($fieldName) is-invalid @enderror" {{ (($fieldRequiredOnForm) ? "required":"") }} name="{{ $fieldName }}">
                        <option value=''>Choose...</option>
                        <option value="0" {{ !$study->$fieldName?"selected":"" }}>No</option>
                        <option value="1" {{ $study->$fieldName?"selected":"" }}>Yes</option>

                      </select>
                                        @break
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
