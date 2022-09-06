<?php
    session_start();
    $email="";
    $err="";
    if(!empty($_SESSION['email']))
    {
        require_once('./all_utils/connection.php');
        $query="SELECT * FROM identity_table WHERE email='".$_SESSION['email']."'";
        $result=mysqli_query($conn,$query);
        if(mysqli_fetch_assoc($result))
        {
            header("location:welcome/welcome.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Diary SignUp Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            background-color: #1b0404ed;
        }

        .cont {
            color: burlywood;
            width: 500px;
            margin: auto;
        }

        h2 {
            color: burlywood;
            text-align: center;
            padding: 1.5px;
        }

        .error {
            text-align: center;
            padding: 20px;
            font-size: 1rem;
            color: rgb(233, 76, 76);
        }

        form {
            font-size: 1.2rem;
            /* width: 40%; */
            /* margin: auto; */
        }
        .in{
            margin: 5px 0;
        }

        input {
            border: 2px solid white;
            padding: 10px;
            margin: 5px 0;
            font-size: 1rem;
            width: 100%;
        }

        input:hover {
            border: 2px solid rgb(228, 81, 81);
            cursor: text;
        }

        p,a{
            text-align: center;
            font-size: 1rem;
        }
        a{
            color: rgb(45, 113, 216);
        }

        #s:hover {
            cursor: pointer;
        }

        a {
            text-decoration: none;
        }
        @media only screen and (max-width: 600px){
            .cont{
                width: 300px;
            }
            .error,input{
                font-size: 0.8rem;
            }

        }
        @media only screen and (max-width: 400px){
            .cont{
                width: 70%;
            }
            h2{
                font-size: 1.3rem;
            }

        }
    </style>
</head>

<body>
    <?php
            if(isset($_POST['login']))
            {
                if(empty($_POST['email']) || empty($_POST['password']))
                {
                    if(empty($_POST['email']) && empty($_POST['password']))
                    {
                        $err="Please enter your Email and Password";
                    }
                    elseif(empty($_POST['email']))
                    {
                        $err="Please enter your email";
                    }
                    elseif(empty($_POST['password']))
                    {
                        $email=$_POST['email'];
                        $err="Please enter Password";
                    }
                    
                }
                else
                {
                    $email=$_POST['email'];
                    $password=$_POST['password'];

                    require_once('./all_utils/connection.php');
                    $query="SELECT * FROM identity_table WHERE email='".$email."'";
                    $result=mysqli_query($conn,$query);
        
        
                    if($r = mysqli_fetch_assoc($result))
                    {
                        if(password_verify($password,$r['password']))
                        {
                            $_SESSION['email']=$email;
                            header("location:welcome/welcome.php");
                        }
                        else
                        {
                            $err="Invalid Password!";
                        }
                    }
                    else
                    {
                        $err="Invalid Email!";
                    }
                }
            }
    ?>
    <div class="cont">
        <h2>Log In</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">

                <label class="in" for="email">Email</label><br/>
                <input type="email" name="email" placeholder="Enter your Email" value="<?php echo $email;?>"><br/>
                <label class="in" for="password">Password</label><br/>
                <input type="password" name="password" placeholder="Enter your Password"><br/>
                <div class="error"><?php echo $err;?></div>
                <div class="in"><a href="./update_password/set_pass.php">Forgot Password?</a></div>
                <div class="sub">
                    <input type="submit" name="login" id="s" placeholder="Submit"><br/>
                </div>
            </form>

            <p></p>
            <p>Not registered yet? <a href="./signup.php">sign up here</a></p>
    </div>
</body>

</html>