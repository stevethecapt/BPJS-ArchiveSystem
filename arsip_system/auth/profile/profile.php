<?php
session_start();
require_once("../../config/database.php");

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT fullname, username, email, phone, address FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
    $stmt->execute([$username, $email, $user_id]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        $message = "Username atau email sudah digunakan!";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        if ($stmt->execute([$fullname, $username, $email, $phone, $address, $user_id])) {
            $_SESSION['fullname'] = $fullname;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['address'] = $address;
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Terjadi kesalahan saat memperbarui profil!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Update Profile</title>
</head>
<body>
<nav>
    <img src="img/bpjs.png" class="img">
    <div class="top-right">
        <a href="javascript:void(0);" onclick="toggleProfilePopup()" style="text-decoration: none; color: black; font-weight: bold;">
            <?php if (isset($_SESSION['username'])): ?>
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            <?php endif; ?>
        </a>

        <div id="profilePopup" style="display: none; position: absolute; top: 75px; right: 0; width: 250px; padding: 20px; background: white; border-radius: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); text-align: center;">
            <div style="width: 80px; height: 80px; background: #ddd; border-radius: 50%; margin: auto; position: relative;">
                <span style="position: absolute; bottom: 0; right: 0; background: #4CAF50; width: 20px; height: 20px; border-radius: 50%; font-size: 14px; color: white; text-align: center;">+</span>
            </div>
            
            <p style="font-size: 18px; font-weight: bold; margin-top: 10px;"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p style="font-size: 14px; color: #666;">
                <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'example@youremail.com'; ?>
            </p>
            <p style="font-size: 14px; color: #666;">
                <?php echo isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : 'Your Number'; ?>
            </p>
            <p style="font-size: 14px; color: #666;">
                <?php echo isset($_SESSION['address']) ? htmlspecialchars($_SESSION['address']) : 'Your Address'; ?>
            </p>
            <a href="logout.php" style="display: block; background: #f44336; color: white; text-decoration: none; padding: 10px; border-radius: 10px; margin-top: 5px;">Logout</a>
        </div>

        <script>
        function toggleProfilePopup() {
            var popup = document.getElementById("profilePopup");
            popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
        }
        </script>
    </div>
</nav>
    <div class="container">
        <h2>Update Profile</h2>

        <?php if (isset($message)) : ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" placeholder="Nama Lengkap" required>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" placeholder="Username" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Email" required>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="Nomor Telepon" required>
            <textarea name="address" placeholder="Alamat" required><?php echo htmlspecialchars($user['address']); ?></textarea>
            <button href="../dashboard.php" type="submit">Update</button>
        </form>
    </div>
</body>
</html>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        nav {
            width: 100%;
            background: #fff;
            position: fixed;
            top: 0;
            left: 0;
            padding: 15px 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
        }

        .img {
            height: 38px;
            width: 180px;
            object-fit: cover;
        }

        .top-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .username {
            font-weight: bold;
            font-size: 1rem;
            color: #333;
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
            text-align: left;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s ease-in-out;
        }
        input:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        textarea {
            resize: none;
            height: 80px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s ease-in-out;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>