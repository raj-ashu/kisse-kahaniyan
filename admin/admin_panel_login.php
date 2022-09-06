<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Login</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        .container{
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .cont{
            width: 300px;
            margin-top: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgb(226, 201, 164);
            padding: 10px;
        }
        .box{
            margin: 10px;
            padding-right: 10px;
        }
    </style>
</head>
<body>
    <?php
        $err = "";
        if(isset($_POST['login']))
        {   
            require_once('../all_utils/connection.php');
            $password=$_POST['password'];
            $query="SELECT * FROM identity_table WHERE name='".$_POST['username']."' AND password='".$_POST['password']."'";
                        
            $result=mysqli_query($conn,$query);
            if(mysqli_fetch_assoc($result))
            {
               session_start();   
                $_SESSION['admin']='1';
                header("location:admin_panel.php");
            }
            else
            {
                $err="Invalid Password";
            }
        }
    ?>
    <div class="container">
        <div class="cont">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <h2>Admin Login</h2>
                <div><?php echo $err;?></div>
                <input type="text" name="username" class="box" value="Admin" readonly><br>
                <input type="password" name="password" class="box" placeholder="Enter your Password"><br>
                <input type="submit" class="box" name="login"><br>
            </form>
        </div>
    </div>
</body>
</html>