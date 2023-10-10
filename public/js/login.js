$(document).ready(function() {
    $('#formLogin').submit(function(event) {
        event.preventDefault();
        $('#errorEmail').html('');
        $('#errorEmail').hide();
        $('#errorPassword').html('');
        $('#errorPassword').hide();
       
        // let emailRegex= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        // let passRegex= /^[A-Za-z]{1,}[0-9]{1,}[!@#$%\^\-\.]{1,}$/;
        let email = $('#email1').val();
        let password = $('#password1').val();
        
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
        // setTimeout(function(){
        //     document.getElementById('error').style.display = 'none';
        // }, 1000);
        // alert("Login successful");
        // $('#messages').removeClass('hide').addClass('alert alert-success alert-dismissible').slideDown().show();
        //         $('#messages_content').html('<h4>MESSAGE HERE</h4>');
        //         $('#modal').modal('show');
        this.submit();
    });
});