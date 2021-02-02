@extends ('layout')
@section ('content')
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="thead-light">
              <tr>
                <th scope="col">Name (English)</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($languages as $lang)
                <tr>
                  <td>{{ $lang->name }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <form action="{{route('languages.store')}}" method="post">
          @csrf
          <label for="name">Add new language:</label>
          <div class="input-group">
            <input class="form-control" type="text" name="name">
            <div class="input-group-append">
          <button class="btn btn-outline-info" type="submit"><i class="fas fa-plus-circle"></i> Add</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
