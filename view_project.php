<?php
session_start();
if(!isset($_SESSION["user_loggedin"])){
    header("location: ./login.php");
    exit;
}
$project_id=trim($_GET["id"]);
$project_id=htmlspecialchars($project_id);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management Portal</title>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/dashboard.css">
   
</head>
<body>

    <div class="heading mt-100">
        <h1 class="text-center">Welcome to PMP - <?php echo $_SESSION["user_name"]?></h1>
    </div>
    <div class="mt-50 pl-2">
        <a class="back_button" href="./dashboard.php"><- Go Back</a>
    </div>

    <main class="table mt-100 position-relative">

      
        <?php
            include("./backend/config.php");
            include("./backend/firebaseRDB.php");
            $db = new firebaseRDB($databaseURL);
            $data = $db->retrieve("project_schema/".$project_id);
            $data = json_decode($data, 1);
           
            if ($data) {
                
                if (isset($data["error"])) {
                    echo '<h6 class="text-center">No Project Available...</h6>';
                }
                else{
                    if(is_array($data)){
                        ?>
                        <table border="1" width="98%" style="margin-left: 1%;">
                            
                            <tbody>
                            <tr>
                                    <th class="py-8">Project Title</th>
                                    <td class="py-8 pl-2"><?php echo $data["project_title"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="py-8">Requirement</th>
                                    <td class="py-8 pl-2"><?php echo $data["project_requirements"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="py-8">Start Date</th>
                                    <td class="py-8 pl-2"><?php echo $data["project_startdate"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="py-8">Deadline</th>
                                    <td class="py-8 pl-2"><?php echo $data["project_deadline"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="py-8">Status</th>
                                    <td class="py-8 pl-2">
                                    <?php 
                                           $project_status=$data["status"];
                                           if ($data["status"]==0) {
                                               echo "<span class='text-red'><b>Pending</b></span>";
                                           }
                                           else if($data["status"]==1){
                                               echo "<span class='text-green'><b>Completed</b></span>";
                                           }
                                           else if($data["status"]==2){
                                               echo "<span class='text-blue'><b>Processing</b></span>";
                                           }
                                           else if($data["status"]==3){
                                               echo "<span class='text-yellow'><b>Hold</b></span>";
                                           } 
                                           else {
                                               echo "<span class='text-danger'><b>Terminate</b></span>";
                                           }
                                           
                                       ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                    }
                }
            } else {
                echo '<h6 class="text-center">No Project Available...</h6>';
            }
            
        ?>
        <br>

        <div class="py-8 bg-coral" style="max-width: 100%; padding: 20px;">
            <form action="./backend/update_project_status.php" method="post">
                <div class="">
                    <p><b>Select Status*</b></p>
                    <select  class="input" name="status"  required>
                        <option <?php echo $project_status==0?"selected":""; ?> value="0">Pending</option>
                        <option <?php echo $project_status==1?"selected":""; ?> value="1">Completed</option>
                        <option <?php echo $project_status==2?"selected":""; ?> value="2">Processing</option>
                        <option <?php echo $project_status==3?"selected":""; ?> value="3">Hold</option>
                        <option <?php echo $project_status==4?"selected":""; ?> value="4">Terminate</option>
                    </select>

                    <input type="text" name="project_id" hidden style="display: none;" value="<?php echo $project_id; ?>">
                </div>
                <button class="btn btn-lightSkyBlue">Update</button>
            </form>
            <br>
            <hr>
            <form class="mt-20" action="./backend/remove_project.php" method="post" onsubmit="return confirm('Are you sure ?')" >
                <div class="">
                    <input type="text" name="project_id" hidden style="display: none;" value="<?php echo $project_id; ?>">
                </div>
                <button class="delete_btn">Permanent Remove</button>
            </form>
        </div>
            
       
    </main>

    

    
</body>
</html>