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

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
    
<body>
    <nav>
        <img src="img/bpjs.png" class="img" alt="logo">
        <div class="top-right">
            <a href="logout.php" class="logoutbtn">Logout</a>
            <span class="username">
                <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
            </span>
        </div>
    </nav>

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
</form>
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
    background-color: #339cff;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    margin-top: 20px;
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

nav .img {
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

.logoutbtn {
    font-size: 1rem;
    font-weight: 500;
    color: white;
    border: none;
    background-color: #dc3545;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
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

.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.error { 
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb; 
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 520px;
    display: flex;
    flex-direction: column;
    max-height: 75vh;
    overflow-y: auto;
    position: fixed;
    align-items: center;
}

.form-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    margin-bottom: 10px;
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
}

button {
    margin-top: 15px;
    background: #28a745;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

button:hover {
    background: #218838;
}
</style>