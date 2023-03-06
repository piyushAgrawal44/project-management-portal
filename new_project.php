<?php
session_start();
if(!isset($_SESSION["user_loggedin"])){
    header("location: ./login.php");
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
    <link rel="stylesheet" href="./css/new_project.css">
   
</head>
<body>

    <div class="heading mt-100">
        <h1 class="text-center">Welcome to PMP - <?php echo $_SESSION["user_name"]?></h1>
    </div>

    <div class="mt-50 pl-2">
        <a class="back_button" href="./dashboard.php"><- Go Back</a>
    </div>
    
    <main class="table mt-100 position-relative bg-coral">

    <div class="new_project_div">
            <h3 class="mb-20">Create a new project :-</h3>
            <form class="new_project_form text-start" action="./backend/new_project.php" method="post">
                <div class="mb-10">
                    <p><b>Project Title*</b></p>
                    <input type="text" class="input" name="project_title" placeholder="Title" required>
                </div>

                <div class="mb-10">
                    <p><b>Project Requirements*</b></p>
                    <textarea type="text" class="input" name="project_requirements" placeholder="Requirement" rows="2" required></textarea>
                </div>

                <div class="mb-10">
                    <p><b>Project Start Date*</b></p>
                    <input type="date" class="input" name="project_startdate" placeholder="" required>
                </div>

                <div class="mb-10">
                    <p><b>Project Deadline*</b></p>
                    <input type="date" class="input" name="project_deadline" placeholder="" required>
                </div>

                <div class="mb-10">
                    <p><b>Select Status*</b></p>
                    <select  class="input" name="status"  required>
                        <option value="0">Pending</option>
                        <option value="1">Completed</option>
                        <option value="2">Processing</option>
                        <option value="3">Hold</option>
                        <option value="4">Terminate</option>
                    </select>
                </div>


                

                <button type="submit" class="btn btn-coral mt-50">Create Project</button>
            </form>

        </div>
    </main>

    

    
</body>
</html>