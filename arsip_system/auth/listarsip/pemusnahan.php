<?php
require_once("../../config/database.php");

$tanggal_hari_ini = date('Y-m-d');
$query = "SELECT * FROM arsip WHERE jadwal_inaktif <= DATE_SUB(?, INTERVAL 1 YEAR) ORDER BY jadwal_inaktif ASC";

$stmt = $pdo->prepare($query);
$stmt->execute([$tanggal_hari_ini]);
$arsip_pemusnahan = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_semua'])) {
    $deleteQuery = "DELETE FROM arsip WHERE jadwal_inaktif <= DATE_SUB(?, INTERVAL 1 YEAR)";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute([$tanggal_hari_ini]);

    header("Location: pemusnahan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Arsip Pemusnahan</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-3">Daftar Arsip Pemusnahan</h2>
        
        <form action="proses_pemusnahan.php" method="post">
            <div class="table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>ID</th>
                            <th>Nomor Berkas</th>
                            <th>Judul Berkas</th>
                            <th>Uraian Isi</th>
                            <th>Kode Klasifikasi</th>
                            <th>Bidang</th>
                            <th>Tanggal Inaktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($arsip_pemusnahan)) : ?>
                            <?php foreach ($arsip_pemusnahan as $row) : ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="hapus_arsip[]" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    </td>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nomor_berkas']); ?></td>
                                    <td><?php echo htmlspecialchars($row['judul_berkas']); ?></td>
                                    <td><?php echo htmlspecialchars($row['uraian_isi']); ?></td>
                                    <td><?php echo htmlspecialchars($row['kode_klasifikasi']); ?></td>
                                    <td><?php echo htmlspecialchars($row['bidang']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jadwal_inaktif']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($arsip_pemusnahan)) : ?>
            <form method="POST">
                <button type="submit" class="hapusbtn" name="hapus">Hapus Semua</button>
            </form>
            <?php else : ?>
                <p style="text-align: center; color: #666;">Tidak ada arsip untuk dimusnahkan.</p>
            <?php endif; ?>
</body>
</html>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f8f9fa;
}

h2 {
    text-align: center;
    color: #333;
}

form {
    text-align: center;
    margin-bottom: 20px;
}

.table-container {
    max-width: 90%; 
    margin: 0 auto;
    max-height: 900px; 
    overflow-y: auto;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

thead {
    background-color: #007bff;
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.hapusbtn {
    display: block;
    visibility: visible;
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    margin: 20px auto;
    transition: background-color 0.2s ease-in-out;
}

.hapusbtn:hover {
    background-color: #c82333;
}

/* Responsif */
@media (max-width: 768px) {
    .table-container {
        max-width: 100%;
    }
    
    .hapusbtn {
        width: 100%;
        padding: 12px;
    }
}
</style>