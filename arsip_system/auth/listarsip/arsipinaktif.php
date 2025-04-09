<?php
require_once("../../config/database.php");

$tanggal_hari_ini = date('Y-m-d');
$tanggal_batas_pemusnahan = date('Y-m-d', strtotime('-2 days', strtotime($tanggal_hari_ini)));
$query = "SELECT * FROM arsip WHERE jadwal_inaktif <= ? AND jadwal_inaktif > ? ORDER BY jadwal_inaktif ASC";
$stmt = $pdo->prepare($query);
$stmt->execute([$tanggal_hari_ini, $tanggal_batas_pemusnahan]);
$arsip_inaktif = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Inaktif</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Daftar Arsip Inaktif</h2>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Uraian Isi</th>
                        <th>Bidang</th>
                        <th>Jadwal Inaktif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($arsip_inaktif)) : ?>
                        <?php foreach ($arsip_inaktif as $index => $file) { ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                            <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                            <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                            <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                            <td><?php echo htmlspecialchars($file["jadwal_inaktif"]); ?></td>
                        </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada arsip inaktif.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="btn-container">
            <a href="detail.php?type=inaktif" class="btn btn-info">Detail</a> 
            <a href="download.php?id=<?php echo urlencode($file['id']); ?>" class="btn btn-success">Download</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
