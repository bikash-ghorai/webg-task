@extends('layouts')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <h3>Login</h3>
        </div>
    </div>
    <br>
    <form method="POST" id="loginForm">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="text" class="form-control" name="email" id="email">
                    <small class="error" id="emailErr">Enter valid email address</small>
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
        <div class="row justify-content-center">
            <div class="col-3"></div>
            <div class="col-4">
                <p>Don't have any account? <a href="{{ url('register') }}">Register</a></p>
            </div>
            <div class="col-5">
                <button type="button" class="btn btn-primary" id="loginBtn">Login</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('custom_script')
<script type="text/javascript">
    $(document).ready(function(){
        var token = localStorage.getItem('token');
        // console.log(token);
        if (token == null) {
            $(".loader-bg").hide();
        }else{
            window.location.href = '{{ url("/") }}';
        }
    });
    $("#loginBtn").click(function(){
        var email = $("#email").val();
        var password = $("#password").val();
        if (email == '' || emailValidate(email)) {
            $("#email").addClass('error-field');
            $("#emailErr").show();
        }else if (password == '') {
            $("#password").addClass('error-field');
            $("#passwordErr").show();
        }else {
            $.ajax({
                url: "{{ url('api/login') }}", 
                method: "POST",
                data: {email: email, password: password},
                success: function (response) {
                    if(response.status == 'Success'){
                        $("#loginForm").trigger("reset");
                        $("#message").html(response.message);
                        $("#message").show();
                        localStorage.setItem('token', response.token);
                        localStorage.setItem('user_name', response.user_name);
                        window.location.href = '{{ url("/") }}';
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