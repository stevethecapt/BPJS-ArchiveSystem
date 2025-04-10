<?php
session_start();  // Memulai session

// Menghapus session variables
session_unset();

// Menghancurkan session
session_destroy();

// Menghapus cookie session jika digunakan
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

// Redirect ke halaman login setelah logout
header("Location: login.php");
exit();
?>
