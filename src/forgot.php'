<?php include "db.php"; ?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h1>Forgot Password</h1>

<form method="post">
<input type="email" name="email" placeholder="Enter your email" required><br>

<!-- Hidden field: attacker can modify using Burp --> 
<input type="hidden" name="api" value="v3">

<button type="submit">Send OTP</button>
</form>

<?php
if($_POST){
  $email=$_POST['email'];
  $api=$_POST['api'];

  $apiURL="http://localhost:8080/api_$api.php?action=sendotp&email=$email";
  @file_get_contents($apiURL);

  echo "<p class='success'>📩 If this account exists, an OTP has been generated.</p>";
  echo "<p><a href='reset.php?api=$api&email=$email'>Continue to reset</a></p>";
}
?>
</div>
