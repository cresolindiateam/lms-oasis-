<?php
session_start();
require 'dbconfig.php'; 
if(isset($_SESSION['proj_team_id']))
{
  header("location: leads_list.php");
}
if(isset($_POST['SignIn']) && $_POST['SignIn']!='')
{ 
 if(isset($_POST['username'])&&  $_POST['username']!='' && isset($_POST['password'])&&  $_POST['password']!='')
	{
      $username=$_POST['username'];
      $password= md5($_POST['password']); 
      $sql="select id,name,email,password,phone_number,project_id,role_type from project_team  where team_hidden_status=0 and name=?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result = $stmt->get_result();
      $count=mysqli_num_rows($result); 
     if($count>0)
     { // Super Admin 
      while ($row = $result->fetch_assoc()) 
      {  
       if($password==$row["password"])  
       {   
         $SessionStatus=true;
         session_start();
         $_SESSION['valid'] = true;
         $_SESSION['timeout'] = time();
         $_SESSION['proj_info_id'] =$row['project_id'];
         $_SESSION['proj_team_id'] = $row["id"];
         $_SESSION['role_type'] = $row["role_type"];
         $_SESSION['team_member_name'] = $row["name"];
          header("Location: leads_list.php");
         $LogedInMessage="You are successfully Logged In..";
         echo "<script type='text/javascript'>alert('$LogedInMessage')</script>";
       } 
       else
       {
       $failed=1;
       $UsernameError="Invalid User or Password! Enter valid details.";
       echo "<script type='text/javascript'>alert('$UsernameError')
       
       setTimeout(() => { 
    window.location.href=window.location.origin;
}, 1000);
       
       </script>";
       
    
       exit;
       }
    }
   } 
    else
       {
       $failed=1;
       $UsernameError="Invalid User or Password! Enter valid details.";
       echo "<script type='text/javascript'>alert('$UsernameError')
          setTimeout(() => { 
    window.location.href= window.location.origin;
  
}, 500);
       
       </script>";
       exit;
       }
  }
else{
            $failed=1;
              $UsernameError="Username or Password can not be empty.";
              echo "<script type='text/javascript'>alert('$UsernameError')
              
              
                 setTimeout(() => { 
    window.location.href=window.location.origin;
   
}, 500);
              
              </script>";
              exit;
  }
}  
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Realstate</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  
  </div>

 

  <!-- /.login-logo -->
  <div class="login-box-body">
 <!--  <img src="dist/img/logo.jpg"> -->
 <div class="mycompany-name">
Admin
 <!--  <p>To ensure that the quality repair done</p> -->
  </div>
    <hr>
    <img src="dist/img/logo.jpg" style="display: none;">
    <div class="theme-form">
    <form action="index.php" method="post">
          <div class="login-header" style="display:none">Sign in to Admin Panel</div>
          <div class="login-inner-box">
      <div class="form-group has-feedback">

      <label style="display:none">Username</label>
        <input type="text" class="form-control" placeholder="Username" name="username">
        <i class="fa fa-user login-inner-icon"></i>
     </div>
     
      <div class="form-group has-feedback">
      <label style="display:none">Password</label>
        <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off">
        <i class="fa fa-lock login-inner-icon"></i>
      </div>

      <div class="row">
        
        <!-- /.col -->
        <div class="col-xs-12">
        <center><input type="submit" name="SignIn" class="btn theme-btn " value="Sign In" /></center>
          
        </div>
        <!-- /.col -->
      </div>
       </div>

      </div>
    </form>
    </div>
   
 <div class="designby-text">Designed By <a href="http://www.cresol.in/" target="blank">Cresol.in</a></div>
  </div>

 
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
