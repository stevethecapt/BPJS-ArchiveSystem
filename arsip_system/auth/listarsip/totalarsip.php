<?php
require_once("../../config/database.php");

$sql = "SELECT * FROM arsip ORDER BY upload_date DESC";
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
    <h2>Daftar Arsip Keseluruhan</h2>
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
                <?php foreach ($files as $file) { ?>
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
