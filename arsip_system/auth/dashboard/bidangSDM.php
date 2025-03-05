<?php
session_start();
require_once("../../config/database.php");

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unit_kerja = isset($_POST['unit_kerja']) ? trim($_POST['unit_kerja']) : null;
    $judul_berkas = isset($_POST['judul_berkas']) ? trim($_POST['judul_berkas']) : null;
    $nomor_item_berkas = isset($_POST['nomor_item_berkas']) ? trim($_POST['nomor_item_berkas']) : null;
    $kode_klasifikasi = isset($_POST['kode_klasifikasi']) ? trim($_POST['kode_klasifikasi']) : null;
    $uraian_isi = isset($_POST['uraian_isi']) ? trim($_POST['uraian_isi']) : null;
    $kurun_tanggal = isset($_POST['kurun_tanggal']) ? trim($_POST['kurun_tanggal']) : null;
    $kurun_tahun = isset($_POST['kurun_tahun']) ? trim($_POST['kurun_tahun']) : null;
    $jumlah = isset($_POST['jumlah']) ? trim($_POST['jumlah']) : null;
    $satuan = isset($_POST['satuan']) ? trim($_POST['satuan']) : null;
    $tingkat_perkembangan = isset($_POST['tingkat_perkembangan']) ? trim($_POST['tingkat_perkembangan']) : null;
    $jadwal_aktif = isset($_POST['jadwal_aktif']) ? trim($_POST['jadwal_aktif']) : null;
    $jadwal_inaktif = isset($_POST['jadwal_inaktif']) ? trim($_POST['jadwal_inaktif']) : null;
    $keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : null;
    $lokasi_rak = isset($_POST['lokasi_rak']) ? trim($_POST['lokasi_rak']) : null;
    $lokasi_shelf = isset($_POST['lokasi_shelf']) ? trim($_POST['lokasi_shelf']) : null;
    $lokasi_boks = isset($_POST['lokasi_boks']) ? trim($_POST['lokasi_boks']) : null;
    $klasifikasi_keamanan = isset($_POST['klasifikasi_keamanan']) ? trim($_POST['klasifikasi_keamanan']) : null;
    $hak_akses = isset($_POST['hak_akses']) ? trim($_POST['hak_akses']) : null;
    $bidang = isset($_POST['bidang']) ? trim($_POST['bidang']) : null;
    
    if (!empty($unit_kerja) && !empty($judul_berkas) && !empty($nomor_item_berkas) && !empty($kode_klasifikasi)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO arsip 
                (unit_kerja, judul_berkas, nomor_item_berkas, kode_klasifikasi, uraian_isi, kurun_tanggal, kurun_tahun, jumlah, satuan, 
                tingkat_perkembangan, jadwal_aktif, jadwal_inaktif, keterangan, lokasi_rak, lokasi_shelf, lokasi_boks, 
                klasifikasi_keamanan, hak_akses, bidang) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt->execute([
                $unit_kerja, $judul_berkas, $nomor_item_berkas, $kode_klasifikasi, $uraian_isi, $kurun_tanggal, $kurun_tahun, $jumlah, $satuan,
                $tingkat_perkembangan, $jadwal_aktif, $jadwal_inaktif, $keterangan, $lokasi_rak, $lokasi_shelf, $lokasi_boks,
                $klasifikasi_keamanan, $hak_akses, $bidang
            ])) {
                $message = "Data berhasil disimpan!";
                $status = "success";
            } else {
                $message = "Gagal menyimpan data.";
                $status = "error";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            $status = "error";
        }
    } else {
        $message = "Semua kolom yang wajib diisi harus lengkap!";
        $status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { width: 50%; margin: auto; }
        label, input, textarea { display: block; width: 100%; margin-bottom: 10px; }
        input, textarea { padding: 8px; }
        .message {
            padding: 10px; 
            color: white;
            text-align: center;
            margin-bottom: 15px;
        }
        .success { background-color: green; }
        .error { background-color: red; }
    </style>
</head>
<body>

<?php if (!empty($message)) : ?>
    <div class="message <?= $status; ?>"><?= $message; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <label>Unit Kerja</label><input type="text" name="unit_kerja" required>
    <label>Judul Berkas</label><input type="text" name="judul_berkas" required>
    <label>Nomor Item Berkas</label><input type="text" name="nomor_item_berkas" required>
    <label>Kode Klasifikasi</label><input type="text" name="kode_klasifikasi" required>
    <label>Uraian Isi</label><textarea name="uraian_isi" required></textarea>
    <label>Kurun Tanggal</label><input type="date" name="kurun_tanggal" required>
    <label>Kurun Tahun</label><input type="number" name="kurun_tahun" required>
    <label>Jumlah</label><input type="number" name="jumlah" required>
    <label>Satuan</label><input type="text" name="satuan" required>
    <label>Tingkat Perkembangan</label><input type="text" name="tingkat_perkembangan" required>
    <label>Jadwal Aktif</label><input type="date" name="jadwal_aktif" required>
    <label>Jadwal Inaktif</label><input type="date" name="jadwal_inaktif" required>
    <label>Keterangan</label><input type="text" name="keterangan" required>
    <label>Lokasi Rak</label><input type="text" name="lokasi_rak" required>
    <label>Lokasi Shelf</label><input type="text" name="lokasi_shelf" required>
    <label>Lokasi Boks</label><input type="text" name="lokasi_boks" required>
    <label>Klasifikasi Keamanan</label><input type="text" name="klasifikasi_keamanan" required>
    <label>Hak Akses</label><input type="text" name="hak_akses" required>
    <label for="bidang">Bidang</label>
    <select id="bidang" name="bidang">
        <option value="">Pilih Bidang</option>
        <option value="sdm">SDM, Umum dan Komunikasi</option>
        <option value="perencanaan">Perencanaan dan Keuangan</option>
        <option value="kepersetaan">Kepersertaan dan Mutu Layanan</option>
        <option value="jaminan">Jaminan Pelayanan Kesehatan</option>
    </select>
    <button type="submit">Simpan</button>
</form>

</body>
</html>