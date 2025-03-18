<?php
require_once("../../config/database.php");

$sql = "SELECT * FROM arsip ORDER BY upload_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlSuggestion = "SELECT * FROM arsip ORDER BY upload_date DESC LIMIT 5";
$stmtSuggestion = $pdo->prepare($sqlSuggestion);
$stmtSuggestion->execute();
$recentFiles = $stmtSuggestion->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="btn-container">
        <a href="detail.php?filter=total" class="btn btn-info">Lihat Detail</a>
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
