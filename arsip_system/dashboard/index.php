<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

echo "Selamat datang di Dashboard, User ID: " . $_SESSION['name'];
?>

<a href="../files/upload.php">Upload File</a>
<a href="../logout.php">Logout</a>
