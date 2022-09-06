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
        $free_trial_status = $r['free_trial_status'];
        if($r['days_left']>0)
        {
            header("location:../final_page/ultimate_page.php");
        }
      }
      else
      {
          header("location:../login.php");
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
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <div class="navbar">
    <div class="logo" onclick="openNav()">&#9776;</div>
    <div class="nav_title">
    <div class="icon"><img src="https://i.pinimg.com/originals/60/74/40/607440e61f5c28a0bf3acaaeaa155075.jpg" alt=""></div>
    <div class="nav_head">My Webpage</div>
  </div>
    <ul id="Nav">
        <li onclick="closeNav()" id="closeNav">&times;</li>
        <li><a href="#">Hello<br><?php echo $_SESSION['name']?></a></li>
        <li><a href="../blogs/">Blogs</a></li>
        <li><a href="../all_utils/logout.php">LogOut</a></li>
    </ul>
</div>
<div class="container">
  <h2 style="text-align: center; color: blanchedalmond;">Please choose any of the three plan...</h2>
  <div class="cards">
    <?php
      if($free_trial_status != "done")
        {
        ?>  
          <div class="pages">
            <div class="header">Try Our Free Trail for 7 Days</div>
            <div class="para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic ad tenetur repudiandae, molestiae quo fugit rerum voluptates at placeat perspiciatis vitae adipisci earum animi deserunt delectus eligendi. Exercitationem maiores deleniti corporis ex repellat fugiat ullam, inventore repellendus quidem veritatis nisi libero obcaecati nihil excepturi maxime aperiam? Eos dolor rem veritatis!</div>
            <div class="btn"><a href="./free_trial.php">Try It Now</a></div>
          </div>
        <?php
        }
        ?>        
    <div class="pages">
      <div class="header">Join Membership For 1 Month</div>
      <div class="para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic ad tenetur repudiandae, molestiae quo fugit rerum voluptates at placeat perspiciatis vitae adipisci earum animi deserunt delectus eligendi. Exercitationem maiores deleniti corporis ex repellat fugiat ullam, inventore repellendus quidem veritatis nisi libero obcaecati nihil excepturi maxime aperiam? Eos dolor rem veritatis!</div>
      <div class="btn"><a href="../paykun-php-master/paykun-php-master/demo/request.php?cost=100">Join Now</a></div>
    </div>
    <div class="pages" id="page3">
      <div class="header">Join Membership For 3 Months </div>
      <div class="para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic ad tenetur repudiandae, molestiae quo fugit rerum voluptates at placeat perspiciatis vitae adipisci earum animi deserunt delectus eligendi. Exercitationem maiores deleniti corporis ex repellat fugiat ullam, inventore repellendus quidem veritatis nisi libero obcaecati nihil excepturi maxime aperiam? Eos dolor rem veritatis!</div>
      <div class="btn"><a href="../paykun-php-master/paykun-php-master/demo/request.php?cost=250">Join Now</a></div>
    </div>        
  </div>
  <footer>
    <hr>
    <div class="para" style="text-align: center;">CopyRight@2020 | All Rights Reserved.</div>
  </footer>
<script>
  function openNav(){
            document.getElementById("Nav").style.width="250px";
        }
        function closeNav(){
            document.getElementById("Nav").style.width="0px";
        }
</script>
</body>
</html>