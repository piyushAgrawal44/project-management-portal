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
    <link rel="stylesheet" href="./css/index.css">
   
</head>
<body>

    <div class="heading mt-100">
        <h1 class="text-center">Welcome to PMP - Project Management Portal</h1>
    </div>

    <main class="mt-50 text-center">
        <h3 class="text-center">What You want to do ?</h3>
        <br>
        <a href="./login.php" class="btn btn-lightGreen mb-20">Login</a>
       
        <hr>
        
        <a href="./register.php" class="btn btn-lightSkyBlue mt-20">Register</a>
    </main>

    
</body>
</html>