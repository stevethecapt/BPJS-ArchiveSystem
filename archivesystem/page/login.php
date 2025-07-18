<?php
session_start();
require_once '../config/database.php';

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Password salah.";
                $status = "error";
            }
        } else {
            $message = "Username tidak ditemukan.";
            $status = "error";
        }
    } catch (PDOException $e) {
        $message = "Kesalahan saat login: " . $e->getMessage();
        $status = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - BPJS Kesehatan</title>
</head>
<body>

  <div class="welcome-message">
    <h1>Selamat Datang</h1>
    <p>Silakan Login untuk mengakses Data Arsip Digital.</p>
  </div>

  <div class="container">
    <h2>Login</h2>

    <?php if (!empty($message)): ?>
      <div class="notification <?= $status; ?>">
        <?= $message; ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <label for="login-username">Username</label>
      <input type="text" id="login-username" name="username" placeholder="Your Username" required />
      <div class="error-message" id="login-username-error"></div>

      <label for="login-password">Password</label>
      <input type="password" id="login-password" name="password" placeholder="Enter Your Password" required />
      <div class="error-message" id="login-password-error"></div>
      <div class="forgetpassword" onclick="window.location.href='resetpassword.php'">Forget Your Password? Reset Here</div>
      <button type="submit">Login</button>
      <div class="toggle-link" onclick="window.location.href='register.php'">Don't have an account? Register</div>
      <div class="logo-container">
        <img src="../img/bpjs.png" alt="Logo BPJS Kesehatan" class="bpjs-logo" />
      </div>
    </form>
  </div>
</body>
</html>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: linear-gradient(135deg,rgb(0, 105, 210) 0%,rgb(207, 160, 255) 80%);
      display: flex;
      height: 100vh;
      align-items: center;
      justify-content: center;
      color: #333;
      flex-wrap: wrap;
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
      color: #333;
    }
    .welcome-message {
      max-width: 500px;
      margin-right: 240px;
      color: #cbe4ff;
      text-align: left;
    }
    .welcome-message h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
      color: #fff;
    }
    .welcome-message p {
      font-size: 1.2rem;
      margin-bottom: 20px;
      color: #fff;
    }
    h2 {
      margin-bottom: 24px;
      font-weight: 600;
      text-align: center;
      color: #004a7c;
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
    input[type="password"] {
      padding: 10px 14px;
      margin-bottom: 18px;
      border: 1.8px solid #ddd;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }
    input:focus {
      border-color: #005f9e;
      outline: none;
    }
    button {
      background:rgb(3, 148, 233);
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
      background:rgb(53, 161, 255);
    }
    .toggle-link {
      margin-top: 16px;
      text-align: center;
      font-size: 0.9rem;
      color: #009639;
      cursor: pointer;
      user-select: none;
    }
    .toggle-link:hover {
      text-decoration: underline;
    }
    .forgetpassword {
      font-size: 0.8rem;
      color: rgb(53, 53, 53);
      cursor: pointer;
      user-select: none;
      margin-bottom: 16px;
    }
    .toggle-link:hover {
      text-decoration: underline;
    }
    .error-message {
      color: #e53e3e;
      font-size: 0.85rem;
      margin-top: -14px;
      margin-bottom: 14px;
    }
    .notification {
      margin-bottom: 20px;
      padding: 12px;
      text-align: center;
      border-radius: 8px;
    }
    .notification.error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
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