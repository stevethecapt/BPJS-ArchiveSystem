<?php
require_once("../../config/database.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$type = isset($_GET['type']) && in_array($_GET['type'], ['total', 'aktif', 'inaktif', 'pemusnahan']) ? $_GET['type'] : 'total';

try {
    if ($type === 'total') {
        $query = "SELECT * FROM arsip ORDER BY upload_date DESC";
    } elseif ($type === 'aktif') {
        $query = "SELECT * FROM arsip WHERE jadwal_aktif <= CURDATE() AND jadwal_inaktif > CURDATE() ORDER BY jadwal_aktif DESC";
    } elseif ($type === 'inaktif') {
        $query = "SELECT * FROM arsip WHERE jadwal_inaktif <= CURDATE() AND jadwal_inaktif > DATE_SUB(CURDATE(), INTERVAL 3 DAY) ORDER BY jadwal_inaktif DESC";
    } elseif ($type === 'pemusnahan') {
        $query = "SELECT * FROM arsip WHERE jadwal_inaktif <= DATE_SUB(CURDATE(), INTERVAL 3 DAY) ORDER BY jadwal_inaktif ASC";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Arsip</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-3">
            <?php
                if ($type === 'total') echo "Total Arsip";
                elseif ($type === 'aktif') echo "Arsip Aktif";
                elseif ($type === 'inaktif') echo "Arsip Inaktif";
                elseif ($type === 'pemusnahan') echo "Arsip Pemusnahan";
            ?>
        </h2>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nomor Berkas</th>
                    <th>Judul Berkas</th>
                    <th>Nomor Item Berkas</th>
                    <th>Kode Klasifikasi</th>
                    <th>Uraian Isi</th>
                    <th>Kurun Tanggal</th>
                    <th>Kurun Tahun</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Tingkat Perkembangan</th>
                    <th>Masa Aktif</th>
                    <th>Masa Inaktif</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Lokasi Rak</th>
                    <th>Lokasi Shelf</th>
                    <th>Lokasi Boks</th>
                    <th>Klasifikasi Keamanan</th>
                    <th>Hak Akses</th>
                    <th>Bidang</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $file) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($file["id"]); ?></td>
                    <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                    <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                    <td><?php echo htmlspecialchars($file["nomor_item_berkas"]); ?></td>
                    <td><?php echo htmlspecialchars($file["kode_klasifikasi"]); ?></td>
                    <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                    <td><?php echo htmlspecialchars($file["kurun_tanggal"]); ?></td>
                    <td><?php echo htmlspecialchars($file["kurun_tahun"]); ?></td>
                    <td><?php echo htmlspecialchars($file["jumlah"]); ?></td>
                    <td><?php echo htmlspecialchars($file["satuan"]); ?></td>
                    <td><?php echo htmlspecialchars($file["tingkat_perkembangan"]); ?></td>
                    <td>
                        <?php 
                        $start_date = new DateTime($file["jadwal_aktif"]);
                        $end_date = new DateTime($file["jadwal_inaktif"]);
                        $interval = $start_date->diff($end_date);
                        $masa_aktif = "";
                        if ($interval->y > 0) {
                            $masa_aktif .= $interval->y . " tahun ";
                        }
                        if ($interval->m > 0) {
                            $masa_aktif .= $interval->m . " bulan ";
                        }
                        if ($interval->d > 0) {
                            $masa_aktif .= $interval->d . " hari";
                        }
                        echo htmlspecialchars(trim($masa_aktif));
                        ?>
                    </td>
                    <td>
                        <?php 
                        $inactive_start = new DateTime($file["jadwal_inaktif"]);
                        $today = new DateTime();
                        $diff = $today->diff($inactive_start);

                        if ($diff->days <= 3 && $today >= $inactive_start) {
                            echo htmlspecialchars($diff->days . " hari");
                        } else {
                            echo "Masa inaktif berakhir";
                        }
                        ?>
                    </td>
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

                    <td><?php echo htmlspecialchars($file["keterangan"]); ?></td>
                    <td><?php echo htmlspecialchars($file["lokasi_rak"]); ?></td>
                    <td><?php echo htmlspecialchars($file["lokasi_shelf"]); ?></td>
                    <td><?php echo htmlspecialchars($file["lokasi_boks"]); ?></td>
                    <td><?php echo htmlspecialchars($file["klasifikasi_keamanan"]); ?></td>
                    <td><?php echo htmlspecialchars($file["hak_akses"]); ?></td>
                    <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                    <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>
