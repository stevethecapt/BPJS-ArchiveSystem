<?php
require_once "../config/database.php";

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $message = "Login berhasil!";
        $status = "success";
    } else {
        $message = "Username atau password salah!";
        $status = "error";
    }
}
?>

<?php if (!empty($message)): ?>
    <div id="notification" class="notification <?= $status; ?>">
        <?= $message; ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let notif = document.getElementById("notification");
            notif.style.display = "block"; 
            
            setTimeout(function() {
                notif.style.opacity = "1";
                let fadeEffect = setInterval(function () {
                    if (!notif.style.opacity) {
                        notif.style.opacity = "1";
                    }
                    if (notif.style.opacity > "0") {
                        notif.style.opacity -= "0.1";
                    } else {
                        clearInterval(fadeEffect);
                        notif.style.display = "none";
                    }
                }, 100);
            }, 1000);
        });
    </script>
<?php endif; ?>
    <nav>
        <img src="bpjs.png" class="img" alt="logo">
        <div class="top-right">
        <span class="registtext">Don't have an Account?</span>
        <a href="register.php" class="regist">Register</a>
        </div>
    </nav>
<form method="post">
    <h2>Login</h2>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<style>
    nav {
        width: 100%;
        background: #fff;
        overflow: hidden;
        position: fixed;
        top: 0;
        left: 0;
        padding: 30px 0;
        box-shadow:  0px 0px 10px rgba(0, 0, 0, 0.1);
        display: flex;
    }

    nav .img {
        height: 30px; 
        margin-right: 15px;
        align: left;
    }

    .top-right {
        position: fixed;
        height: 30px;
        right: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logintext {
        font-size: 1rem;
        color: #333;
    }

    .regist {
        font-size: 1rem;
        font-weight: 500;
        color: white;
        border: none;
        background: #28a745;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        flex-direction: column;
    }

    .notification {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        text-align: center;
        width: 300px;
        display: none;
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    .notification.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .notification.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    form {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 10px;
        background: #2596be;
        border: none;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .login-form {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }

    .login-form input[type="text"],
    .login-form input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .login-form button {
        width: 100%;
        padding: 10px;
        background: #007bff;
        border: none;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }
</style>