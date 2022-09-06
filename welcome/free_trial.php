<?php
    
    session_start();
    require_once('../all_utils/connection.php');
    $st = 'done';
    $days = 7;
    $cus_email = $_SESSION['email'];
    $subs_category = '2';
    $today = date('y-m-d');
    $mysql = "UPDATE identity_table SET doa='$today',free_trial_status = '$st' ,subs_category='$subs_category',days_left = '$days' WHERE email='$cus_email'";
    if(mysqli_query($conn,$mysql) === FALSE) 
    {
        $err='<h3 style="text-align: center;">Error occured Please contact service provider at 1963animesh@gmail.com</h3>';
        echo '<h4 style="text-align: center;"><a href="../login.php">Login</a></h4>'; 
    }
    else
    {
        echo '<h2 style="text-align: center;">Thanks for using our membership plan</h2><br>';
        echo '<h4 style="text-align: center;"><a href="../login.php">Login</a></h4>';
    }
?>