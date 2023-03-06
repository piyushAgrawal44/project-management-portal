<?php
session_start();
if(!isset($_SESSION["user_loggedin"])){
    header("location: ./login.php");
    exit;
}
$user_id=trim($_GET["id"]);
$user_id=htmlspecialchars($user_id);
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
            $data = $db->retrieve("manager_schema/".$user_id);
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
                                    <th class="py-8">Name</th>
                                    <td class="py-8 pl-2"><?php echo $data["fullname"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="py-8">Email</th>
                                    <td class="py-8 pl-2"><?php echo $data["email_address"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="py-8">Primary Contact Number</th>
                                    <td class="py-8 pl-2"><?php echo $data["primary_contact_number"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="py-8">Secondary Contact Number</th>
                                    <td class="py-8 pl-2"><?php echo $data["secondary_contact_number"]; ?></td>
                                </tr>
                                <tr>
                                    <th class="py-8">Domain</th>
                                    <td class="py-8 pl-2">
                                    <?php 
                                     $domain = $db->retrieve("domain_schema/".$data["domain_id"]); 
                                     $domain = json_decode($domain, 1);
                                     echo $domain["domain_title"];
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

            
       
    </main>

    

    
</body>
</html>