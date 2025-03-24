<?php
require_once("../../config/database.php");
if (!$pdo) {
    die("Database connection Fail");
}
$query = "SELECT * FROM arsip ORDER BY id ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$total_arsip = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Arsip</title>
    <link rel="stylesheet" href="../../styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Daftar Keseluruhan Arsip</h2>
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-container">
                    <tr>
                        <th>Nomor Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Uraian Isi</th>
                        <th>Bidang</th>
                        <th>Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($total_arsip)) : ?>
                        <?php foreach ($total_arsip as $index => $file) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                            <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                            <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                            <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                            <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                        </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada arsip yang tersimpan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="btn-container">
            <a href="detail.php?type=total" class="btn btn-info">Detail</a>
            <a href="download.php?id=<?php echo urlencode($file['id']); ?>" class="btn btn-success">Download</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>