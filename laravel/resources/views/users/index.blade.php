@extends ('layout')

@section ('content')
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="table-responsive">
					<table class="table table-hover table-striped">
						<thead class="thead-light">
							<tr>
								<th scope="col">#</th>

								@for ($i = 0; $i < count($fieldsOnDatabase); $i++)

									@php ($fieldName = $fieldsOnDatabase[$i][0])
									@php ($fieldNameOnForm = ucfirst(str_replace ("_", " ", $fieldName)))
									@php ($fieldOnIndex = $fieldsOnDatabase[$i][5])

									@if ($fieldOnIndex)

										<th scope="col">
											<a href="{{ route('users.index', array_merge(Request::all(), ['sortColumn' => $fieldName, 'sortOrder' => 'ASC'])) }}">
												<i class="fas fa-sort-up"></i>
											</a>
											<a href="{{ route('users.index', array_merge(Request::all(), ['sortColumn' => $fieldName, 'sortOrder' => 'DESC'])) }}">
												<i class="fas fa-sort-down"></i>
											</a>
											{{ $fieldNameOnForm }}
										</th>

									@endif

								@endfor

								<th scope="col">Actions</th>
							</tr>
						</thead>

						<tbody>
							@foreach ($users as $user)
								<tr>
									<th scope="row">{{ $user->id }}</th>

									@for ($i = 0; $i < count($fieldsOnDatabase); $i++)

										@php ($fieldName = $fieldsOnDatabase[$i][0])
										@php ($fieldNameOnForm = ucfirst(str_replace ("_", " ", $fieldName)))
										@php ($fieldOnIndex = $fieldsOnDatabase[$i][5])

										@if ($fieldOnIndex)

											<td>{{ $user->$fieldName }}</td>

										@endif

									@endfor

									<td>
										<form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete the selected record?');">

											<a href="{{ route('users.show', $user) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>
											<a href="{{ route('users.edit', $user) }}" class="btn btn-outline-info" role="button"><i class="far fa-edit"></i> Edit</a>

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
					{{ $users->appends(Request::all())->links() }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<a href="{{route('users.create')}}" class="btn btn-outline-info mb-4" role="button">
					<i class="fas fa-plus-circle"></i> Create a new record
				</a>
			</div>
		</div>

	</div>
@endsection
