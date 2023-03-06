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
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
   
</head>
<body>

    <div class="heading mt-100">
        <h1 class="text-center">Welcome to PMP - <?php echo $_SESSION["user_name"]?></h1>
        <div class="text-center">
            <a href="./edit_profile.php?id=<?php echo $_SESSION['user_id'] ?>" class="profile_btn text-blue"><i>Profile</i></a>&nbsp;&nbsp;<a href="./add_domain.php" class="profile_btn text-blue"><i>Add a domain</i></a>&nbsp;&nbsp;<a href="./logout.php" class="profile_btn text-blue"><i>Logout</i></a>
        </div>
    </div>

    <div class="text-center">
        <a href="./new_project.php" class="btn btn-lightSkyBlue mt-50">+ New Project</a>
    </div>

    <main class="table mt-100 position-relative ">

      
        <?php
            include("./backend/config.php");
            include("./backend/firebaseRDB.php");
            $db = new firebaseRDB($databaseURL);
            $data = $db->retrieve("project_schema","manager_id","EQUAL",$_SESSION["user_id"]);
            $data = json_decode($data, 1);
           
            if ($data) {
                
                if (isset($data["error"])) {
                    echo '<h6 class="text-center">No Project Available...</h6>';
                }
                else{
                    if(is_array($data)){
                        $sno=1;
                        ?>
                        <table width="98%" style="margin-left: 1%; padding:10px" id="myTable">
                            <thead class="bg-coral">
                                <tr >
                                    <th class="py-8">Sno.</th>
                                    <th class="py-8">Project Title</th>
                                    <th class="py-8">Deadline</th>
                                    <th class="py-8">Status</th>
                                    <th class="py-8">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($data as $id => $project){
                                ?>
                                <tr  >
                                    <td class="py-8 pl-2"><?php echo $sno; ?></td>
                                    <td class="py-8 pl-2"><a href="view_project.php?id=<?php echo $id; ?>"><?php echo $project["project_title"]; ?></a></td>
                                    <td class="py-8 pl-2"><?php echo $project["project_deadline"]; ?></td>
                                    <td class="py-8 pl-2">
                                        <?php 
                                           
                                            if ($project["status"]==0) {
                                                echo "<span class='text-red'><b>Pending</b></span>";
                                            }
                                            else if($project["status"]==1){
                                                echo "<span class='text-green'><b>Completed</b></span>";
                                            }
                                            else if($project["status"]==2){
                                                echo "<span class='text-blue'><b>Processing</b></span>";
                                            }
                                            else if($project["status"]==3){
                                                echo "<span class='text-yellow'><b>Hold</b></span>";
                                            } 
                                            else {
                                                echo "<span class='text-danger'><b>Terminate</b></span>";
                                            }
                                            
                                        ?>
                                    </td>
                                    <td class="py-8 pl-2">
                                        <a href="view_project.php?id=<?php echo $id; ?>" class="btn btn-lightGreen">Update</a>
                                    </td>
                                </tr>
                                <?php
                                $sno++;
                            }

                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
            } else {
                echo '<h6 class="text-center">No Project Available...</h6>';
            }
            
            ?>
            
       
    </main>

    
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>
</body>
</html>