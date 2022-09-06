<?php
    session_start();
    if($_SESSION['email'])
    {
        $email=$_SESSION['email'];
        require_once('../all_utils/connection.php');
        $query="SELECT * FROM identity_table WHERE email='".$email."'";
        $result=mysqli_query($conn,$query);
        if($r=mysqli_fetch_assoc($result))
        {
            $_SESSION['name']= $r['name'];
            if($r['days_left']<=0)
            {
                header("location: ../welcome/welcome.php");
            }
            else
            {
                $_SESSION['date_of_application']=$r['doa'];
                $age_category = $r['age_category'];
            }
        }   
    }
    else
    {
        header("location:../login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOUR Story</title>
    <link rel="stylesheet" href="./style1.css">
</head>

<body>
    <div class="navbar">
        <div class="logo" onclick="openNav()">&#9776;</div>
        <div class="nav_title">
            <div class="icon"><img src="https://i.pinimg.com/originals/60/74/40/607440e61f5c28a0bf3acaaeaa155075.jpg"
                    alt="">
            </div>
            <div class="nav_head">My Webpage</div>
        </div>
        <ul id="Nav">
            <li onclick="closeNav()" id="closeNav">&times;</li>
            <li><a href="#">Hello,<br><?php echo $_SESSION['name']?></a></li>
            <li><a href="../blogs/">Blogs</a></li>
            <li><a href="../all_utils/logout.php">LogOut</a></li>
        </ul>
    </div>
    <div class="container">
            <?php
                require_once('../all_utils/connection.php');
                $sql = "SELECT * FROM story_data WHERE doe >= '".$_SESSION['date_of_application']."' AND category = $age_category ORDER BY doe DESC , id DESC";
                $r = mysqli_query($conn,$sql);
                if($r)
                {
                    if(mysqli_num_rows($r) > 0)
                    {
                        while($row = mysqli_fetch_assoc($r))
                        {
                            $header = $row['heading'];
                            $content = $row['content'];
                            $date_of_entry=$row['doe'];
                            echo '<div class="cards">';
                            echo '<div class="header">'.$header.'</div>';
                            echo '<div class="para">'.$content.'</div>';
                            echo '<div class="cont">';
                            echo '<div class="date_time">'.$date_of_entry.'</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    else
                    {
                        echo '<div class="cards">';
                        echo '<div class="header">No Stories yet</div>';
                        echo '<div class="para">Please wait for one day or contact the service provider</div>';
                        echo '</div>';
                    }
                }
                else
                {
                    echo '<div class="cards">';
                    echo '<div class="header">No Stories yet</div>';
                    echo '<div class="para">Please wait for one day or contact the service provider</div>';
                    echo '</div>';
                }
            ?>
            
    </div>
    <footer>
        <hr>
        <div class="para" style="text-align: center;">CopyRight@2020 | All Rights Reserved.</div>
    </footer>
    <script>
        function openNav() {
            document.getElementById("Nav").style.width = "250px";
        }
        function closeNav() {
            document.getElementById("Nav").style.width = "0px";
        }
    </script>
</body>

</html>