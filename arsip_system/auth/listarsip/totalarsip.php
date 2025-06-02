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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Total Arsip</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body>
    <header>
      <img src="../../img/bpjs.png" alt="Logo BPJS" class="header-logo" />
    </header>
    <div class="container">
        <h2>Daftar Keseluruhan Arsip</h2>
        <div class="table-responsive">
            <table>
                <thead>
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
                        <?php foreach ($total_arsip as $file) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                                <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                                <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                                <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                                <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada arsip yang tersimpan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="btn-container">
            <a href="detail.php?type=total" class="btn-info">Detail</a>
            <?php if (!empty($total_arsip)) : ?>
                <a href="../export_excel.php?id=<?php echo urlencode($total_arsip[0]['id']); ?>" class="btn-success">Download</a>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<style>
    body, html {
        margin: 0;
        font-family: 'Open Sans', sans-serif;
        background: #f8fafc;
        color: #023858;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background: #ffffff;
      border-bottom: 2px solid #a7d4ff;
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .header-logo {
      height: 40px;
    }
    .container {
        max-width: 1100px;
        margin: 40px auto;
        background: #f4faff;
        padding: 2.3rem 2.8rem;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0, 113, 188, 0.1);
        color: #023858;
        user-select: none;
    }
    h2 {
        text-align: center;
        font-weight: 600;
        font-size: 1.9rem;
        margin-bottom: 2rem;
    }
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background-color: #f4faff;
        color: #023858;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 113, 188, 0.08);
        font-size: 0.95rem;
    }
    thead {
        background-color: #f4faff;
    }
    thead th {
        padding: 1rem 1.2rem;
        text-align: left;
        font-weight: 700;
        color: #005b90;
        border-bottom: 2px solid #005b90;
    }
    tbody tr {
        transition: background-color 0.2s ease;
    }
    tbody tr:hover {
        background-color: #eaf6ff;
    }
    tbody td {
        padding: 0.85rem 1.2rem;
        border-bottom: 1px solid #c6e4f9;
    }
    tbody tr:last-child td {
        border-bottom: none;
    }
    .btn-container {
        margin-top: 20px;
        text-align: center;
    }
    .btn-info {
        background-color: #0071bc;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        margin-right: 10px;
        transition: background-color 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-info:hover {
        background-color: #005b90;
        color: white;
    }
    .btn-success {
        background-color: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: background-color 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-success:hover {
        background-color: #1e7e34;
        color: white;
    }
    .text-center {
        text-align: center;
    }
</style>