@extends('layouts')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-6">
            <h3>Register</h3>
        </div>
    </div>
    <br>
        <form method="POST" id="regForm">
        	<div class="row justify-content-center">
    		    <div class="col-3">
    		      <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name">
                        <small class="error" id="first_nameErr">Enter valid first name</small>
                    </div>
    		    </div>
    		    <div class="col-3">
    		      <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name">
                        <small class="error" id="last_nameErr">Enter valid last name</small>
                    </div>
    		    </div>
    		</div>
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="text" class="form-control" name="email" id="email">
                        <small class="error" id="emailErr">Enter valid email address</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone number</label>
                        <input type="tel" class="form-control" name="phone" id="phone" maxlength="10">
                        <small class="error" id="phoneErr">Enter valid phone number</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                        <small class="error" id="passwordErr">Enter valid password</small>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6">
                    <p class="error" id="message"></p>
                </div>
            </div>
            <br>
            <div class="row justify-content-end">
                <div class="col-3"></div>
                <div class="col-4">
                    <p>Already have an account? <a href="{{ url('login') }}">Login</a></p>
                </div>
            	<div class="col-5">
            		<button type="button" class="btn btn-primary" id="register">Register Now</button>
            	</div>
            </div>
        </form>
    </div>
@endsection

@section('custom_script')
<script type="text/javascript">
    $(document).ready(function(){
        var token = localStorage.getItem('token');
        console.log(token);
        if (token == null) {
            $(".loader-bg").hide();
        }else{
            window.location.href = '{{ url("/") }}';
        }
    });
    $("#register").click(function(){
        var fname = $("#first_name").val();
        var lname = $("#last_name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var password = $("#password").val();
        if (fname == '') {
            $("#first_name").addClass('error-field');
            $("#first_nameErr").show();
        }else if (lname == '') {
            $("#last_name").addClass('error-field');
            $("#last_nameErr").show();
        }else if (email == '' || emailValidate(email)) {
            $("#email").addClass('error-field');
            $("#emailErr").show();
        }else if (phone == '' || phone.length < 10) {
            $("#phone").addClass('error-field');
            $("#phoneErr").show();
        }else if (password == '') {
            $("#password").addClass('error-field');
            $("#passwordErr").show();
        }else {
            $.ajax({
                url: "{{ url('api/register') }}", 
                method: "POST",
                data: {fname: fname, lname: lname, email: email, phone: phone, password: password},
                success: function (response) {
                    if(response.status == 'Success'){
                        $("#regForm").trigger("reset");
                        $("#message").html(response.message);
                        $("#message").show();
                    }else{
                        $("#message").html(response.message);
                        $("#message").show();
                    }                                            
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            })
        }
    })
    function emailValidate(email){
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
            return false;
        }else{
            return true;
        }
    }
    $(".form-control").click(function(){
        $(this).removeClass('error-field');;
        let id = $(this).attr('id');
        $("#"+id+"Err").hide();
    })
</script>
@endsection