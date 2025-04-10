<?php
require_once("../../config/database.php");

$tanggal_hari_ini = date('Y-m-d');

$query = "SELECT * FROM arsip WHERE jadwal_inaktif > ? ORDER BY jadwal_inaktif ASC";
$stmt = $pdo->prepare($query);
$stmt->execute([$tanggal_hari_ini]);
$arsip_aktif = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Aktif</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Daftar Arsip Aktif</h2>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Uraian Isi</th>
                        <th>Bidang</th>
                        <th>Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($arsip_aktif as $file) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($file["id"]); ?></td>
                        <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                        <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                        <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                        <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                        <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="btn-container">
            <a href="detail.php?type=aktif" class="btn btn-info">Detail</a> 
            <a href="../export_excel.php?status=aktif" class="btn btn-success">Download</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>