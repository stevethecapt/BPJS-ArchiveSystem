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
  <title>Dashboard Arsip</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
      <img src="../../img/bpjs.png" alt="Logo BPJS" class="header-logo" />
    </header>
  <div class="content-wrapper">
    <h2>
      <?php
          if ($type === 'total') echo "Total Arsip";
          elseif ($type === 'aktif') echo "Arsip Aktif";
          elseif ($type === 'inaktif') echo "Arsip Inaktif";
          elseif ($type === 'pemusnahan') echo "Arsip Pemusnahan";
      ?>
    </h2>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nomor Berkas</th>
            <th>Judul Berkas</th>
            <th>Nomor Item</th>
            <th>Kode Klasifikasi</th>
            <th>Uraian Isi</th>
            <th>Kurun Tanggal</th>
            <th>Kurun Tahun</th>
            <th>Jumlah</th>
            <th>Satuan</th>
            <th>Perkembangan</th>
            <th>Masa Aktif</th>
            <th>Masa Inaktif</th>
            <th>Status</th>
            <th>Keterangan</th>
            <th>Rak</th>
            <th>Shelf</th>
            <th>Boks</th>
            <th>Keamanan</th>
            <th>Hak Akses</th>
            <th>Bidang</th>
            <th>Upload Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($files as $file) : ?>
          <tr>
            <td><?= htmlspecialchars($file["id"]) ?></td>
            <td><?= htmlspecialchars($file["nomor_berkas"]) ?></td>
            <td><?= htmlspecialchars($file["judul_berkas"]) ?></td>
            <td><?= htmlspecialchars($file["nomor_item_berkas"]) ?></td>
            <td><?= htmlspecialchars($file["kode_klasifikasi"]) ?></td>
            <td><?= htmlspecialchars($file["uraian_isi"]) ?></td>
            <td><?= htmlspecialchars($file["kurun_tanggal"]) ?></td>
            <td><?= htmlspecialchars($file["kurun_tahun"]) ?></td>
            <td><?= htmlspecialchars($file["jumlah"]) ?></td>
            <td><?= htmlspecialchars($file["satuan"]) ?></td>
            <td><?= htmlspecialchars($file["tingkat_perkembangan"]) ?></td>
            <td>
              <?php
                $start = new DateTime($file["jadwal_aktif"]);
                $end = new DateTime($file["jadwal_inaktif"]);
                $interval = $start->diff($end);
                $masa = '';
                if ($interval->y) $masa .= "{$interval->y} tahun ";
                if ($interval->m) $masa .= "{$interval->m} bulan ";
                if ($interval->d) $masa .= "{$interval->d} hari";
                echo trim($masa);
              ?>
            </td>
            <td>
              <?php
                $inaktif = new DateTime($file["jadwal_inaktif"]);
                $today = new DateTime();
                $endInaktif = (clone $inaktif)->modify('+3 days');
                if ($today >= $inaktif && $today < $endInaktif) {
                    echo $today->diff($endInaktif)->days . " hari tersisa";
                } elseif ($today >= $endInaktif) {
                    echo "Masa inaktif berakhir";
                } else {
                    echo "Belum memasuki masa inaktif";
                }
              ?>
            </td>
            <td>
              <?php
                $aktif = new DateTime($file["jadwal_aktif"]);
                $inaktif = new DateTime($file["jadwal_inaktif"]);
                $pemusnahan = (clone $inaktif)->modify('+1 year');

                if ($today >= $aktif && $today < $inaktif) {
                    echo '<span class="badge badge-success text-dark">Aktif</span>';
                } elseif ($today >= $inaktif && $today < $pemusnahan) {
                    echo '<span class="badge badge-warning text-dark">Inaktif</span>';
                } else {
                    echo '<span class="badge badge-danger text-dark">Dimusnahkan</span>';
                }
              ?>
            </td>
            <td><?= htmlspecialchars($file["keterangan"]) ?></td>
            <td><?= htmlspecialchars($file["lokasi_rak"]) ?></td>
            <td><?= htmlspecialchars($file["lokasi_shelf"]) ?></td>
            <td><?= htmlspecialchars($file["lokasi_boks"]) ?></td>
            <td><?= htmlspecialchars($file["klasifikasi_keamanan"]) ?></td>
            <td><?= htmlspecialchars($file["hak_akses"]) ?></td>
            <td><?= htmlspecialchars($file["bidang"]) ?></td>
            <td><?= htmlspecialchars($file["upload_date"]) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <a href="javascript:history.back()" class="btn btn-secondary">← Kembali</a>
  </div>
</body>
</html>
  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Open Sans', sans-serif;
      color: #023858;
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

    .content-wrapper {
      background: #f4faff;
      padding: 2.5rem;
      margin-top: 2rem;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 113, 188, 0.1);
      max-width: 95%;
      margin-left: auto;
      margin-right: auto;
    }

    h2 {
      font-size: 1.9rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      letter-spacing: 1px;
    }

    table {
      background-color: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0, 113, 188, 0.08);
    }

    thead {
      background-color: #e0f1ff;
    }

    thead th {
      color: #005b90;
      font-weight: bold;
    }

    tbody tr:hover {
      background-color: #eaf6ff;
    }

    .badge-success {
      background-color: #d4edda !important;
    }

    .badge-warning {
      background-color: #fff3cd !important;
    }

    .badge-danger {
      background-color: #f8d7da !important;
    }

    .btn-secondary {
      margin-top: 1.5rem;
      background-color: #0071bc;
      border: none;
      font-weight: 600;
      border-radius: 8px;
      padding: 10px 20px;
    }

    .btn-secondary:hover {
      background-color: #005b90;
    }
</style>