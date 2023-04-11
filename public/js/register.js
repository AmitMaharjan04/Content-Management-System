$(document).ready(function() {
    $('#formRegister').submit(function(event) {
        event.preventDefault();

        $('#errorName').html('');
        $('#errorName').hide();
        $('#errorEmail').html('');
        $('#errorEmail').hide();
        $('#errorPassword').html('');
        $('#errorPassword').hide();

        // Perform form validation here
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        let emailRegex= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        let passRegex= /^[A-Za-z]{1,}[0-9]{1,}[!@#$%\^\-\.]{1,}$/;
        if (name === '') {
            $('#errorName').removeAttr('hidden');
            $('#errorName').show();
            $('#errorName').html('Please enter your name');
            return false;
        }
        if (email === '') {
            $('#errorEmail').removeAttr('hidden');
            $('#errorEmail').show();
            $('#errorEmail').html('Please enter your email');
            return false;
        }

        if (password === '') {
            $('#errorPassword').removeAttr('hidden');
            $('#errorPassword').show();
            $('#errorPassword').html('Please enter your password');
            return false;
        }
        if(name.length<3 || name.length>30){
            $('#errorName').removeAttr('hidden');
            $('#errorName').show();
            $('#errorName').html('Please enter name between 3-30');
            console.log("name short");
            return false;
        }
        if(!emailRegex.test(email)){
            $('#errorEmail').removeAttr('hidden');
            $('#errorEmail').show();
            $('#errorEmail').html('Please enter valid email address');
            console.log("email regex");
            return false;
        }
        if(passRegex.test(password)!=true){
            $('#errorPassword').removeAttr('hidden');
            $('#errorPassword').show();
            $('#errorPassword').html('Password must contain alphabets,numbers and special characters');
            console.log("password regex");
            return false;
        }
        if(password.length>30 || password.length<5){
            $('#errorPassword').removeAttr('hidden');
            $('#errorPassword').show();
            $('#errorPassword').html('Password must be between 5 to 30 characters');
            console.log("password short");
            return false;
        }
        // Submit the form if validation passes
        this.submit();
    });
});