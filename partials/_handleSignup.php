<?php
$showError="false";
if($_SERVER["REQUEST_METHOD"]=="POST"){ // When the Sign up modal is posted.
    include '_dbconnect.php';
    $user_email=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['signupcPassword'];
    $existSql = "select * from `users` where user_email = '$user_email'";
    $result = mysqli_query($conn,$existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows > 0){
        $showError = "Email already in use";

    } else {
        if($pass == $cpass){
            $hash = password_hash($pass,PASSWORD_DEFAULT); // For password hashing.
            $sql="INSERT INTO `users` ( `user_email`, `user_pass`, `timestamp`) VALUES ( '$user_email', '$hash', current_timestamp());";
            $result=mysqli_query($conn,$sql);
            if($result){ // Alert for success.
                $showAlert=true;
                header("Location: /STUDDISCUSS/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError = "Password do not match";
        }
    }
    header("Location: /STUDDISCUSS/index.php?signupsuccess=false&error=$showError");
}
?>
