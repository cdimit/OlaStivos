<div class="form-group input_fields_wrap">
  <button class="add_field_button">Add Links</button>
  @foreach($var->links as $link)
    <div>
      <input type="text" name="link_name[]" value="{{$link->name}}" required >
      <input type="text" name="link_path[]" value="{{$link->name}}" required >
      <a href="#" class="remove_field">Remove</a>
    </div>
  @endforeach

</div>

@section('scripts')
  <script type="text/javascript" src="/js/links/add_links.js"></script>
@endsection
