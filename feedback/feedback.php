<?php
if(isset($_POST['submit']))
{
    
    if(empty($_POST['name']) || empty($_POST['email']))
    {
        header("location:error.html");
    }
    else{
        require_once('../all_utils/connection.php');
        $name=$_POST['name'];
        $email=$_POST['email'];
        $feedback=$_POST['feedback'];
        $mysql="INSERT INTO feed(name,email,feedback) VALUES ('$name','$email','$feedback')";
        if(mysqli_query($conn,$mysql) === FALSE) 
        {
            header("location:error.html");
        }
        else
        {
            header("location:f_success.html");
        }
    }
}
else
{
    header("location:../index.html");
}
?>