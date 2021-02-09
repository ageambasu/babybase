@extends ('layout')

@section ('content')
  @include('errors')
  <div class="container" >
    <div class="row mt-4" >
      <div class="col-12" >
        <h3>Renaming language: {{ $language->name }}</h3>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col" >
      <form name="rename-language" class="text-center" method="POST" action="{{ route('languages.update', $language) }}">
        @csrf
        @method('PUT')
        <label for="name">New name:</label>
        <input type="text" id="name" name="name">
        <button>Update</button>
      </form>
    </div>
    </div>
  </div>
@endsection
