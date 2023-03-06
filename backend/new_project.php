<?php  session_start(); ?>
<?php
        function checkReq($request){
            foreach($request as $data){
                if($data=="" || $data==null){
                    return false;
                }
            }
            return true;
        }

    

        function trim_input_value($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        

        $project_details=[];

        $project_details["project_tile"]=trim_input_value($_POST["project_title"]);
        $project_details["project_requirements"]=trim_input_value($_POST["project_requirements"]);
        $project_details["project_startdate"]=trim_input_value($_POST["project_startdate"]);
        $project_details["project_deadline"]=trim_input_value($_POST["project_deadline"]);
        $project_details["manager_id"]=trim_input_value($_SESSION["user_id"]);
        $project_details["status"]=trim_input_value($_POST["status"]);
        
        
        if (!checkReq($project_details)) {
            $msg="Please fill all the details correctly!";
            echo '<script>
                alert("Please fill all the details correctly!")
               history.back();
                </script>';
            exit;
        }


       

        include("config.php");
        include("firebaseRDB.php");
        $db = new firebaseRDB($databaseURL);

       
        $insert = $db->insert("project_schema", [
            "project_title"     => $project_details["project_tile"],
            "project_requirements" => $project_details["project_requirements"],
            "project_startdate"=> $project_details["project_startdate"],
            "project_deadline"=> $project_details["project_deadline"],
            "manager_id" => $project_details["manager_id"],
            "status"=> $project_details["status"]
        ]);
        if ($insert) {
            echo '<script>
            window.location.href="../dashboard.php"
            </script>';
            exit;
        } else {
            echo '<script>
            alert("Something went wrong. We are facing some technical issue. It will be resolved soon. ")
            window.location.href="../register.php"
            </script>';
            exit;
        }
        
   
?>