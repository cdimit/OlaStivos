<table class="table table-responsive">
  <thead>
    <th>Όνομα Συνδέσμου</th>
    <th>Σύνδεσμος</th>
  </thead>
  <tbody>
    @foreach($var->links as $link)
      <tr>
        <td>{{$link->name}}</td>
        <td>
          <a href="{{$link->path}}">{{$link->path}}</a><br>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>