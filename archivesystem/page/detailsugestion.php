<?php
session_start();
require_once("../config/database.php");
if (!$pdo) {
    die("Koneksi database gagal.");
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid atau tidak ditemukan.");
}
$id = $_GET['id'];
$sql = "SELECT *, 
        CASE 
            WHEN CURDATE() < jadwal_inaktif THEN 'Aktif' 
            WHEN CURDATE() BETWEEN jadwal_inaktif AND DATE_ADD(jadwal_inaktif, INTERVAL 1 YEAR) THEN 'Inaktif'
            ELSE 'Pemusnahan'
        END AS status_arsip
        FROM arsip 
        WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$file = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$file) {
    die("Data tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Arsip</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Baru saja ditambahkan</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><td><?php echo htmlspecialchars($file["id"]); ?></td></tr>
        <tr><th>Nomor Berkas</th><td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td></tr>
        <tr><th>Judul Berkas</th><td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td></tr>
        <tr><th>Nomor Item Berkas</th><td><?php echo htmlspecialchars($file["nomor_item_berkas"]); ?></td></tr>
        <tr><th>Kode Klasifikasi</th><td><?php echo htmlspecialchars($file["kode_klasifikasi"]); ?></td></tr>
        <tr><th>Uraian Isi</th><td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td></tr>
        <tr><th>Kurun Tanggal</th><td><?php echo htmlspecialchars($file["kurun_tanggal"]); ?></td></tr>
        <tr><th>Kurun Tahun</th><td><?php echo htmlspecialchars($file["kurun_tahun"]); ?></td></tr>
        <tr><th>Jumlah</th><td><?php echo htmlspecialchars($file["jumlah"]); ?></td></tr>
        <tr><th>Satuan</th><td><?php echo htmlspecialchars($file["satuan"]); ?></td></tr>
        <tr><th>Tingkat Perkembangan</th><td><?php echo htmlspecialchars($file["tingkat_perkembangan"]); ?></td></tr>
        <tr><th>Masa Aktif</th><td>
                        <?php 
                        $start_date = new DateTime($file["jadwal_aktif"]);
                        $end_date = new DateTime($file["jadwal_inaktif"]);
                        $interval = $start_date->diff($end_date);
                        $masa_aktif = "";
                        if ($interval->y > 0) {
                            $masa_aktif .= $interval->y . " tahun ";
                        }
                        if ($interval->m > 0) {
                            $masa_aktif .= $interval->m . " bulan ";
                        }
                        if ($interval->d > 0) {
                            $masa_aktif .= $interval->d . " hari";
                        }
                        echo htmlspecialchars(trim($masa_aktif));
                        ?>
                    </td></tr>
        <tr><th>Masa Inaktif</th><td>
        <?php 
        $inactive_start = new DateTime($file["jadwal_inaktif"]);
        $today = new DateTime();
        $inactive_end = clone $inactive_start;
        $inactive_end->modify('+3 days'); // Masa inaktif hanya 3 hari setelah jadwal inaktif

        if ($today >= $inactive_start && $today < $inactive_end) {
            $diff = $today->diff($inactive_end);
            echo htmlspecialchars($diff->days . " hari tersisa");
        } elseif ($today >= $inactive_end) {
            echo "Masa inaktif berakhir";
        } else {
            echo "Belum memasuki masa inaktif";
        }
        ?></td></tr>
        <tr><th>Status</th><td>
            <?php 
            $today = new DateTime();
            $aktif_start = new DateTime($file["jadwal_aktif"]);
            $inactive_start = new DateTime($file["jadwal_inaktif"]);
            $destroy_start = (clone $inactive_start)->modify('+1 year');

            if ($today >= $aktif_start && $today < $inactive_start) {
                echo '<span class="badge badge-success text-dark">Aktif</span>';
            } elseif ($today >= $inactive_start && $today < $destroy_start) {
                echo '<span class="badge badge-warning text-dark">Inaktif</span>';
            } else {
                echo '<span class="badge badge-danger text-dark">Dimusnahkan</span>';
            }
            ?>
        </td></tr>
        <tr><th>Keterangan</th><td><?php echo htmlspecialchars($file["keterangan"]); ?></td></tr>
        <tr><th>Lokasi Rak</th><td><?php echo htmlspecialchars($file["lokasi_rak"]); ?></td></tr>
        <tr><th>Lokasi Shelf</th><td><?php echo htmlspecialchars($file["lokasi_shelf"]); ?></td></tr>
        <tr><th>Lokasi Boks</th><td><?php echo htmlspecialchars($file["lokasi_boks"]); ?></td></tr>
        <tr><th>Klasifikasi Keamanan</th><td><?php echo htmlspecialchars($file["klasifikasi_keamanan"]); ?></td></tr>
        <tr><th>Hak Akses</th><td><?php echo htmlspecialchars($file["hak_akses"]); ?></td></tr>
        <tr><th>Bidang</th><td><?php echo htmlspecialchars($file["bidang"]); ?></td></tr>
        <tr><th>Upload Date</th><td><?php echo htmlspecialchars($file["upload_date"]); ?></td></tr>
    </table>
</body>
</html>
<link rel="stylesheet" href="styles.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 20px;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 90%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        padding: 3px;
        border-bottom: 1px solid #ddd;
        border: 1px solid #ddd;
        text-align: left;
        background-color: #ffffff;
        color: #333;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>