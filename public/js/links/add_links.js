$(document).ready(function() {
  var wrapper         = $(".input_fields_wrap"); //Fields wrapper
  var add_button      = $(".add_field_button"); //Add button ID

  $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
          $(wrapper).append('<div><label>Name</label><input type="text" name="link_name[]" required><label>Path</label><input type="text" name="link_path[]" required><a href="#" class="remove_field">Remove</a></div>'); //add input box
  });

  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('div').remove();
  })
});
