<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .navbar {
        width: 100%;
        position: sticky;
        top: 0;
        background-color: brown;
    }

    .header {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .header h2 {
        color: burlywood;
        margin: 15px 0;
    }

    .nav_down {
        background-color: rgb(128, 71, 31);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .box {
        display: flex;
    }

    .tab {
        padding: 3px 10px;
        margin: 10px;
        border-radius: 3px;
        color: rgb(34, 6, 6);
    }

    #insert {
        margin: 130px 0 0 0;
    }

    form {
        margin: 100px 0 20px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .sub_heading {
        text-align: center;
        font-size: 1.3rem;
        background-color: rgb(184, 153, 96);
        padding: 10px;
        border-radius: 5px;
    }

    textarea {
        padding: 10px 5px 0px 5px;
        margin: 10px 0;
    }

    textarea,
    .itm {
        width: 70%;
    }

    #submit {
        padding: 5px 10px;
    }

    .categorize {
        padding: 10px;
    }

    .itm {
        padding: 5px 10px;
        margin: 10px;
    }

    .bcolor {
        text-align: center;
        background-color: burlywood;
    }

    .btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 50%;
    }
    a{
        text-decoration : none;
        color:black;
    }
</style>

<body>

<?php
    $val1=0;
    $val2=0;
    $val3=0;
    $val4=0;
    $err="";
    
    if(isset($_POST['add_story']))    
    {
        require_once('update.php');
        if(empty($_POST['category']) || empty($_POST['heading']) ||empty($_POST['content']))
        {
            $err="Enter all details";
        }
        else
        {
            $head=$_POST['heading'];
            $para=$_POST['content'];
            $category=$_POST['category'];
            $today = date("y-m-d");
            require_once('../all_utils/connection.php');
            $mysql="INSERT INTO story_data(heading,content,category,doe) VALUES ('$head','$para','$category','$today')";
            if(mysqli_query($conn,$mysql) === FALSE) 
            {
                $err="Error! Could not insert";
            }
            else
            {
                require_once('../all_utils/connection.php');
                $sql = "SELECT * FROM identity_table WHERE days_left > 0";
                $result = $conn->query($sql);    
                if ($result->num_rows > 0) 
                {   
                    while($row = $result->fetch_assoc())
                    {
                        $email = $row['email'];
                        require_once('content_addion_mail.php');
                    }
                }
                $err="Added successfully";
        
            }
    
        }    
    }
    else if(isset($_POST['delete']))
    {
        if(empty($_POST['email']))
        {
            $err="Enter email!";
        }
        else
        {
            $email=$_POST['email'];
            require_once('../all_utils/connection.php');
            $sql = "DELETE FROM identity_table WHERE email='".$email."'";
            if ($conn->query($sql) === TRUE)
            {
                $err="Record deleted successfully";
            }
            else
            {
                $err="Email not found";
            }
        }
        require_once('update.php');
    }
    else if(isset($_POST['block']))
    {
        if(empty($_POST['email']))
        {
            $err="Enter email!";
        }
        else
        {
            $email=$_POST['email'];
            require_once('../all_utils/connection.php');
            $sql = "UPDATE identity_table SET days_left=0,subs_category='1' WHERE email='".$email."'";
            if ($conn->query($sql) === TRUE)
            {
                $err="Record blocked successfully";
            }
            else
            {
                $err="Email not found";
            }
        }
        require_once('update.php');
    }
    else if(isset($_POST['update']))
    {
        require_once('../all_utils/connection.php');
        $mysql = "SELECT * FROM identity_table";
        $result = $conn->query($mysql);    
        if ($result->num_rows > 0) 
        {   
            $flag1 = 2;
            $flag2 = 2; 
            while($row = $result->fetch_assoc())
            {
                
                $email = $row['email'];
                $bday = new DateTime($row['dob']);
                $doa = new DateTime($row['doa']);
                $today = new DateTime(date('m.d.y'));
                $diff1 = $today->diff($bday);
                $diff2 = $today->diff($doa);
                $subs_category =$row['subs_category'];
                $age = $diff1->y;
                
                if($age >= 3 && $age <= 6)
                {
                    $cat = "1";
                }
                elseif($age >= 7 && $age <= 10)
                {
                    $cat = "2";
                }
                $year=$diff2->y;
                $mnth=$diff2->m;
                $dayss = $diff2->d;
                
                $day = ($year)*365 + ($mnth)*30 + $dayss;

                if($subs_category === '1')
                {
                    $days =0;
                }
                if($subs_category === '2')
                {
                    $days = 7-$day;
                    if($days<0)
                    {
                        $days =0;
                    }
                }
                else if($subs_category === '3')
                {
                    $days = 30-$day;
                    if($days<0)
                    {
                        $days =0;
                    }
                }
                if($subs_category === '4')
                {
                    $days = 90-$day;
                    if($days<0)
                    {
                        $days =0;
                    }
                }

                if($days === 1)
                {
                    require_once("mail_about_plan.php");
                }
                elseif($days === 0)
                {
                    require_once('../all_utils/connection.php');
                    $xyz = "UPDATE identity_table SET subs_category = '1' WHERE email='".$email."'";
                }

                require_once('../all_utils/connection.php');
                $sql = "UPDATE identity_table SET age_category = $cat WHERE email='".$email."'";
                if ($conn->query($sql) === FALSE)
                {
                    $flag1 = 1;
                }
                require_once('../all_utils/connection.php');
                $sql = "UPDATE identity_table SET days_left= $days WHERE email='".$email."'";
                if ($conn->query($sql) === FALSE)
                {
                    $flag2 = 1;
                }
            }
            if($flag1 === 1 || $flag2 === 1)
            {
                $err = "Some data may not get updated due to technical error <br/> Please contact service provider";
            }
            else{
                $err = "Update completed";
            }
            echo $err;
        }
        else
        {
            echo "0 results";
        }
        require_once('update.php');
    }
    else if(isset($_POST['view_stats']))
    {
        require_once('update.php');
            
    }
    else if(isset($_POST['View_all_reg']))
    {
        require_once('update.php');
        require_once('../all_utils/connection.php');
        $sql = "SELECT * FROM identity_table";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0)
        {
            echo '<table style="width:100%">';
            echo "<tr>";
            echo '<th>Id</th><th>NAME</th><th>EMAIL</th><th>DOB</th><th>MOBILE NUMBER</th><th>DAYS LEFT</th><th>age_category</th><th>subscription_category</th>';
            echo "</tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo '<td>' . $row["id"]. '</td><td>' . $row["name"]. '</td><td>' . $row["email"]. '</td><td>' .$row["dob"]. '</td><td>' .$row["tel"]. '</td><td>' .$row["days_left"]. '</td><td>' .$row["age_category"]. '</td><td>' .$row["subs_category"]. '</td>';
                echo "</tr>";
            }
            echo '</table>';
        }
        else
        {
            echo "0 results";
        }
        
    }
    else if(isset($_POST['View_all_freesubs']))
    {
        require_once('update.php');
        require_once('../all_utils/connection.php');
        $sql = "SELECT * FROM identity_table WHERE subs_category='2' AND days_left > 0";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            echo '<table style="width:100%">';
            echo "<tr>";
            echo '<th>Id</th><th>NAME</th><th>EMAIL</th><th>DOB</th><th>MOBILE NUMBER</th><th>DAYS LEFT</th><th>age_category</th><th>subscription_category</th>';
            echo "</tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo '<td>' . $row["id"]. '</td><td>' . $row["name"]. '</td><td>' . $row["email"]. '</td><td>' .$row["dob"]. '</td><td>' .$row["tel"]. '</td><td>' .$row["days_left"]. '</td><td>' .$row["age_category"]. '</td><td>' .$row["subs_category"]. '</td>';
                echo "</tr>";
            }
            echo '</table>';
        }
        else
        {
            echo "0 results";
        }
    }

    else if(isset($_POST['View_all_1mnthsubs']))
    {
        require_once('update.php');
        require_once('../all_utils/connection.php');
        $sql = "SELECT * FROM identity_table WHERE subs_category='3' AND days_left > 0";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            echo '<table style="width:100%">';
            echo "<tr>";
            echo '<th>Id</th><th>NAME</th><th>EMAIL</th><th>DOB</th><th>MOBILE NUMBER</th><th>DAYS LEFT</th><th>age_category</th><th>subscription_category</th>';
            echo "</tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo '<td>' . $row["id"]. '</td><td>' . $row["name"]. '</td><td>' . $row["email"]. '</td><td>' .$row["dob"]. '</td><td>' .$row["tel"]. '</td><td>' .$row["days_left"]. '</td><td>' .$row["age_category"]. '</td><td>' .$row["subs_category"]. '</td>';
                echo "</tr>";
            }
            echo '</table>';
        }
        else
        {
            echo "0 results";
        }
    }
    else if(isset($_POST['View_all_3mnthsubs']))
    {
        require_once('update.php');
        require_once('../all_utils/connection.php');
        $sql = "SELECT * FROM identity_table WHERE subs_category='4' AND days_left > 0";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            echo '<table style="width:100%">';
            echo "<tr>";
            echo '<th>Id</th><th>NAME</th><th>EMAIL</th><th>DOB</th><th>MOBILE NUMBER</th><th>DAYS LEFT</th><th>age_category</th><th>subscription_category</th>';
            echo "</tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo '<td>' . $row["id"]. '</td><td>' . $row["name"]. '</td><td>' . $row["email"]. '</td><td>' .$row["dob"]. '</td><td>' .$row["tel"]. '</td><td>' .$row["days_left"]. '</td><td>' .$row["age_category"]. '</td><td>' .$row["subs_category"]. '</td>';
                echo "</tr>";
            }
            echo '</table>';
        }
        else
        {
            echo "0 results";
        }

    }
    else if(isset($_POST['View_all_transactions']))
    {
        require_once('update.php');
        require_once('../all_utils/connection.php');
        $sql = "SELECT * FROM transaction_details";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            echo '<table style="width:100%">';
            echo "<tr>";
            echo '<th>Id</th><th>NAME OF CUSTOMER</th><th>EMAIL OF CUSTOMER</th><th>DATE OF TRANSACTION</th><th>GROSS AMOUNT</th><th>ORDER ID</th><th>PAYMENT MODE</th><th>PAYMENT ID</th><th>PAYMENT STATUS</th>';
            echo "</tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo '<td>' . $row["id"]. '</td><td>' . $row["cus_name"]. '</td><td>' . $row["email"]. '</td><td>' .$row["date_of_transaction"]. '</td><td>' .$row["gross_amount"]. '</td><td>' .$row["order_id"]. '</td><td>' .$row["payment_mode"]. '</td><td>' .$row["payment_id"]. '</td><td>' .$row["trans_status"]. '</td>';
                echo "</tr>";
            }
            echo '</table>';
        }
        else
        {
            echo "0 results";
        }

    }
    else if(isset($_POST['View_all_feedback']))
    {
        require_once('update.php');
        require_once('../all_utils/connection.php');
        $sql = "SELECT * FROM feed";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            echo '<table style="width:100%">';
            echo "<tr>";
            echo '<th>Id</th><th>NAME OF CUSTOMER</th><th>EMAIL OF CUSTOMER</th><th>FEEDBACK</th>';
            echo "</tr>";
            while($row = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                echo '<td>' . $row["id"]. '</td><td>' . $row["name"]. '</td><td>' . $row["email"]. '</td><td>' .$row["feedback"]. '</td>';
                echo "</tr>";
            }
            echo '</table>';
        }
        else
        {
            echo "0 results";
        }

    }
    elseif($_SERVER["REQUEST_METHOD"]=="GET" && $_SESSION['admin'] === '1') 
    {
        unset($_SESSION['admin']);
        require_once('update.php');
    }
    else
    {
        header("location:admin_panel_login.php");
    }
?>

    <nav class="navbar">
        <div class="header">
            <h2>Welcome to Admin Panel</h2>
            <h4><?php echo $err;?></h4>
        </div>
        <div class="nav_down">
            <div class="box">
                <div class="tab"><a href="#Stats">Stats</a></div>
                <div class="tab"><a href="#Insert">Insert</a></div>
                <div class="tab"><a href="#Edit">Edit</a></div>
                <div class="tab"><a href="#Details">Details</a></div>
            </div>
        </div>
    </nav>
    <div id="Stats"></div>
    <div class="card">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div class="sub_heading">The statistics of customer</div>
            <div class="itm bcolor"><?php echo "Total number of registered users =" .$val1.".";?></div>
            <div class="itm bcolor"><?php echo "Total number of  free trial users =" .$val2.".";?></div>
            <div class="itm bcolor"><?php echo "Total number of one month subscribers =" .$val3.".";?></div>
            <div class="itm bcolor"><?php echo "Total number of three month subscribers =" .$val4.".";?></div>
            <input class="itm" type="submit" name="view_stats" value="Click to update">
        </form>
    </div>
    <div id="Details"></div>
    <div class="card">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div class="sub_heading">View details of customers</div>
            <div class="btn">
                <input class="itm" type="submit" name="View_all_reg" value="View details of all customers">
                <input class="itm" type="submit" name="View_all_freesubs"
                    value="View details of all customers with free trials">
                <input class="itm" type="submit" name="View_all_1mnthsubs"
                    value="View details of all customers with 1 month subscription">
                <input class="itm" type="submit" name="View_all_3mnthsubs"
                    value="View details of all customers with 3 month subscription">
                <input class="itm" type="submit" name="View_all_transactions"
                    value="View details of all transactions">
                <input class="itm" type="submit" name="View_all_feedback"
                    value="View details of all feedback">
            </div>
        </form>
    </div>
    <div id="Insert"></div>
    <div class="card">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div class="sub_heading">Enter Post</div>
            <div class="categorize">
                <input type="radio" name="category" value="1">
                <label for="1">Story(3 to 6 years)</label>
                <input type="radio" name="category" value="2">
                <label for="2">Story(7 to 10 years)</label>
            </div>
            <textarea name="heading" placeholder="Enter the heading"></textarea>
            <textarea name="content" rows="15"
                placeholder="Enter the content(you can also write html code here)"></textarea>
            <input type="submit" name="add_story" id="submit">
        </form>
    </div>
    <div id="Edit"></div>
    <div class="card">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div class="sub_heading">Edit your Database</div>
            <input class="itm" type="email" name="email" style="width: 70%;" placeholder="Enter Email">
            <div class="btn">
                <input class="itm" type="submit" name="delete" value="Delete">
                <input class="itm" type="submit" name="block" value="Block">
                <input class="itm" type="submit" name="update" value="Update age category">
            </div>
        </form>
    </div>

    <?php echo $err;?>
    <script>
        $(".tab").click(function () {
            $(".tab").css('background-color', 'rgb(128, 71, 31)');
            $(this).css('background-color', 'rgb(190, 112, 22)');
        });
    </script>
</body>

</html>