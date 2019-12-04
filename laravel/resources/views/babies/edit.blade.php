@extends ('layout')

@section ('content')
	<form class="text-center" method="POST" action="/babies/{{$baby->id}}">
		@csrf
		@method('PUT')
		<div class="container">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Name</span>
						</div>
						<input type="text" class="form-control @error('name') is-invalid @enderror" value="{{$baby->name}}" required>
						@error('name')
							<div class="invalid-feedback">{{ $errors->first('name') }}</div>
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