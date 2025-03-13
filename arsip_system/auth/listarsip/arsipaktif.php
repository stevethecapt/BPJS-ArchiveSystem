<?php
require_once("../../config/database.php");

$tanggal_hari_ini = date('Y-m-d');
$query = "SELECT * FROM arsip WHERE jadwal_aktif <= ? AND jadwal_inaktif > ? ORDER BY jadwal_aktif ASC";
$stmt = $pdo->prepare($query);
$stmt->execute([$tanggal_hari_ini, $tanggal_hari_ini]);
$jadwal_aktif_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h2>Daftar Arsip Aktif</h2>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal_aktif_data as $row) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['nomor_berkas']); ?></td>
                        <td><?php echo htmlspecialchars($row['judul_berkas']); ?></td>
                        <td><?php echo htmlspecialchars($row['uraian_isi']); ?></td>
                        <td><?php echo htmlspecialchars($row['kode_klasifikasi']); ?></td>
                        <td><?php echo htmlspecialchars($row['bidang']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
    max-width: 70%;
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

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.btn {
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 5px;
    font-size: 14px;
    color: white;
    background-color: #28a745;
    border: none;
}

.btn-info {
    background-color: #17a2b8;
}

.inputbtn {
    display: block;
    width: 120px;
    margin: 20px auto;
    text-align: center;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}
</style>