<?php 
include "db.php"; 
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h1>Reset Password</h1>

<form method="post">
    <input type="text" name="otp" placeholder="Enter OTP" required><br>
    <input type="password" name="newpass" placeholder="New password" required><br>
    <input type="password" name="confpass" placeholder="Confirm password" required><br>

    <input type="hidden" name="email" value="<?=$_GET['email'];?>">
    <input type="hidden" name="api" value="<?=$_GET['api'];?>">
    <button type="submit">Reset Password</button>
</form>

<?php

if($_POST){

    $email   = $_POST['email'];
    $otp     = $_POST['otp'];
    $api     = $_POST['api'];
    $pass    = $_POST['newpass'];
    $conf    = $_POST['confpass'];

    if($pass !== $conf){
        echo '<div class="error-box">❌ Passwords do not match.</div>';
        exit;
    }

    $hashed = md5($pass);

    $apiURL = "http://localhost/api_$api.php?action=reset&email=$email&otp=$otp&password=$hashed";
    $res    = @file_get_contents($apiURL);

    if ($res && str_contains(strtolower($res), "successful")) {

        echo '<div class="success-box">';
        echo '<h2>🎉 Password Reset Successful!</h2>';
        echo '<p>🔑 <strong>New Password:</strong> '.$pass.'</p>';
        echo '<p><a href="index.php" class="btn">Login Now</a></p>';
        echo '</div>';

    } else {
        echo '<div class="error-box">❌ '.htmlspecialchars($res ?? "Unknown error").'</div>';
    }
}
?>
</div>
