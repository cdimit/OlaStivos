@foreach($var->links as $link)
  <a href="{{$link->path}}">{{$link->name}}</a><br>
@endforeach
