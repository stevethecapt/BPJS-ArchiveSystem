<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $uploadDir = "../uploads/";

    if (move_uploaded_file($fileTmp, $uploadDir . $fileName)) {
        echo "File berhasil diupload!";
    } else {
        echo "Gagal mengupload file!";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    Pilih file: <input type="file" name="file" required><br>
    <button type="submit">Upload</button>
</form>
