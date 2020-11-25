@extends ('layout')

@section ('content')
	<div class="container">
          @if ($activeFilters)
          <div class="row">
            <div class="col">Showing only:
              @foreach($activeFilters as $k => $v)
                <span class="badge badge-pill badge-secondary">{{ ucfirst(str_replace("_", " ", $k)) }}: {{ $v }}</span>
              @endforeach
            </div>
          </div>
          <hr/>
          @endif
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

										@if ($fieldName == 'age_today')
											<th scope="col">
												<a href="{{ route('babies.index', array_merge(Request::all(), ['sortColumn' => 'dob', 'sortOrder' => 'DESC'])) }}">
													<i class="fas fa-sort-up"></i>
												</a>
												<a href="{{ route('babies.index', array_merge(Request::all(), ['sortColumn' => 'dob', 'sortOrder' => 'ASC'])) }}">
													<i class="fas fa-sort-down"></i>
												</a>
												 {{ $fieldNameOnForm }}
											</th>
										@else
											<th scope="col">
												<a href="{{ route('babies.index', array_merge(Request::all(), ['sortColumn' => $fieldName, 'sortOrder' => 'ASC'])) }}">
													<i class="fas fa-sort-up"></i>
												</a>
												<a href="{{ route('babies.index', array_merge(Request::all(), ['sortColumn' => $fieldName, 'sortOrder' => 'DESC'])) }}">
													<i class="fas fa-sort-down"></i>
												</a>
												 {{ $fieldNameOnForm }}
											</th>
										@endif

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
										<form action="{{ route('babies.destroy', $baby->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete the selected record?');">

											<a href="{{ route('babies.show', $baby) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>
											<a href="{{ route('babies.edit', $baby) }}" class="btn btn-outline-info" role="button"><i class="far fa-edit"></i> Edit</a>

											@csrf
											@method('DELETE')
											@if (Auth::user()->isAdmin())
												<button class="btn btn-outline-danger" role="button" type="submit"><i class="fas fa-ban"></i> Delete</button>
											@endif
										</form>
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
					{{ $babies->appends(Request::all())->links() }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<a href="{{route('babies.create')}}" class="btn btn-outline-info mb-4" role="button">
					<i class="fas fa-plus-circle"></i> Create a new record
				</a>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<a href="{{route('babies.filter')}}" class="btn btn-outline-info mb-4" role="button">
					<i class="fas fa-plus-circle"></i> Create a new filter
				</a>
			</div>
		</div>
	</div>
@endsection
