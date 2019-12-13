@extends ('layout')

@section ('content')
	<div class="container">	
		<div class="row">
			<div class="col">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead class="thead-light">
							<tr>
								<th scope="col">#</th>

								@for ($i = 0; $i < count($fieldsOnDatabase); $i++)

									@php ($fieldName = $fieldsOnDatabase[$i][0])
									@php ($fieldNameOnForm = ucfirst(str_replace ("_", " ", $fieldName)))
									@php ($fieldOnIndex = $fieldsOnDatabase[$i][5])
									
									@if ($fieldOnIndex)
										<th scope="col">{{ $fieldNameOnForm }}</th>
									@endif

								@endfor

								<th scope="col">Actions</th>
							</tr>
						</thead>
						
						<tbody>
							@foreach ($babies as $baby)
								<tr>
									<th scope="row">{{ $baby->id }}</th>
									
									@for ($i = 0; $i < count($fieldsOnDatabase); $i++)

										@php ($fieldName = $fieldsOnDatabase[$i][0])
										@php ($fieldNameOnForm = ucfirst(str_replace ("_", " ", $fieldName)))
										@php ($fieldOnIndex = $fieldsOnDatabase[$i][5])
										
										@if ($fieldOnIndex)
											
											@switch($fieldName)
												@case('age_today')
													<td>{{ $baby->getBabyAgeToday() }}</td>
												@break

												@default
													<td>{{ $baby->$fieldName }}</td>
											@endswitch

										@endif

									@endfor

									<td>
										<a href="{{ route('babies.show', $baby) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>
										<a href="{{ route('babies.edit', $baby) }}" class="btn btn-outline-info" role="button"><i class="far fa-edit"></i> Edit</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<div class="custom-pagination mb-4 d-flex justify-content-center">
					{{ $babies->links() }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<a href="/babies/create" class="btn btn-outline-info" role="button">
					<i class="fas fa-plus-circle"></i> Create a new record
				</a>
			</div>
		</div>
	</div>
@endsection