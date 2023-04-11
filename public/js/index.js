$(document).ready(function() {
    // Attach a submit handler to the form
    $('#formLogin').submit(function(event) {
        // Prevent the form from submitting
        event.preventDefault();

        // Perform form validation here
        // var name = $('#name').val();
        var email = $('#email').val();
        // var message = $('#message').val();

        // if (name === '') {
        //     alert('Please enter your name');
        //     return false;
        // }

        if (email === '') {
            alert('Please enter your email');
            return false;
        }

        // if (message === '') {
        //     alert('Please enter your message');
        //     return false;
        // }

        // Submit the form if validation passes
        this.submit();
    });
});