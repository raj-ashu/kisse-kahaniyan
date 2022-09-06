<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Page</title>

    <style>
        body
        {
            background-color: rgb(245, 238, 229);
            padding: 20px;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cont
        {
            padding: 20px 40px;
            position: relative;
            border-right: 4px solid rgb(184, 182, 182);
            border-bottom: 4px solid rgb(184, 182, 182);
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #left{
            float: left;
        }
        #right{
            float: right;
        }
        input{
            margin: 10px 0px;
        }
        s{
            padding: 5px;
        }
        .error{
            padding: 5px;
            color: rgb(219, 36, 36);
        }
        .resend{
            color: rgb(14, 14, 196);
            padding: 5px;
        }
        .s:hover{
            cursor: pointer;
            background-color:gray;
            color: rgb(243, 237, 237);
            border-radius: 5px;
        }
    </style>

</head>
<body>

    <?php
        $code="";
        $err="";
        $error="";
        if(($_SERVER["REQUEST_METHOD"]=="GET" && $_SESSION['a'] === 'a') || isset($_POST['confirm']) || isset($_POST['resend']))
        {    
            unset($_SESSION['a']);
            if($_SERVER["REQUEST_METHOD"]=="POST")
            {   
                if(isset($_POST['confirm']))
                {
                    if(empty($_POST['code']))
                    {
                        $err="Enter the code!";
                    }
                    elseif(empty($_POST['pass']))
                    {
                        $err="Enter the password!";
                    }
                    else
                    {
                        $code=$_POST['code'];
                        if(password_verify($code,$_SESSION['code']))
                        {
                            $email=$_SESSION['email'];
                            $password=password_hash($_POST['pass'],PASSWORD_DEFAULT);

                            require_once('../all_utils/connection.php');
                            $mysql = "UPDATE identity_table SET password='$password' WHERE email='$email'";
                            if(mysqli_query($conn,$mysql) === FALSE) 
                            {
                                $err="Error! Could not update password"; 
                            }
                            else
                            {
                                unset($_SESSION['code']);
                                header("location: ../welcome/welcome.php");
                            }
                        }
                        else
                        {
                            $err="Incorrect code!";
                        }

                    }
                }
                elseif(isset($_POST['resend']))
                {
                    require_once('mail.php');
                    $error="OTP has been sent again!";
                }
            }
        }
        else{
            header("location:../signup.php");
        }
    ?>

    <div class="cont">
        <h2>Verification Of Email</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <label for="verification">Enter the 5 digit code</label>
            <br/>
            <input type="text" name="code" placeholder="Eg. 12345" value="<?php echo $code; ?>">
            <br/>
            <label for="password">Enter new password</label>
            <br/>
            <input type="password" name="pass" placeholder="">
            <br/>
            <div class="error"><?php echo $err; ?></div>
            <div class="resend"><?php echo $error?></div>
            <input type="submit" name="resend" class="s" id="left" value="Resend OTP">
            <input type="submit" name="confirm" class="s" id="right" value="Confirm">
        </form>
    </div>
</body>
</html>