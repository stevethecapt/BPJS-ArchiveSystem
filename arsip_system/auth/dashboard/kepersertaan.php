<?php
require_once("../../config/database.php");

if (!$pdo) {
    die("Koneksi ke database gagal.");
}

$sql = "SELECT * FROM arsip WHERE TRIM(bidang) = 'kepersetaan' ORDER BY upload_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h2>Kepersertaan dan Mutu Layanan</h2>
    <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul Berkas</th>
                    <th>Uraian Isi</th>
                    <th>Kode Klasifikasi</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $file) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($file["id"]); ?></td>
                    <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                    <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                    <td><?php echo htmlspecialchars($file["kode_klasifikasi"]); ?></td>
                    <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="btn-container">
        <a href="inputdata.php" class="inputbtn">Input</a>
        <a href="detail.php?bidang=<?php echo urlencode($file['bidang']); ?>" class="btn btn-sm btn-info">Detail</a>
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

select {
    padding: 8px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ccc;
    width: 200px;
    text-align: center;
}

.table-container {
    max-width: 70%;
    margin: 0 auto;
    max-height: 400px; 
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
    text-align: center; 
    margin-top: 20px; 
}

.inputbtn {
    background-color: #007bff;
    width: 100px;
    text-align: center;
    padding: 10px;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
}

.btn-info {
    background-color: #007bff;
    width: 100px;
    text-align: center;
    padding: 10px;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
}

.downloadbtn {
    background-color: #17a2b8;
    width: 100px;
    text-align: center;
    padding: 10px;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
}
</style>