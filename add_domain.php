<?php
session_start();
if(!isset($_SESSION["user_loggedin"])){
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
    <div class="mt-50 pl-2">
        <a class="back_button" href="./dashboard.php"><- Go Back</a>
    </div>
    

    <main class="mt-50 text-center">
        <div class="login_card">
            <h3 class="mb-20">Add new Domain :-</h3>
            <form class="text-start" action="./backend/add_domain.php" method="post" onsubmit="return loginUser()">
                <div class="mb-10">
                    <input type="text" class="input" name="domain_title" placeholder="Domain Title*" required>
                </div>

                <button type="submit" class="btn btn-coral mt-50">Add Domain</button>
            </form>
        </div>
    </main>

</body>
</html>