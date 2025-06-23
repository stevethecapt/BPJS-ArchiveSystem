<?php
session_start();
require_once("../../config/database.php");
$message = "";
$status = "";

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User tidak ditemukan.");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname        = trim($_POST['fullname'] ?? '');
    $username        = trim($_POST['username'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $phone           = trim($_POST['phone'] ?? '');
    $tanggal_lahir   = trim($_POST['tanggal_lahir'] ?? '');
    $jenis_kelamin   = trim($_POST['jenis_kelamin'] ?? '');
    $bidang          = trim($_POST['bidang'] ?? '');
    $address         = trim($_POST['address'] ?? '');
    if (!empty($fullname) && !empty($phone) && !empty($address)) {
        try {
            $stmt = $pdo->prepare("
                UPDATE users 
                SET fullname = ?, username = ?, email = ?, phone = ?, 
                    tanggal_lahir = ?, jenis_kelamin = ?, bidang = ?, address = ?
                WHERE id = ?
            ");
            $success = $stmt->execute([
                $fullname,
                $username,
                $email,
                $phone,
                $tanggal_lahir,
                $jenis_kelamin,
                $bidang,
                $address,
                $user_id
            ]);
            if ($success) {
                $message = "Profil berhasil diperbarui.";
                $status = "success";
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['username'] = $user['username'];
            } else {
                $message = "Gagal memperbarui profil.";
                $status = "error";
            }
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan database: " . $e->getMessage();
            $status = "error";
        }
    } else {
        $message = "Nama lengkap, nomor HP, dan alamat tidak boleh kosong.";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Update Profile</title>
</head>
<body>

<main class="main-content">
    <header>
        <img src="../../img/bpjs.png" alt="Logo BPJS" class="header-logo" />
        <div class="profile" style="position: relative;">
            <span style="cursor: pointer;" onclick="toggleProfilePopup()">
                <?php echo htmlspecialchars($_SESSION['username'] ?? 'Pengguna'); ?>
            </span>
            <div id="profilePopup" style="display: none; position: absolute; top: 60px; right: 0; width: 250px; padding: 20px; background: #f4faff; border-radius: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); text-align: center; z-index: 999;">
                <p style="font-size: 18px; font-weight: bold; margin-top: 10px; margin-bottom: 12px; color: #023858;">
                    <?php echo htmlspecialchars($user['fullname'] ?? 'Nama Tidak Ditemukan'); ?>
                </p>
                <p style="font-size: 14px; color: #666; margin-bottom: 8px;">
                    <?php echo htmlspecialchars($user['email'] ?? 'example@youremail.com'); ?>
                </p>
                <p style="font-size: 14px; color: #666; margin-bottom: 8px;">
                    <?php echo htmlspecialchars($user['phone'] ?? 'Your Number'); ?>
                </p>
                <p style="font-size: 14px; color: #666; margin-bottom: 12px;">
                    <?php echo htmlspecialchars($user['bidang'] ?? 'Bidang'); ?>
                </p>
                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                    <a href="logout.php" style="display: inline-flex; align-items: center; gap: 5px; background: transparent; color: #023858; text-decoration: none; padding: 8px 10px; border-radius: 10px; font-weight: bold; font-size: 13px;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
        <script>
            function toggleProfilePopup() {
                var popup = document.getElementById("profilePopup");
                popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
            }
        </script>
    </header>

    <div class="content-section">
        <h2>Update Profile</h2>
        <?php if (!empty($message)): ?>
            <div class="flash-message <?= htmlspecialchars($status) ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="form-row">
                <div class="form-column">
                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['fullname']); ?>" placeholder="Nama Lengkap" required>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" placeholder="Username">                
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Email">
                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="Nomor Handphone" required>
                </div>
                <div class="form-column">
                    <label for="tanggal_lahir" style="font-weight: 400; color: #023858; display: inline-block; margin-bottom: 0; margin-top: 10px;">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo htmlspecialchars($user['tanggal_lahir']); ?>" style="margin-top: 1px;" required>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Pria" <?php echo ($user['jenis_kelamin'] == "Laki-laki") ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Wanita" <?php echo ($user['jenis_kelamin'] == "Perempuan") ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                    <select name="bidang" class="form-control">
                        <option value="">Pilih Bidang (Opsional)</option>
                        <option value="SDM Umum dan Komunikasi" <?php echo ($user['bidang'] == "SDM Umum dan Komunikasi") ? 'selected' : ''; ?>>SDM, Umum dan Komunikasi</option>
                        <option value="Perencanaan dan Keuangan" <?php echo ($user['bidang'] == "Perencanaan dan Keuangan") ? 'selected' : ''; ?>>Perencanaan dan Keuangan</option>
                        <option value="Kepesertaan dan Mutu Layanan" <?php echo ($user['bidang'] == "Kepesertaan dan Mutu Layanan") ? 'selected' : ''; ?>>Kepesertaan dan Mutu Layanan</option>
                        <option value="Jaminan Pelayanan Kesehatan" <?php echo ($user['bidang'] == "Jaminan Pelayanan Kesehatan") ? 'selected' : ''; ?>>Jaminan Pelayanan Kesehatan</option>
                    </select>
                    <textarea name="address" class="form-control" placeholder="Alamat" required><?php echo htmlspecialchars($user['address']); ?></textarea>
                </div>
            </div>
            <button class="button" type="submit">Update</button>
        </form>
    </div>
</main>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('profilePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
</body>
</html>
<style>
    *, *::before, *::after {
        box-sizing: border-box;
    }
    body, html {
        margin: 0;
        height: 100%;
        font-family: 'Open Sans', sans-serif;
        background: #f8fafc;
        color: #023858;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        user-select: none;
    }
    a {
        text-decoration: none;
        color: inherit;
    }
    .main-content {
        padding: 2rem 1rem;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        box-shadow: inset 3px 0 8px rgba(0,0,0,0.05);
        margin: 0 auto;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }
    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.8rem;
        border-bottom: 2px solid #a7d4ff;
        padding-bottom: 0.8rem;
        position: sticky;
        top: 0;
        background: #ffffff;
        z-index: 900;
    }
    .header-logo {
        height: 2.6rem;
        font-weight: 600;
        color: #023858;
        user-select: none;
        display: inline-block;
        object-fit: contain;
    }
    .profile {
        display: flex;
        align-items: center;
    }
    .profile span {
      font-weight: 600;
      font-size: 1rem;
      color: #023858;
    }
    .content-section {
        background: #f4faff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 2.5rem 2.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0, 113, 188, 0.1);
        color: #023858;
        user-select: none;
        line-height: 1.5;
        max-width: 960px;
        width: 90%;
        min-height: 560px;
        margin: 0 auto;
        box-sizing: border-box;
    }
    form {
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .form-row {
        display: flex;
        gap: 20px;
    }
    .form-column {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 20px;
    }
    .form-column input,
    .form-column select,
    .form-column textarea {
        width: 100%;
        margin-bottom: 10px;
        margin-top: 0;
    }
    h2 {
        margin-bottom: 20px;
        color: #333;
        align-self: center;
        font-weight: 400;
    }
    .flash-message {
        font-size: 14px;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }

    .flash-message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .flash-message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .button {
        background-color: #007bff;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s ease-in-out;
        width: 20%;
        margin-top: auto;
        align-self: center;
    }
    .button:hover {
        background-color: #0056b3;
    }
</style>