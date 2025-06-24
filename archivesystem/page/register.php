<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
        $message = "Semua field harus diisi.";
    } else {
        try {
            $check = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
            $check->execute([
                'username' => $username,
                'email' => $email
            ]);
            if ($check->fetch()) {
                $message = "Username atau email sudah digunakan.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, password) VALUES (:fullname, :username, :email, :password)");
                $stmt->execute([
                    'fullname' => $fullname,
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashedPassword
                ]);
                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan: " . $e->getMessage();
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
    background: linear-gradient(135deg,rgb(40, 195, 99),rgb(184, 182, 85));
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
    background: rgb(19, 166, 93);
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
    background: rgb(99, 219, 159);
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