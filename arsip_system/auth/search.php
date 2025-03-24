<?php
require_once("../config/database.php");

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$arsip_aktif = [];

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM arsip WHERE judul_berkas LIKE ?");
    $search_param = "%" . $search . "%";
    $stmt->execute([$search_param]);
    $arsip_aktif = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian Arsip</title>
    <link rel="stylesheet" href="styles.css"> <!-- Sesuaikan dengan CSS kamu -->
</head>
<body>

<h2>Hasil Pencarian untuk "<?php echo htmlspecialchars($search); ?>"</h2>

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
        <?php if (!empty($arsip_aktif)) {
            foreach ($arsip_aktif as $index => $file) { ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                    <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                    <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                    <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                    <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                </tr>
        <?php } 
        } else { ?>
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada hasil ditemukan.</td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="dashboard.php">Kembali ke Dashboard</a>

</body>
</html>
