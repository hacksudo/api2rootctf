<?php
include "db.php";

$email  = $_GET['email']  ?? null;
$action = $_GET['action'] ?? null;
$otp    = $_GET['otp']    ?? null;
$pwd    = $_GET['password'] ?? null;

if (!$action) {
    die("❌ Missing action parameter");
}

if ($action == "sendotp") {

    if (!$email) {
        die("❌ Email missing");
    }

    // Rate limit check
    $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT otp_last_sent FROM users WHERE email='$email'"));

    if ($row && (time() - strtotime($row['otp_last_sent']) < 60)) {
        die("⛔ Rate limited: Try again later");
    }

    $otp = rand(1000,9999);
    mysqli_query($conn,"UPDATE users SET otp='$otp', otp_last_sent=NOW() WHERE email='$email'");

    die("OTP sent (secure v3)");
}

if ($action == "reset") {

    if (!$email || !$otp || !$pwd) {
        die("❌ Missing required fields");
    }

    mysqli_query($conn,"UPDATE users SET otp_attempts = otp_attempts + 1 WHERE email='$email'");

    $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT otp, otp_attempts FROM users WHERE email='$email'"));

    if ($row['otp_attempts'] >= 4) {
        die("⛔ Too many attempts — account locked");
    }

    if ($row['otp'] == $otp) {

        mysqli_query($conn,"UPDATE users SET password='$pwd', otp=NULL, otp_attempts=0 WHERE email='$email'");

        die("Password reset successful (secure)");
    }

    die("❌ Invalid OTP");
}

die("❌ Invalid action");
?>
