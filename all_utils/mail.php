<?php
    $cod=mt_rand(10000,99999);
    $_SESSION['code']=password_hash($cod,PASSWORD_DEFAULT);

    $email=$_SESSION['email'];
    $to = $email;
    $subject = "OTP from StoryTeller";
    $txt ="
    <!DOCTYPE html>
    <html>
    <head>
        <title>OTP from StoryTeller for Signup</title>
    </head>
    <body>
        
            <div>
                <h2>Hello,$email</h2>
                <p>The OTP for Email confirmation is</p>
                <p><em>$cod</em> </p>
            </div>
        
    </body>
    </html>";
    
    $headers = "From: storyteller@gmail.com" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $x=mail($to,$subject,$txt,$headers);


?>
