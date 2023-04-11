$(document).ready(function () {
    // Attach a submit handler to the form
    $("#delete").click(function(){
        var result = confirm("Want to delete?");
        if (result) {
            console.log("deleted");
            this.onclick();
        }
        else{
            console.log("not deleted");
            return false;
        }
      });
})