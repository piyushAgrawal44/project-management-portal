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

    function checkPhone($phone){

        $len=strlen($phone);

        if($len<10){
            return false;
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

        $user_details["fullname"]=trim_input_value($_POST["name"]);
        $user_details["email_address"]=trim_input_value($_POST["email"]);
        $user_details["primary_contact_number"]=trim_input_value($_POST["phone"]);
        $user_details["secondary_contact_number"]=trim_input_value($_POST["secondary_phone"]);
        $user_details["domain_id"]=trim_input_value($_POST["domain_id"]);
        $user_details["created_date"]=date("Y-m-d");
        $pass=trim_input_value($_POST["password"])."salt1068@#785575659#01";
        $user_details["password"]=password_hash($pass,PASSWORD_DEFAULT);
        
        if (!checkReq($user_details)) {
            $msg="Please fill all the details correctly!";
            echo '<script>
                alert("Please fill all the details correctly!")
                window.location.href="../register.php"
                </script>';
            exit;
        }

        if (!checkPhone($user_details["primary_contact_number"])) {
            $msg="Please fill all phone number correctly !";
            echo '<script>
                alert("Please fill all phone number correctly ! ")
                window.location.href="../register.php"
                </script>';
            exit;
        }

       

        include("config.php");
        include("firebaseRDB.php");
        $db = new firebaseRDB($databaseURL);

        $data = $db->retrieve("manager_schema","email_address","EQUAL",$user_details["email_address"]);
        $data = json_decode($data, 1);
       
        
       if ($data==null) {
            $insert = $db->insert("manager_schema", [
                "fullname"     => $user_details["fullname"],
                "email_address" => $user_details["email_address"],
                "primary_contact_number"=> $user_details["primary_contact_number"],
                "secondary_contact_number"=> $user_details["secondary_contact_number"],
                "domain_id" => $user_details["domain_id"],
                "created_date"=> $user_details["created_date"],
                "user_name"=> $user_details["email_address"],
                "password"    => $user_details["password"],
            ]);
            if ($insert) {
                echo '<script>
                alert("Successfully Account Created !");
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
       } else {
            echo '<script>
            alert("Email id already registered !")
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