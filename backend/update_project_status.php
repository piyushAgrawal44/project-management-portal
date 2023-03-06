<?php
session_start();
include("config.php");
include("firebaseRDB.php");

$db = new firebaseRDB($databaseURL);

if(!isset($_POST['project_id'])){
    echo '<script>
    alert("Please fill all the details correctly!")
   history.back();
    </script>';
    exit;
}


$project_id = trim($_POST['project_id']);

$data = $db->retrieve("project_schema/".$project_id);
$data = json_decode($data, 1);

if($data["manager_id"]!=$_SESSION["user_id"]){
    echo '<script>
    alert("Access Denied !")
    window.location.href="../dashboard.php"
    </script>';
    exit;
}
else{
    
$update = $db->update("project_schema", $project_id, [
    "status"     => $_POST['status'],
 ]);
 
 if($update){
     echo '<script>
     alert("Successfully Updated !");
     window.location.href="../dashboard.php"
     </script>';
     exit;
 }
 else{
     echo '<script>
     alert("Something Went Wrong !")
    history.back();
     </script>';
     exit;
 }
}

