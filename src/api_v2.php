<?php
include "db.php";

// Safely read values (avoid undefined index warning)
$email  = $_GET['email']  ?? null;
$action = $_GET['action'] ?? null;
$otp    = $_GET['otp']    ?? null;
$pwd    = $_GET['password'] ?? null;

// If accessed without parameters → deny access
if (!$action) {
    die("❌ Missing action parameter");
}

// Vulnerable: No rate limit, No validation → intentional for the lab
if ($action == "sendotp") {

    if (!$email) {
        die("❌ Email missing");
    }

    // Generate a weak predictable OTP
    $otp = rand(1000,9999);

    mysqli_query($conn,"UPDATE users SET otp='$otp' WHERE email='$email'");

    die("📩 OTP Generated (Insecure API v2):");
}

if ($action == "reset") {

    if (!$email || !$otp || !$pwd) {
        die("❌ Missing required fields");
    }

    $q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND otp='$otp'");

    if (mysqli_num_rows($q) == 1) {

        mysqli_query($conn,"UPDATE users SET password='$pwd', otp=NULL WHERE email='$email'");

        die("Password reset successful (V2 bypass)");
    
    } else {
        die("❌ Invalid OTP");
    }
}

die("❌ Invalid action");
?>
