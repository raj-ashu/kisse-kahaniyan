<?php
        require_once('../all_utils/connection.php');
        $sql="SELECT * FROM identity_table";    
        if ($result=mysqli_query($conn,$sql))
        {
            $val1=mysqli_num_rows($result);
            mysqli_free_result($result);
        }
        else
        {
            $err="Error occured";
        }    
        require_once('../all_utils/connection.php');
        $sql="SELECT * FROM identity_table WHERE subs_category='2' AND days_left > 0";    
        if ($result=mysqli_query($conn,$sql))
        {
            $val2=mysqli_num_rows($result);
            mysqli_free_result($result);
        }
        else
        {
            $err="Error occured";
        }    
        require_once('../all_utils/connection.php');
        $sql="SELECT * FROM identity_table WHERE subs_category='3' AND days_left > 0";    
        if ($result=mysqli_query($conn,$sql))
        {
            $val3=mysqli_num_rows($result);
            mysqli_free_result($result);
        }
        else
        {
            $err="Error occured";
        }
            
        require_once('../all_utils/connection.php');
        $sql="SELECT * FROM identity_table WHERE subs_category='4' AND days_left > 0";    
        if ($result=mysqli_query($conn,$sql))
        {
            $val4=mysqli_num_rows($result);
            mysqli_free_result($result);
        }
        else
        {
            $err="Error occured";
        }
?>