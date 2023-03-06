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
    <link rel="stylesheet" href="./css/register.css">
  
</head>
<body>

    <div class="heading mt-100">
        <h1 class="text-center">Welcome to PMP - Project Management Portal</h1>
    </div>

    <main class="mt-50 text-center">
        <div class="register_card">
            <h3 class="mb-20">Create a new account :-</h3>
            <form class="text-start" action="./backend/register.php" method="post"  onsubmit="return registerUser()">
                <div class="mb-10">
                    <p><b>Email Id*</b></p>
                    <input type="email" class="input" name="email" placeholder="Enter email id" id="email" required>
                </div>
                <div class="mb-10">
                    <p><b>Full Name*</b></p>
                    <input type="text" class="input" name="name" placeholder="Enter full name" id="name" minlength="3" required>
                </div>
                <div class="mb-10">
                    <p><b>Primary Contact Number*</b></p>
                    <input type="tel" class="input" name="phone" placeholder="Phone Number" id="phone" minlength="10" required>
                </div>
                <div class="mb-10">
                    <p><b>Secondary Contact Number*</b></p>
                    <input type="tel" class="input" name="secondary_phone" placeholder="Phone Number" id="secondary_phone" minlength="10" required>
                </div>
                <div class="mb-10">
                    <p><b>Select Domain*</b></p>
                    <select class="input" name="domain_id" id="domain_id" required>
                    <option value="">-Select Domain-</option>
                    <?php
            include("./backend/config.php");
            include("./backend/firebaseRDB.php");
            $db = new firebaseRDB($databaseURL);
            $data = $db->retrieve("domain_schema");
            $data = json_decode($data, 1);
           
            if ($data) {
                
                if (isset($data["error"])) {
                    echo '<h6 class="text-center">No Project Available...</h6>';
                }
                else{
                    if(is_array($data)){
                       
                        ?>
                     
                            <?php
                            foreach($data as $id => $domain){
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $domain["domain_title"]; ?></option>
                                <?php
                               
                            }
                    }
                }
            } else {
                echo '<h6 class="text-center">No Project Available...</h6>';
            }
            
            ?>
                    </select>
                </div>
                <div class="mb-10">
                    <p><b>Password*</b></p>
                    <input type="password" class="input" name="password" placeholder="Atleast 6 digit long" id="password" minlength="6" required>
                    <br>
                    <input type="checkbox" class="checkbox" onclick="showPass1(this)"> Show Password
                </div>
                <div class="mb-10">
                    <p><b>Confirm Password*</b></p>
                    <input type="password" class="input" name="confirm_password" placeholder="Re-enter Password*" id="confirm_password" minlength="6" required>
                </div>

                <button type="submit" class="btn btn-coral mt-50">Register</button>
            </form>

            <br>
            <hr>
            <br>
            <h5 class="mb-10">Already have an account ?</h5>
            <a href="./login.php" class="btn btn-lightGreen mb-20">Login</a>
        </div>
        <br>
    </main>

    <script>
        function showPass1(checkbox){
            if(checkbox.checked){
                document.getElementById("password").type="text";
            }
            else{
                document.getElementById("password").type="password";
            }
        }

        function registerUser(){
            let email_id=document.getElementById("email").value;
            let fullname=document.getElementById("name").value;
            let primary_contact_number=document.getElementById("phone").value;
            let secondary_contact_number=document.getElementById("secondary_phone").value;
            let domain_id=document.getElementById("domain_id").value;
            let password=document.getElementById("password").value;
            let confirm_password=document.getElementById("confirm_password").value;

            if(email_id!=="" && fullname!=="" && primary_contact_number!=="" && secondary_contact_number!=="" && password!=="" && confirm_password!=="" && domain_id!==""){
                if(password===confirm_password){
                    return true;
                }
                else{
                    alert("Password and Confirm Password must be same !");
                    return false;
                }
            }
            else{
                alert("Please fill all the required details !");
                return false;
            }
        }
    </script>
    
</body>
</html>