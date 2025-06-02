<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

require_once "../config/database.php";

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']); 
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        $message = "Username atau email sudah digunakan!";
        $status = "error";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, password) VALUES (?, ?, ?, ?)");

        if ($stmt->execute([$fullname, $username, $email, $hashed_password])) {
            $_SESSION['fullname'] = $fullname;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Terjadi kesalahan saat registrasi!";
            $status = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - BPJS Kesehatan</title>
</head>
<body>
  <div class="welcome-message">
    <h1>Selamat Datang</h1>
    <p>Silakan Regist untuk mengakses Data Arsip Digital.</p>
  </div>
  <div class="container">
    <h2>Register</h2>

    <?php if (!empty($message)): ?>
      <div class="error-message"><?= $message; ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
      <label for="full-name">Nama Lengkap</label>
      <input type="text" id="full-name" name="fullname" placeholder="Masukan Nama Lengkap Anda" required />
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Buat Username Anda" required />
      <label for="login-email">Email</label>
      <input type="email" id="login-email" name="email" placeholder="you@example.com" required />
      <label for="login-password">Password</label>
      <input type="password" id="login-password" name="password" placeholder="Enter your password" required />
      <button type="submit">Regist</button>
      <div class="toggle-link" onclick="window.location.href='login.php'">
        Already have an account? Login
      </div>
      <div class="logo-container">
        <img src="../img/bpjs.png" alt="Logo BPJS Kesehatan" class="bpjs-logo" />
      </div>
    </form>
  </div>
</body>
</html>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
  * { box-sizing: border-box; }
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #009639, #66b3a1);
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
    margin-left: 20px;
  }
  .welcome-message {
    max-width: 500px;
    margin-right: 230px;
    color: #fff;
    text-align: left;
  }
  .welcome-message h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
  }
  .welcome-message p {
    font-size: 1.2rem;
    margin-bottom: 20px;
  }
  h2 {
    margin-bottom: 24px;
    font-weight: 600;
    text-align: center;
    color: #00703c;
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
  }
  input[type="text"]:focus,
  input[type="email"]:focus,
  input[type="password"]:focus {
    border-color: #009639;
    outline: none;
  }
  button {
    background: #009639;
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
    background: #007a2c;
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
  @media (max-width: 600px) {
    body {
      flex-direction: column;
    }
    .container {
      margin-left: 0;
      margin-top: 20px;
    }
    .welcome-message {
      text-align: center;
      margin-right: 0;
    }
  }
  .logo-container {
    margin-top: 25px;
    text-align: center;
  }

  .bpjs-logo {
    max-width: 150px;
    height: auto;
    opacity: 0.9;
  }
</style>
