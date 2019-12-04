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
								<th scope="col">Baby Name</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						
						<tbody>
							@foreach ($babies as $baby)
								<tr>
									<th scope="row">{{ $baby->id }}</th>
									<td>{{ $baby->name }}</td>
									<td><a href="/babies/{{ $baby->id }}/edit" class="btn btn-outline-info" role="button"><i class="far fa-edit"></i> Edit</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<nav>
					<ul class="pagination justify-content-center">
						<li class="page-item">
							<a class="page-link" href="#">
								<span aria-hidden="true">&laquo;</span>
								<span class="sr-only">Previous</span>
							</a>
						</li>
						<li class="page-item"><a class="page-link" href="#">1</a></li>
						<li class="page-item"><a class="page-link" href="#">2</a></li>
						<li class="page-item"><a class="page-link" href="#">3</a></li>
						<li class="page-item">
							<a class="page-link" href="#">
								<span aria-hidden="true">&raquo;</span>
								<span class="sr-only">Next</span>
							</a>
						</li>
					</ul>
				</nav>
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