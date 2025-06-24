<?php
session_start();
require_once("../config/database.php");

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $new_password = $_POST['password'];
    if (!empty($username) && !empty($email) && !empty($new_password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
            $stmt->execute([$username, $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $updateStmt->execute([$hashed_password, $user['id']]);
                $message = "Password berhasil direset. Silakan login.";
                header("Refresh:2; url=login.php");
            } else {
                $message = "Username dan email tidak cocok atau tidak ditemukan.";
            }
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan: " . $e->getMessage();
        }
    } else {
        $message = "Semua field wajib diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Password - BPJS Kesehatan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  <div class="container">
    <h2>Reset Password</h2>

    <?php if (!empty($message)): ?>
      <div class="error-message"><?= $message; ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Masukkan username Anda" required />

      <label for="login-email">Email</label>
      <input type="email" id="login-email" name="email" placeholder="you@example.com" required />
      
      <label for="login-password">New Password</label>
      <div class="password-wrapper">
        <input type="password" id="login-password" name="password" placeholder="Enter your new password" required />
        <i class="fas fa-eye eye-icon" id="togglePassword" onclick="togglePasswordVisibility()"></i>
      </div>

      <button type="submit">Reset Password</button>
      <div class="toggle-link" onclick="window.location.href='login.php'">
        Already have an account? Login
      </div>
    </form>
  </div>

  <script>
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('login-password');
      const eyeIcon = document.getElementById('togglePassword');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
* { box-sizing: border-box; }
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg,rgb(255, 128, 116),rgb(102, 119, 179));
    margin: 0;
    display: flex;
    height: 100vh;
    align-items: center;
    justify-content: center;
    color: #333;
}
.container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    max-width: 400px;
    width: 90%;
    padding: 40px 30px;
    position: relative;
}
h2 {
    margin-bottom: 24px;
    font-weight: 600;
    text-align: center;
    color:rgb(67, 67, 67);
}
form {
    display: flex;
    flex-direction: column;
}
label {
    font-size: 0.9rem;
    margin-bottom: 6px;
    color: #555;
}
input[type="text"],
input[type="email"],
input[type="password"] {
    padding: 10px 14px;
    margin-bottom: 18px;
    border: 1.8px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
    position: relative;
}
input[type="password"] {
    padding-right: 40px;
}
input:focus {
    border-color: #009639;
    outline: none;
}
.eye-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #555;
}
button {
    background:rgb(253, 88, 73);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    padding: 12px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s;
}
button:hover {
    background: #FF6F61;
}
.toggle-link {
    margin-top: 16px;
    text-align: center;
    font-size: 0.9rem;
    color: #0056b3;
    cursor: pointer;
    user-select: none;
}
.toggle-link:hover {
    text-decoration: underline;
}
.error-message {
    color: #e53e3e;
    font-size: 0.9rem;
    text-align: center;
    margin-bottom: 16px;
}
.password-wrapper {
    position: relative;
}
</style>