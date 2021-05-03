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
		      <a href="{{ route('studies.index', array_merge(Request::all(), ['sortColumn' => $fieldName, 'sortOrder' => 'ASC'])) }}">
			<i class="fas fa-sort-up"></i>
		      </a>
		      <a href="{{ route('studies.index', array_merge(Request::all(), ['sortColumn' => $fieldName, 'sortOrder' => 'DESC'])) }}">
			<i class="fas fa-sort-down"></i>
		      </a>

		      @switch($fieldName)
			@case('study_age_range_start')
			  {{ 'Start Age' }}
						@break
			@case('study_age_range_end')
			  {{ 'End Age' }}
						@break
			@default
			{{ $fieldNameOnForm }}
		      @endswitch
		    </th>

		  @endif

		@endfor

		<th scope="col">Actions</th>
	      </tr>
	    </thead>

	    <tbody>
	      @foreach ($studies as $study)
		<tr>
		  <th scope="row">{{ $study->id }}</th>

		  @for ($i = 0; $i < count($fieldsOnDatabase); $i++)

		    @php ($fieldName = $fieldsOnDatabase[$i][0])
		    @php ($fieldNameOnForm = ucfirst(str_replace ("_", " ", $fieldName)))
		    @php ($fieldOnIndex = $fieldsOnDatabase[$i][5])

                    @if ($fieldsOnDatabase[$i][1] == 'boolean')
                      <td>{{ $study->$fieldName ? 'Yes':'No' }}</td>
                    @elseif ($fieldName == 'study_age_range_start')
		      <td>{{ $study->ageStart }}</td>
                    @elseif ($fieldName == 'study_age_range_end')
		      <td>{{ $study->ageEnd }}</td>
                    @elseif ($fieldOnIndex)
		      <td>{{ $study->$fieldName }}</td>
		    @endif

		  @endfor

		  <td>
		    <form action="{{ route('studies.destroy', $study->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete the selected record?');">

		      <a href="{{ route('studies.show', $study) }}" class="btn btn-outline-info" role="button"><i class="fas fa-eye"></i> View</a>
		      <a href="{{ route('studies.edit', $study) }}" class="btn btn-outline-info" role="button"><i class="far fa-edit"></i> Edit</a>

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
	  {{ $studies->appends(Request::all())->links() }}
	</div>
      </div>
    </div>

    <div class="row">
      <div class="col">
	<a href="{{route('studies.create')}}" class="btn btn-outline-info mb-4" role="button">
	  <i class="fas fa-plus-circle"></i> Create a new record
	</a>
      </div>
    </div>

  </div>
@endsection
