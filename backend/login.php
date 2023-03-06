<?php  session_start(); ?>
<?php
    function checkReq($request){
        foreach($request as $data){
            if(!$data){
                return false;
            }
        }
        return true;
    }

    function checkPassword($password){
        $len=strlen($password);

        if($len<6){
            return false;
        }
        return true;
    }

    function trim_input_value($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    

    if (checkReq($_POST)) {
        $user_details=[];

       
        $user_details["email_address"]=trim_input_value($_POST["email"]);
        $pass=trim_input_value($_POST["password"])."salt1068@#785575659#01";
        $user_details["password"]=$pass;
        
        if (!checkReq($user_details)) {
            $msg="Please fill all the details correctly!";
            echo '<script>
                alert("Please fill all the details correctly!")
                window.location.href="../register.php"
                </script>';
            exit;
        }

       
        include("config.php");
        include("firebaseRDB.php");
        $db = new firebaseRDB($databaseURL);

        $data = $db->retrieve("manager_schema","email_address","EQUAL",$user_details["email_address"]);
        $data = json_decode($data, 1);
        
       if ($data!=null && is_array($data)) {
            foreach($data as $id => $user){
                $user_id=$id;
                $real_password=$user["password"];
                $user_name=$user["fullname"];
            }

            if (!password_verify($user_details["password"], $real_password)) 
            {
                echo "<script>alert('Invalid Credential !');
                history.back();
                </script>";
                exit;
            }

           $_SESSION["user_loggedin"]=true;
           $_SESSION["user_id"]=$user_id;
           $_SESSION["user_email"]=$user_details["email_address"];
           $_SESSION["user_name"]=$user_name;
           echo '<script>
           window.location.href="../dashboard.php"
           </script>';
           exit;

       } else {
        echo '<script>
        alert("Invalid Credential !")
            history.back();
        </script>';
        exit;
       }
        
    } 
    else {
        echo '<script>
        alert("Something went wrong. We are facing some technical issue. It will be resolved soon. ")
        window.location.href="../register.php"
        </script>';
        exit;
    }
?>