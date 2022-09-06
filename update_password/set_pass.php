<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            background-color: rgb(218, 204, 187);
        }
        .cont{
            width: 70%;
            margin: auto;
            padding: auto;
        }
        h2{
            text-align: center;
            padding: 20px;
        }
        .error{
            text-align: center;
            padding: 20px;
            font-size: 1rem;
            color: rgb(233, 76, 76);
        }
        form{
            font-size: 1.2rem;
            width: 40%;
            margin: auto;
        }
        label{
            margin: 15px;
        }
        input{
            border: 2px solid white;
            padding: 10px;
            margin: 15px;
            font-size: 0.9rem;
            width: 90%;
        }
        input:hover{
            border:2px solid rgb(228, 222, 222);
            cursor: text;
        }
        p{
            text-align: center;
            font-size: 0.9rem;
        }
        .sub{
            width: 80%;
            margin: auto;
        }
        #s:hover{
            cursor:pointer;
        }
        a{
            text-decoration: none;
       }
       @media only screen and (max-width: 950px){
            form{
                width: 70%;
            }
        }
       @media only screen and (max-width: 520px){
            form{
                width: 100%;
            }
        }
    </style>

</head>
<body>

    <?php
            $email="";
            $err="";
            if(isset($_POST['next']))
            {
                if(empty($_POST['email']))
                {
                    $err="Please enter your email";                    
                }
                else
                {
                    $email=$_POST['email'];
                    require_once('../all_utils/connection.php');
                    $query="SELECT * FROM identity_table WHERE email='".$email."'";
                    $result=mysqli_query($conn,$query);

                    if(mysqli_fetch_assoc($result))
                    {
                        $_SESSION['email']=$email;
                        $_SESSION['a']='a';
                        require_once('mail.php');
                        header("location: reset_pass.php");
                    }
                    else
                    {
                        $err="Invalid Email";
                    }
                }
            }
    ?>
    <div class="cont">
        <h2>Log In</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
            <label for="email">Email</label><br />
            <input type="email" name="email" placeholder="Enter your Email" value="<?php echo $email;?>"><br />
            <div class="error"><?php echo $err;?></div>
            <div class="sub">
            <input type="submit" name="next" id="s" value="Next"><br />
            </div>
        </form>
    </div>
</body>
</html>