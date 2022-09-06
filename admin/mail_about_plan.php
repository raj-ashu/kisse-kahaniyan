<?php
    $to = $email;
    $subject = "Message from StoryTeller";
    $txt ='
    <!DOCTYPE html>
    <html>
    <body>
    <div>
        <h2>Hello,$email</h2>
        <p>Your plan is going to expire within one day.Please Re-subscribe once again</p>
        <!--  provide link of your website here -->
        <p><a href="">Click here to login</a></p>
    </div>    
    </body>
    </html>';
    
    $headers = "From: storyteller@gmail.com" . "\r\n";
    $headers = "MIME-Version:1.0\r\n";
    $headers .= "Content-type:text/html;charset=ISO-8859-1" . "\r\n";
    $x=mail($to,$subject,$txt,$headers);
?>