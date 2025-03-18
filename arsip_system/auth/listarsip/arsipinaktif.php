<?php
require_once("../../config/database.php");

$tanggal_hari_ini = date('Y-m-d');
$tanggal_setahun_ke_depan = date('Y-m-d', strtotime('+1 year', strtotime($tanggal_hari_ini))); // 1 tahun ke depan

$query = "SELECT * FROM arsip 
          WHERE jadwal_inaktif <= ? 
          AND jadwal_inaktif >= DATE_SUB(?, INTERVAL 1 YEAR) 
          ORDER BY jadwal_inaktif ASC";

$stmt = $pdo->prepare($query);
$stmt->execute([$tanggal_hari_ini, $tanggal_hari_ini]);
$arsip_inaktif = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
</head>
<body>
    <h2 class="mb-3">Daftar Arsip Inaktif</h2>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nomor Berkas</th>
                    <th>Judul Berkas</th>
                    <th>Uraian Isi</th>
                    <th>Kode Klasifikasi</th>
                    <th>Bidang</th>
                    <th>Aktif Sejak Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($arsip_aktif)) : ?>
                    <?php foreach ($arsip_aktif as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nomor_berkas']); ?></td>
                            <td><?php echo htmlspecialchars($row['judul_berkas']); ?></td>
                            <td><?php echo htmlspecialchars($row['uraian_isi']); ?></td>
                            <td><?php echo htmlspecialchars($row['kode_klasifikasi']); ?></td>
                            <td><?php echo htmlspecialchars($row['bidang']); ?></td>
                            <td><?php echo htmlspecialchars($row['jadwal_aktif']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada arsip Inaktif.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="btn-container">
        <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Detail</a>
        <a href="" class="downloadbtn">Download</a>
    </div>
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
    max-width: 80%;
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

.btn-container {
    text-decoration: none;
    padding: 5px 6px;
    border-radius: 5px;
    font-size: 13px;
    color: white;
    border: none;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
}

.btn-info, .downloadbtn {
    padding: 10px 8px;
    border-radius: 5px;
    text-decoration: none;
    display: fixed;
    justify-content: center;
    align-items: center;
    margin: 5px ;
    color: white;
    text-align: center;
    width: 120px;
}

.btn-info { background-color: #17a2b8; }
.downloadbtn { background-color: #28a745; }
</style>