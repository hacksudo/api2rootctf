<?php 
session_save_path("/tmp");
session_start(); 
include "db.php"; 
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<title>hacksudo API</title>
<h1>LOGIN</h1>

<form method="post">
<input type="text" name="email" placeholder="Email"><br>
<input type="password" name="password" placeholder="Password"><br>
<button type="submit" name="login">Login</button>
</form>

<a href="forgot.php">Forgot Password?</a>

<?php
if(isset($_POST['login'])){
  $email=$_POST['email'];
  $pass=md5($_POST['password']);

  $q=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$pass'");
  
  if(mysqli_num_rows($q)==1){
    $_SESSION['email']=$email;
    echo "<script>location.href='dashboard.php'</script>";
  } else {
    echo "<p class='error'>❌ Invalid credentials</p>";
  }
}
?>
</div>
<center><h4>Coded by Vishal Waghmare </h4>
<!--  "api_v3.php?action=sendotp&email=admin@example.com" reset your email password if any issue  --> 
