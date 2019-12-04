@extends ('layout')

@section ('content')
	<form class="text-center">
		<div class="container">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Name</span>
						</div>
						<input type="text" class="form-control" placeholder="{{$baby->name}}" readonly >
					</div>
				</div>
				<div class="col-3"></div>
			</div>
		</div>
	</form>
@endsection