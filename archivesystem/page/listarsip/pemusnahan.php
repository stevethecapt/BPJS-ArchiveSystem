<?php
session_start();
require_once("../../config/database.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_ids'])) {
    try {
        $delete_ids = $_POST['delete_ids'];
        $placeholders = rtrim(str_repeat('?,', count($delete_ids)), ',');
        $query = "UPDATE arsip SET status = 'dimusnahkan' WHERE id IN ($placeholders)";
        $stmt = $pdo->prepare($query);
        $stmt->execute($delete_ids);
        header("Location: pemusnahan.php");
        exit;
    } catch (PDOException $e) {
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
$tanggal_hari_ini = date('Y-m-d');
$query = "SELECT * FROM arsip 
          WHERE status != 'dimusnahkan'
            AND DATE_ADD(jadwal_inaktif, INTERVAL 1 YEAR) < ?
          ORDER BY jadwal_inaktif ASC";
$stmt = $pdo->prepare($query);
$stmt->execute([$tanggal_hari_ini]);
$arsip_pemusnahan = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Arsip untuk Pemusnahan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body>
    <header>
        <img src="../../img/bpjs.png" alt="Logo BPJS" class="header-logo" />
    </header>

    <div class="container">
        <h2>Daftar Arsip untuk Pemusnahan</h2>
        <form method="POST" action="pemusnahan.php">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all"></th>
                            <th>No.</th>
                            <th>Nomor Berkas</th>
                            <th>Judul Berkas</th>
                            <th>Uraian Isi</th>
                            <th>Bidang</th>
                            <th>Jadwal Inaktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($arsip_pemusnahan)) : ?>
                            <?php foreach ($arsip_pemusnahan as $index => $file) : ?>
                            <tr>
                                <td class="text-center"><input type="checkbox" name="delete_ids[]" value="<?php echo $file['id']; ?>"></td>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                                <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                                <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                                <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                                <td><?php echo htmlspecialchars($file["jadwal_inaktif"]); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada arsip yang siap dimusnahkan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($arsip_pemusnahan)) : ?>
            <div class="btn-container">
                <a href="detail.php?type=pemusnahan" class="btn btn-info">Detail</a>
                <button type="submit" class="btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus arsip yang dipilih?')">Hapus</button>
            </div>
            <?php endif; ?>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('select_all').addEventListener('click', function(event) {
            let checkboxes = document.querySelectorAll('input[name="delete_ids[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
        });
    </script>
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
    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: background-color 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-danger:hover {
        background-color: #b02a37;
        color: white;
    }
</style>