<?php
session_save_path("/tmp");
session_start();

if(!isset($_SESSION['email'])){
    die("<h2 style='color:red'>❌ Not logged in</h2><p><a href='index.php'>Go to Login</a></p>");
}
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h1>Dashboard</h1>
<p>Welcome <b><?php echo $_SESSION['email']; ?></b> 👋</p>

<hr style="border:1px solid #00ff00;">

<h2>📁 Upload Profile Picture</h2>
<p>(Allowed: <b>jpg, jpeg, png</b>) — *but try bypass 😉*</p>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file"><br>
    <button type="submit" name="upload">Upload</button>
</form>

<?php

// Vulnerable upload logic
if(isset($_POST['upload'])){

    $file = $_FILES['file']['name'];
    $tmp  = $_FILES['file']['tmp_name'];

    // Allowed UI extensions only (weak filter)
    $allowed = ['jpg', 'jpeg', 'png'];

    // 🚨 Vulnerability: Checks ONLY the last extension (pathinfo)
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if(!in_array($ext, $allowed)){
        echo "<p class='error'>❌ Only JPG, JPEG, PNG allowed!</p>";
    } else {

        // ❗ No MIME validation
        // ❗ No filename sanitization
        // ❗ Upload directory executable
        $uploadPath = "uploads/" . basename($file);

        if(move_uploaded_file($tmp, $uploadPath)){
            echo "<p class='success'>✔ File uploaded successfully!</p>";
            echo "<p class='success'>🔗 <a href='$uploadPath' target='_blank'>$file</a></p>";
            echo "<p>💀 Try executing: <code>$uploadPath?cmd=id</code></p>";
        } else {
            echo "<p class='error'>❌ Upload failed.</p>";
        }
    }
}
?>

<hr style="border:1px solid #00ff00; margin-top:20px;">

<p><a href="index.php" class="btn">Logout</a></p>

</div>
