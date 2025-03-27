<?php
require_once("../../config/database.php");

$message = "";
$status = "";

// Mengecek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $fullname = trim($_POST['fullname'] ?? "");
    $username = trim($_POST['username'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? "");
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? "");
    $bidang = trim($_POST['bidang'] ?? "");
    $address = trim($_POST['address'] ?? "");

    // Validasi: Pastikan kolom yang wajib diisi tidak kosong
    if (!empty($fullname) && !empty($phone) && !empty($address)) {
        try {
            // Cek apakah data sudah ada untuk update atau insert data baru
            if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
                // Update data jika ada user_id
                $stmt = $pdo->prepare("UPDATE users SET fullname = ?, username = ?, email = ?, phone = ?, tanggal_lahir = ?, jenis_kelamin = ?, bidang = ?, address = ? WHERE id = ?");
                $success = $stmt->execute([$fullname, $username, $email, $phone, $tanggal_lahir, $jenis_kelamin, $bidang, $address, $_POST['user_id']]);
                $message = $success ? "Profil berhasil diperbarui." : "Gagal memperbarui profil.";
            } else {
                // Insert data baru jika user_id tidak ada
                $stmt = $pdo->prepare("INSERT INTO users (fullname, username, email, phone, tanggal_lahir, jenis_kelamin, bidang, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $success = $stmt->execute([$fullname, $username, $email, $phone, $tanggal_lahir, $jenis_kelamin, $bidang, $address]);
                $message = $success ? "Profil berhasil dibuat." : "Gagal membuat profil.";
            }
            $status = $success ? "success" : "error";
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan database: " . $e->getMessage();
            $status = "error";
        }
    } else {
        $message = "Semua kolom wajib harus diisi!";
        $status = "error";
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
    <style>
        .button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s ease-in-out;
            width: 100%;
            margin-top: 20px;
            text-align: center;
            display: block;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
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
    </div>
</nav>
<div class="container">
    <h2>Update Profile</h2>
    <?php if (isset($message)) : ?>
        <p class="error-message"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post">
        <div class="form-row">
            <div class="form-column">
                <input type="text" name="fullname" placeholder="Nama Lengkap" required>
                <input type="text" name="username" placeholder="Username (Opsional)">
                <input type="email" name="email" placeholder="Email (Opsional)">
                <input type="text" name="phone" placeholder="Nomor Telepon" required>
            </div>
            <div class="form-column">
                <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir">
                <select name="jenis_kelamin">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <select name="bidang">
                    <option value="">Pilih Bidang (Opsional)</option>
                    <option value="SDM Umum dan Komunikasi">SDM, Umum dan Komunikasi</option>
                    <option value="Perencanaan dan Keuangan">Perencanaan dan Keuangan</option>
                    <option value="Kepesertaan dan Mutu Layanan">Kepesertaan dan Mutu Layanan</option>
                    <option value="Jaminan Pelayanan Kesehatan">Jaminan Pelayanan Kesehatan</option>
                </select>
                <textarea name="address" placeholder="Alamat" required></textarea>
            </div>
        </div>
        <button href="../dashboard.php" class="button" type="submit">Update</button>
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
        flex-direction: column;
        align-items: center;
        height: 100vh;
        overflow-y: auto;
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

    .form-row {
        display: flex;
        gap: 20px;
    }
    .form-column {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .form-column input, .form-column select, .form-column textarea {
        width: 100%;
    }

    .container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 580px;
        text-align: center;
        margin-top: 80px;
        overflow-y: auto;
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

    input, textarea, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        margin-top: 12px;
    }

    textarea {
        height: 80px;
        resize: none;
    }

    .button {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s ease-in-out;
        text-align: center;
        text-decoration: none;
        width: 100%;
        margin-top: 20px;
    }

    .button:hover {
        background-color: #0056b3;
    }

    @media (max-width: 480px) {
        .form-group {
            min-width: 100%;
        }
    }
</style>