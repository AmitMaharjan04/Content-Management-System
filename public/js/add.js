$(document).ready(function(){
    $('#formAdd').submit(function(event){
        event.preventDefault();
        
        $('#errorName').html('');
        $('#errorName').hide();
        $('#errorEmail').html('');
        $('#errorEmail').hide();
        $('#errorAddress').html('');
        $('#errorAddress').hide();
        $('#errorHobby').html('');
        $('#errorHobby').hide();
        $('#errorDescription').html('');
        $('#errorDescription').hide();

        let name=$('#name').val();
        let email=$('#email').val();
        let address=$('#address').val();
        let description=$('#description').val();
        let emailRegex= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        
        if(name ===''){
            $('#errorName').removeAttr('hidden');
            $('#errorName').show();
            $('#errorName').html('Please enter name');
            return false;
        }
        if(email ===''){
            $('#errorEmail').removeAttr('hidden');
            $('#errorEmail').show();
            $('#errorEmail').html('Please enter email');
            return false;
        }
        if(address ===''){
            $('#errorAddress').removeAttr('hidden');
            $('#errorAddress').show();
            $('#errorAddress').html('Please enter address');
            return false;
        }
        if(description ===''){
            $('#errorDescription').removeAttr('hidden');
            $('#errorDescription').show();
            $('#errorDescription').html('Please enter description');
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
        if(address.length>50){
            $('#errorAddress').removeAttr('hidden');
            $('#errorAddress').show();
            $('#errorAddress').html('Please enter address below 50 characters');
            console.log("address long");
            return false;
        }
        if(description.length>100){
            $('#errorDescription').removeAttr('hidden');
            $('#errorDescription').show();
            $('#errorDescription').html('Please enter description below 100 characters');
            console.log("description long");
            return false;
        }
        let checkboxes = $('.hobby:checked');
            if (checkboxes.length==0) {
                $('#errorHobby').removeAttr('hidden');
                $('#errorHobby').show();
                $('#errorHobby').html('Please select any hobbies or others field');
                return false;
            }
        // console.log(name);
        // console.log(email);
        // console.log(address);
        // console.log(hobby);
        // console.log(description);
        this.submit();
    })
})