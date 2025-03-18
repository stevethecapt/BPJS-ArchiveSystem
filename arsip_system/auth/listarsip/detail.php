<?php
require_once("../../config/database.php");

$sql = "SELECT *, 
        CASE 
            WHEN CURDATE() < jadwal_inaktif THEN 'Aktif' 
            WHEN CURDATE() BETWEEN jadwal_inaktif AND DATE_ADD(jadwal_inaktif, INTERVAL 1 YEAR) THEN 'Inaktif'
            ELSE 'Pemusnahan'
        END AS status_arsip
        FROM arsip 
        ORDER BY upload_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Arsip</title>
</head>
<body>
    <h2>Daftar Arsip <?php echo ($bidang == "Total") ? "Total Arsip" : "Bidang $bidang"; ?> Kedeputian Wilayah X BPJS Kesehatan</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nomor Berkas</th>
            <th>Judul Berkas</th>
            <th>Nomor Item Berkas</th>
            <th>Kode Klasifikasi</th>
            <th>Uraian Isi</th>
            <th>Kurun Tanggal</th>
            <th>Kurun Tahun</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Tingkat Perkembangan</th>
            <th>Masa Aktif</th>
            <th>Masa Inaktif</th>
            <th>Status</th>
            <th>Keterangan</th>
            <th>Lokasi Rak</th>
            <th>Lokasi Shelf</th>
            <th>Lokasi Boks</th>
            <th>Klasifikasi Keamanan</th>
            <th>Hak Akses</th>
            <th>Bidang</th>
            <th>Upload Date</th>
        </tr>
        <?php foreach ($files as $file) : ?>
        <tr>
            <td><?php echo htmlspecialchars($file["id"]); ?></td>
            <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
            <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
            <td><?php echo htmlspecialchars($file["nomor_item_berkas"]); ?></td>
            <td><?php echo htmlspecialchars($file["kode_klasifikasi"]); ?></td>
            <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
            <td><?php echo htmlspecialchars($file["kurun_tanggal"]); ?></td>
            <td><?php echo htmlspecialchars($file["kurun_tahun"]); ?></td>
            <td><?php echo htmlspecialchars($file["jumlah"]); ?></td>
            <td><?php echo htmlspecialchars($file["satuan"]); ?></td>
            <td><?php echo htmlspecialchars($file["tingkat_perkembangan"]); ?></td>
            <td>
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
            </td>
            <td>
                <?php 
                $inactive_start = new DateTime($file["jadwal_inaktif"]);
                $inactive_end = (clone $inactive_start)->modify('+1 year');
                $inactive_interval = $inactive_start->diff($inactive_end);

                echo htmlspecialchars($inactive_interval->y > 0 ? $inactive_interval->y . " tahun " : "") .
                    htmlspecialchars($inactive_interval->m > 0 ? $inactive_interval->m . " bulan" : "");
                ?>
            </td>
            <td><?php echo htmlspecialchars($file["status_arsip"]); ?></td>
            <td><?php echo htmlspecialchars($file["keterangan"]); ?></td>
            <td><?php echo htmlspecialchars($file["lokasi_rak"]); ?></td>
            <td><?php echo htmlspecialchars($file["lokasi_shelf"]); ?></td>
            <td><?php echo htmlspecialchars($file["lokasi_boks"]); ?></td>
            <td><?php echo htmlspecialchars($file["klasifikasi_keamanan"]); ?></td>
            <td><?php echo htmlspecialchars($file["hak_akses"]); ?></td>
            <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
            <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php
    $previousPage = $_SERVER['HTTP_REFERER'] ?? '../dashboard.php';
    ?>
    <a href="<?php echo htmlspecialchars($previousPage); ?>" class="kembalibtn">Kembali</a>
</body>
</html>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        text-align: center;
    }

    form {
        text-align: center;
        margin-bottom: 20px;
    }

    select {
        padding: 8px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 200px;
        text-align: center;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    th {
        background-color: #f4f4f4;
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
        font-weight: bold;
    }

    td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
    }

    tr:nth-child(odd) {
        background-color: #fafafa;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .button-container {
        text-align: center;
        margin-top: 20px;
    }

    .kembalibtn {
        background-color: #007BFF;
        display: inline-block;
        padding: 10px 20px;
        font-size: 14px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .kembalibtn:hover {
        background-color: #0056b3;
    }
</style>