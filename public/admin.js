$(document).ready(function() {
    $("#myForm").submit(function(event) {
      event.preventDefault();
  
      // get form values
      var name = $("#name").val();
      var email = $("#email").val();
      var phone = $("#phone").val();
  
      // validate name
      if (name.length < 2) {
        alert("Name must be at least 2 characters.");
        return false;
      }
  
      // validate email
      if (!isValidEmail(email)) {
        alert("Please enter a valid email address.");
        return false;
      }
  
      if (password.length < 2) {
        alert("Password must be at least 2 characters.");
        return false;
      }
      // form is valid, submit it
      this.submit();
    });
});
  