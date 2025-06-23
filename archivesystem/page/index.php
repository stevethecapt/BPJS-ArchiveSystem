<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../page/regist.php");
    exit();
}

echo "Selamat datang di Dashboard, User ID: " . $_SESSION['name'];
?>

<a href="../files/upload.php">Upload File</a>
<button href="../logout.php">Logout</button>