@foreach ($errors->all() as $key=>$msg)
  <div class="alert alert-danger">{{  $msg }}</div>
@endforeach
