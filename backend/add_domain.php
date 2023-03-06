<?php
include("./config.php");
include("./firebaseRDB.php");

if(!isset($_POST["domain_title"])){
    echo '<script>
    alert("Please fill all the details.")
    window.location.href="../add_domain.php"
    </script>';
    exit;
}


$db = new firebaseRDB($databaseURL);
$title=trim($_POST["domain_title"]);
$status=1;
$insert = $db->insert("domain_schema", [
    "domain_title"     => $title,
    "status"=> $status
]);
if ($insert) {
    echo '<script>
    window.location.href="../add_domain.php"
    </script>';
    exit;
} else {
    echo '<script>
    alert("Something went wrong. We are facing some technical issue. It will be resolved soon. ")
    window.location.href="../add_domain.php"
    </script>';
    exit;
}
?>