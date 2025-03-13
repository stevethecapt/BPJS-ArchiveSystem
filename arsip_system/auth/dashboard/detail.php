<?php
require_once("../../config/database.php");

if (!isset($_GET['bidang'])) {
    die("Bidang tidak ditemukan.");
}

$bidang = $_GET['bidang'];

$sql = "SELECT * FROM arsip WHERE bidang = :bidang";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':bidang', $bidang, PDO::PARAM_STR);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$files) {
    die("Data tidak ditemukan untuk bidang ini.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h2>Daftar Arsip Aktif Kedeputian Wilayah X BPJS Kesehatan</h2>
    <h2><?php echo htmlspecialchars($file["bidang"]); ?></h2>
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
            <th>Jadwal Aktif</th>
            <th>Jadwal Inaktif</th>
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
            <td><?php echo htmlspecialchars($file["jadwal_aktif"]); ?></td>
            <td><?php echo htmlspecialchars($file["jadwal_inaktif"]); ?></td>
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
    ?> <a href="<?php echo htmlspecialchars($previousPage); ?>" class="kembalibtn">Kembali</a>
</body>
</html>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 20px auto;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
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
            margin-right: 20px;
        }
        .button-container a:hover {
            background-color: #0056b3;
        }
    </style>

