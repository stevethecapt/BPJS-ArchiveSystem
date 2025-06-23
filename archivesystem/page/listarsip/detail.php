<?php
session_start();
require_once("../../config/database.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$type = isset($_GET['type']) && in_array($_GET['type'], ['total', 'aktif', 'inaktif', 'pemusnahan']) ? $_GET['type'] : 'total';

try {
    $today = date('Y-m-d');

    switch ($type) {
        case 'aktif':
            $query = "SELECT * FROM arsip WHERE status != 'dimusnahkan' AND jadwal_aktif <= CURDATE() AND jadwal_inaktif > CURDATE() ORDER BY jadwal_aktif DESC";
            $title = "Detail Arsip Aktif";
            break;
        case 'inaktif':
            $query = "SELECT * FROM arsip WHERE jadwal_inaktif <= CURDATE() ORDER BY id ASC";
            $title = "Detail Arsip Inaktif";
            break;
        case 'pemusnahan':
            $query = "SELECT * FROM arsip WHERE status != 'dimusnahkan' AND jadwal_inaktif <= DATE_SUB(CURDATE(), INTERVAL 3 DAY) ORDER BY jadwal_inaktif ASC";
            $title = "Detail Arsip Pemusnahan";
            break;
        default:
            $query = "SELECT * FROM arsip WHERE status != 'dimusnahkan' ORDER BY upload_date DESC";
            $title = "Detail Total Arsip";
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
  <img src="../../img/bpjs.png" alt="Logo BPJS" class="header-logo" />
</header>

<div class="content-wrapper">
  <h2><?= htmlspecialchars($title) ?></h2>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nomor Berkas</th>
          <th>Judul Berkas</th>
          <th>Bidang</th>
          <th>Upload</th>
          <th>Jadwal Aktif</th>
          <th>Jadwal Inaktif</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($files)) : ?>
          <?php foreach ($files as $file) : ?>
          <?php
            $today = new DateTime();
            $aktif = new DateTime($file["jadwal_aktif"]);
            $inaktif = new DateTime($file["jadwal_inaktif"]);
            $pemusnahan = (clone $inaktif)->modify('+3 days');
            $status = '';

            if ($today < $aktif) {
                $status = '<span class="badge bg-secondary">Belum Aktif</span>';
            } elseif ($today >= $aktif && $today < $inaktif) {
                $status = '<span class="badge bg-success">Aktif</span>';
            } elseif ($today >= $inaktif && $today < $pemusnahan) {
                $status = '<span class="badge bg-warning text-dark">Inaktif</span>';
            } else {
                $status = '<span class="badge bg-danger">Pemusnahan</span>';
            }
          ?>
          <tr>
            <td><?= htmlspecialchars($file["id"]) ?></td>
            <td><?= htmlspecialchars($file["nomor_berkas"]) ?></td>
            <td><?= htmlspecialchars($file["judul_berkas"]) ?></td>
            <td><?= htmlspecialchars($file["bidang"]) ?></td>
            <td><?= htmlspecialchars($file["upload_date"]) ?></td>
            <td><?= htmlspecialchars($file["jadwal_aktif"]) ?></td>
            <td><?= htmlspecialchars($file["jadwal_inaktif"]) ?></td>
            <td>                  <?php
              $aktif_start = new DateTime($file["jadwal_aktif"]);
              $inactive_start = new DateTime($file["jadwal_inaktif"]);
              $destroy_start = (clone $inactive_start)->modify('+1 year');
              if ($today >= $aktif_start && $today < $inactive_start) {
                echo '<span class="badge bg-success">Aktif</span>';
              } elseif ($today >= $inactive_start && $today < $destroy_start) {
                echo '<span class="badge bg-warning text-dark">Inaktif</span>';
              } else {
                echo '<span class="badge bg-danger">Dimusnahkan</span>';
              }
              ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr><td colspan="8" class="text-center">Tidak ada data ditemukan.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="mt-4 text-center">
    <a href="javascript:history.back()" class="btn btn-secondary">← Kembali</a>
  </div>
</div>

<style>
  body {
    background-color: #f8fafc;
    font-family: 'Open Sans', sans-serif;
    color: #023858;
  }
  header {
    display: flex;
    align-items: center;
    justify-content: space-between;
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
    max-width: 95%;
    margin: 2rem auto;
    background: #f4faff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 113, 188, 0.1);
  }
  h2 {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    text-align: center;
  }
</style>
</body>
</html>
