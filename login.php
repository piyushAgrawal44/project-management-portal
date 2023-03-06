<?php
session_start();
if(isset($_SESSION["user_loggedin"])){
    header("location: ./dashboard.php");
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management Portal</title>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/login.css">
  
</head>
<body>

    <div class="heading mt-100">
        <h1 class="text-center">Welcome to PMP - Project Management Portal</h1>
    </div>

    <main class="mt-50 text-center">
        <div class="login_card">
            <h3 class="mb-20">Login into your account :-</h3>
            <form class="text-start" action="./backend/login.php" method="post" onsubmit="return loginUser()">
                <div class="mb-10">
                    <input type="email" class="input" name="email" placeholder="Email*" required>
                </div>
                <div class="">
                    <input type="password" class="input" name="password" placeholder="Password*" id="password" minlength="6" required>
                    <br>
                    <input type="checkbox" class="checkbox" onclick="showPass1(this)"> Show Password
                </div>

                <button type="submit" class="btn btn-coral mt-50">Login</button>
            </form>

            <br>
            <hr>
            <br>
            <h5 class="mb-10">New user ?</h5>
            <a href="./register.php" type="button" class="btn btn-lightSkyBlue mt-20">Register</a>
        </div>
    </main>

    <script>
        function showPass1(checkbox){
            if(checkbox.checked){
                document.getElementById("password").type="text";
            }
            else{
                document.getElementById("password").type="password";
            }
        }

        function loginUser(){
            let email_id=document.getElementById("email").value;
            
            let password=document.getElementById("password").value;
            
            if(email_id!=="" && password!=="" ){
                return true;
            }
            else{
                alert("Please fill all the required details !");
                return false;
            }
        }
    </script>
    
</body>
</html>