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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Hasil Pencarian untuk "<?php echo htmlspecialchars($search); ?>"</h2>
        <div class="table-container">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Nomor Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Uraian Isi</th>
                        <th>Bidang</th>
                        <th>Status</th>
                        <th>Upload Date</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($arsip_aktif) && is_array($arsip_aktif)) {
                        foreach ($arsip_aktif as $index => $file) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                                <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                                <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                                <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                                <td>
                                    <?php 
                                    $today = new DateTime();
                                    $aktif_start = new DateTime($file["jadwal_aktif"]);
                                    $inactive_start = new DateTime($file["jadwal_inaktif"]);

                                    if ($today >= $aktif_start && $today < $inactive_start) {
                                        echo '<span class="badge badge-success text-dark">Aktif</span>';
                                    } else {
                                        echo '<span class="badge badge-danger text-dark">Inaktif</span>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                                <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                                <td>
                                    <a href="detailsugestion.php?id=<?php echo $file['id']; ?>" class="btn btn-primary btn-sm">Detail</a>
                                </td>
                            </tr>
                    <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ditemukan.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</div>
</body>
</html>