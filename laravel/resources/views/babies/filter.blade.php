@extends ('layout')

@section ('content')
	<form name="filter-baby" class="text-center" method="GET" action="{{ route('babies.index') }}">
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
                                                                  @case('text')
                                                                    <input class="form-control" name="{{ $fieldName }}" />
                                                                  @break

									@case('multiselect')
                                                                                @if ($fieldName == 'other_languages')
                                                                                  <select class="custom-select form-control" name="languages[]" multiple="multiple">
                                                                                  @foreach($all_languages as $lang)
                                                                                    <option value="{{$lang->name}}">{{ $lang->name }}</option>
                                                                                  @endforeach
                                                                                @endif
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
                                                                        @if($fieldName == 'older_than' || $fieldName == 'younger_than')
                                                                          <div class="input-group-append">
                                                                            <span class="input-group-text">months</span>
                                                                          </div>
                                                                        @endif

							</div>
						</div>
						<div class="col-3"></div>
					</div>

				@endif

			@endforeach

                        <div class="row">
                          <div class="col-3"></div>
                          <div class="col-6">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">Study</span>
                              </div>
                              <select class="form-control" name="study">
                                <option value="" selected>Filter by...</option>
                                @foreach ($all_studies as $study)
                                  <option value="{{ $study->id }}">{{ $study->study_name }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-3"></div>
                        </div>

			<div class="row mt-4">
				<div class="col-3"></div>
				<div class="col-6">
					<button class="btn btn-lg btn-outline-primary btn-block" type="submit">Search</button>
				</div>
				<div class="col-3"></div>
			</div>
		</div>
	</form>
        <script type="text/javascript">
         $(function() {
             $(document.forms['filter-baby']['languages[]']).select2({tags:true});
         });
        </script>
@endsection
