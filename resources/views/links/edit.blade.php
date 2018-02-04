<div class="col-md-8 input_fields_wrap">
  <button class="add_field_button">Add Links</button>
  <br>
  @foreach($var->links as $link)
    <div style="display:inline-block;">
      <label>Name</label><input type="text" name="link_name[]" value="{{$link->name}}" required >
      <label>Path</label><input type="text" name="link_path[]" value="{{$link->path}}" required >
      <a href="#" class="remove_field">Remove</a>
    </div>
  @endforeach

</div>
 

{{-- @section('scripts')
  <script type="text/javascript" src="/js/links/add_links.js"></script>
@endsection --}}
