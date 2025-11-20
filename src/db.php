<?php

// Start session only once here globally
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Static DB host (won't break now)
$host = "mysql"; // must match docker-compose service name;
$user = "root";
$pass = "root";
$db   = "vulnreset";

// Retry logic (wait for DB)
$attempt = 0;
while ($attempt < 10) {
    $conn = @mysqli_connect($host, $user, $pass, $db);
    if ($conn) break;
    sleep(2);
    $attempt++;
}

// Stop script if DB unavailable
if (!$conn) {
    die("<h2 style='color:red;'>❌ Cannot connect to MySQL at <b>$host</b></h2>");
}
?>
