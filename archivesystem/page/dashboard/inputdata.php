<?php
session_start();
require_once("../../config/database.php");

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomor_berkas = trim($_POST['nomor_berkas'] ?? "");
    $judul_berkas = trim($_POST['judul_berkas'] ?? "");
    $nomor_item_berkas = trim($_POST['nomor_item_berkas'] ?? "");
    $kode_klasifikasi = trim($_POST['kode_klasifikasi'] ?? "");
    $uraian_isi = trim($_POST['uraian_isi'] ?? "");
    $kurun_tanggal = trim($_POST['kurun_tanggal'] ?? "");
    $kurun_tahun = trim($_POST['kurun_tahun'] ?? "");
    $jumlah = trim($_POST['jumlah'] ?? "");
    $satuan = trim($_POST['satuan'] ?? "");
    $tingkat_perkembangan = trim($_POST['tingkat_perkembangan'] ?? "");
    $jadwal_aktif = trim($_POST['jadwal_aktif'] ?? "");
    $jadwal_inaktif = trim($_POST['jadwal_inaktif'] ?? "");
    $keterangan = trim($_POST['keterangan'] ?? "");
    $lokasi_rak = trim($_POST['lokasi_rak'] ?? "");
    $lokasi_shelf = trim($_POST['lokasi_shelf'] ?? "");
    $lokasi_boks = trim($_POST['lokasi_boks'] ?? "");
    $klasifikasi_keamanan = trim($_POST['klasifikasi_keamanan'] ?? "");
    $hak_akses = trim($_POST['hak_akses'] ?? "");
    $bidang = trim($_POST['bidang'] ?? ""); 

    if (!empty($judul_berkas) && !empty($nomor_item_berkas) && !empty($kode_klasifikasi) && !empty($bidang)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO arsip
                (nomor_berkas, judul_berkas, nomor_item_berkas, kode_klasifikasi, uraian_isi, kurun_tanggal, kurun_tahun, jumlah, satuan, 
                tingkat_perkembangan, jadwal_aktif, jadwal_inaktif, keterangan, lokasi_rak, lokasi_shelf, lokasi_boks, 
                klasifikasi_keamanan, hak_akses, bidang) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $success = $stmt->execute([
                $nomor_berkas, $judul_berkas, $nomor_item_berkas, $kode_klasifikasi, $uraian_isi, $kurun_tanggal, $kurun_tahun, $jumlah, $satuan,
                $tingkat_perkembangan, $jadwal_aktif, $jadwal_inaktif, $keterangan, $lokasi_rak, $lokasi_shelf, $lokasi_boks,
                $klasifikasi_keamanan, $hak_akses, $bidang
            ]);

            if ($success) {
                $arsip_id = $pdo->lastInsertId();
                $message = "Data berhasil disimpan!";
                $status = "success";
            } else {
                $message = "Gagal menyimpan data arsip.";
                $status = "error";
            }
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan: " . $e->getMessage();
            $status = "error";
        }
    } else {
        $message = "Semua kolom yang wajib diisi harus lengkap!";
        $status = "error";
    }
}
echo "<script>showMessage('" . htmlspecialchars($message) . "', '" . $status . "');</script>";

$user_id = $_SESSION['id_user'];
$stmt = $pdo->prepare("SELECT fullname, username, email, phone, bidang FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Input Data Arsip</title>
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
     <div class="logo">Menu</div>
        <nav>
        <a href="../dashboard.php" class="sidetext" title="Dashboard">Home</a>
        <a href="inputdata.php" class="sidetext active" title="Masukan Data">Masukan Data</a>
        <a href="SDM.php" class="sidetext" title="SDM, Umum dan Komunikasi">SDM, Umum dan Komunikasi</a>
        <a href="perencanaan.php" class="sidetext" title="Perencanaan dan Keuangan">Perencanaan dan Keuangan</a>
        <a href="kepersertaan.php" class="sidetext" title="Kepersertaan dan Mutu Layanan">Kepersertaan dan Mutu Layanan</a>
        <a href="jaminan.php" class="sidetext" title="Jaminan Pelayanan Kesehatan">Jaminan Pelayanan Kesehatan</a>
        </nav>
    </aside>

    <div class="content-section">
        <form method="POST" action="">
            <h1>Input Data Arsip</h1>
            <form method="POST" action="">
            <div class="form-group">
                <label>Nomor Berkas</label>
                <input type="number" name="nomor_berkas" required>
            </div>
            <div class="form-group">
                <label>Judul Berkas</label>
                <input type="text" name="judul_berkas" required>
            </div>
            <div class="form-group">
                <label>Nomor Item Berkas</label>
                <input type="number" name="nomor_item_berkas" required>
            </div>
            <div class="form-group">
                <label>Kode Klasifikasi</label>
                <input type="text" name="kode_klasifikasi" required>
            </div>
            <div class="form-group">
                <label>Uraian Informasi</label>
                <input type="text" name="uraian_isi" required>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="kurun_tanggal" required>
            </div>
            <div class="form-group">
                <label>Tahun</label>
                <input type="number" name="kurun_tahun" required>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" required>
            </div>
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="satuan" required>
            </div>
            <div class="form-group">
                <label>Tingkat Perkembangan</label>
                <input type="text" name="tingkat_perkembangan" required>
            </div>
            <div class="form-group">
                <label>Jadwal Aktif</label>
                <input type="date" name="jadwal_aktif" required>
            </div>
            <div class="form-group">
                <label>Jadwal Inaktif</label>
                <input type="date" name="jadwal_inaktif" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" required>
            </div>
            <div class="form-group">
                <label>Lokasi Rak</label>
                <input type="text" name="lokasi_rak" required>
            </div>
            <div class="form-group">
                <label>Lokasi Shelf</label>
                <input type="text" name="lokasi_shelf" required>
            </div>
            <div class="form-group">
                <label>Lokasi Boks</label>
                <input type="text" name="lokasi_boks" required>
            </div>
            <div class="form-group">
                <label>Klasifikasi Keamanan</label>
                <input type="text" name="klasifikasi_keamanan" required>
            </div>
            <div class="form-group">
                <label>Hak Akses</label>
                <input type="text" name="hak_akses" required>
            </div>
            <div class="form-group">
                <label>Bidang</label>
                <select id="bidang" name="bidang"required>
                    <option value="">Pilih Bidang</option>
                    <option value="SDM Umum dan Komunikasi">SDM, Umum dan Komunikasi</option>
                    <option value="Perencanaan dan Keuangan">Perencanaan dan Keuangan</option>
                    <option value="Kepesertaan dan Mutu Layanan">Kepersertaan dan Mutu Layanan</option>
                    <option value="Jaminan Pelayanan Kesehatan">Jaminan Pelayanan Kesehatan</option>
                </select>
            </div>
            <button type="submit">Simpan</button>
        <div class="logo-container">
            <img src="../../img/bpjs.png" alt="Logo BPJS Kesehatan" class="bpjs-logo" />
        </div>
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
        background: linear-gradient(135deg,rgb(94, 182, 250),rgb(5, 54, 83));
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        margin-top: 20px;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .dashboard {
        display: flex;
        min-height: 100vh;
        background: #f8fafc;
    }

    .sidebar {
        width: 220px;
        background: #e3f2fd;
        display: flex;
        flex-direction: column;
        padding: 2rem 1.5rem;
        box-shadow: 2px 0 6px rgba(0,0,0,0.1);
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
    }

    .sidebar .logo {
        font-weight: 600;
        font-size: 1.8rem;
        color: #005b90;
        margin-bottom: 3rem;
        text-align: center;
        letter-spacing: 1.5px;
        margin-top: 30px;
    }

    .sidebar nav a {
        padding: 12px 16px;
        margin-bottom: 0.9rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.05rem;
        color: #005b90;
        transition: background-color 0.25s ease, color 0.25s ease;
        display: block;
        user-select: none;
        text-align: center;
    }

    .sidebar nav a:hover, .sidebar nav a.active {
        background: #005b90;
        color: #e3f2fd;
    }

    .message.show {
        display: block;
        top: 10px;
    }

    .message {
        position: fixed;
        top: -60px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 550px;
        z-index: 1000; 
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        opacity: 0;
        transition: opacity 0.5s ease-in-out, top 0.5s ease-in-out;
    }

    .content-section {
        align-items: center;
    }

    h1 {
        text-align: center;
        margin-bottom: 60px;
        color: #005b90;
        width: 100%;
        font-weight: bold;
    }

    form {
        background: #e3f2fd;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 640px;
        display: flex;
        flex-direction: column;
        max-height: 85vh;
        overflow-y: auto;
        position: fixed;
        align-items: center;
        top: 50%;
        left: calc(120px + 50%);
        transform: translate(-50%, -50%);
    }


    .form-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 90%;
        margin-bottom: 10px;
        color: #003f5a;
    }

    label {
        width: 35%; 
        text-align: left; 
    }

    input, textarea, select {
        flex: 1;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        background: #e3f2fd;
        border-color: #003f5a;
    }

    button {
        margin-top: 25px;
        background: #42a5f5;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
    }

    button:hover {
        background: #42a5f5;
    }

  .logo-container {
    margin-top: 35px;
    text-align: center;
  }

  .bpjs-logo {
    max-width: 190px;
    height: auto;
    opacity: 0.9;
  }
</style>