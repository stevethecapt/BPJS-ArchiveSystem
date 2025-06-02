<?php
session_start();
require_once("../../config/database.php");
if (!isset($_GET['bidang'])) {
    die("Bidang tidak ditemukan.");
}
$bidang = $_GET['bidang'];

$sql = "SELECT *, 
        CASE 
            WHEN CURDATE() < jadwal_inaktif THEN 'Aktif' 
            WHEN CURDATE() BETWEEN jadwal_inaktif AND DATE_ADD(jadwal_inaktif, INTERVAL 1 YEAR) THEN 'Inaktif'
            ELSE 'Pemusnahan'
        END AS status_arsip
        FROM arsip 
        WHERE bidang = :bidang 
        ORDER BY upload_date DESC";
        
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':bidang', $bidang, PDO::PARAM_STR);
$stmt->execute();
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$files) {
    die("Data tidak ditemukan untuk bidang ini.");
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM arsip WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);
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
  <main>
    <header>
      <img src="../../img/bpjs.png" alt="Logo BPJS" class="header-logo" />
    </header>
    <section class="content-section">
      <h2 class="mb-4">Daftar Arsip <?= ($bidang == "Total") ? "Total Arsip" : "Bidang $bidang"; ?> Kedeputian Wilayah X BPJS Kesehatan</h2>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nomor Berkas</th>
              <th>Judul</th>
              <th>Item</th>
              <th>Kode</th>
              <th>Isi</th>
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
              <th>Tanggal Upload</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($files as $file) : ?>
              <tr>
                <td><?= htmlspecialchars($file["id"]); ?></td>
                <td><?= htmlspecialchars($file["nomor_berkas"]); ?></td>
                <td><?= htmlspecialchars($file["judul_berkas"]); ?></td>
                <td><?= htmlspecialchars($file["nomor_item_berkas"]); ?></td>
                <td><?= htmlspecialchars($file["kode_klasifikasi"]); ?></td>
                <td><?= htmlspecialchars($file["uraian_isi"]); ?></td>
                <td><?= htmlspecialchars($file["kurun_tanggal"]); ?></td>
                <td><?= htmlspecialchars($file["kurun_tahun"]); ?></td>
                <td><?= htmlspecialchars($file["jumlah"]); ?></td>
                <td><?= htmlspecialchars($file["satuan"]); ?></td>
                <td><?= htmlspecialchars($file["tingkat_perkembangan"]); ?></td>
                <td>
                  <?php
                  $start_date = new DateTime($file["jadwal_aktif"]);
                  $end_date = new DateTime($file["jadwal_inaktif"]);
                  $interval = $start_date->diff($end_date);
                  $masa_aktif = ($interval->y ? $interval->y . " tahun " : "") .
                                ($interval->m ? $interval->m . " bulan " : "") .
                                ($interval->d ? $interval->d . " hari" : "");
                  echo htmlspecialchars(trim($masa_aktif));
                  ?>
                </td>
                <td>
                  <?php
                  $inactive_start = new DateTime($file["jadwal_inaktif"]);
                  $today = new DateTime();
                  $inactive_end = clone $inactive_start;
                  $inactive_end->modify('+3 days');

                  if ($today >= $inactive_start && $today < $inactive_end) {
                    $diff = $today->diff($inactive_end);
                    echo htmlspecialchars($diff->days . " hari tersisa");
                  } elseif ($today >= $inactive_end) {
                    echo "Masa inaktif berakhir";
                  } else {
                    echo "Belum memasuki masa inaktif";
                  }
                  ?>
                </td>
                <td>
                  <?php
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
                <td><?= htmlspecialchars($file["keterangan"]); ?></td>
                <td><?= htmlspecialchars($file["lokasi_rak"]); ?></td>
                <td><?= htmlspecialchars($file["lokasi_shelf"]); ?></td>
                <td><?= htmlspecialchars($file["lokasi_boks"]); ?></td>
                <td><?= htmlspecialchars($file["klasifikasi_keamanan"]); ?></td>
                <td><?= htmlspecialchars($file["hak_akses"]); ?></td>
                <td><?= htmlspecialchars($file["bidang"]); ?></td>
                <td><?= htmlspecialchars($file["upload_date"]); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <a href="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? '../dashboard.php'); ?>" class="kembalibtn">← Kembali</a>
    </section>
  </main>
</body>
</html>
<style>
    body {
      font-family: 'Open Sans', sans-serif;
      background: #f8fafc;
      color: #023858;
      margin: 0;
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
    .profile span {
      font-weight: bold;
      cursor: pointer;
    }
    #profilePopup {
      position: absolute;
      top: 60px;
      right: 0;
      width: 250px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      padding: 15px;
      display: none;
      z-index: 999;
    }
    .content-section {
      padding: 2rem;
      max-width: 1200px;
      margin: auto;
      background: #fff;
      margin-top: 2rem;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 113, 188, 0.1);
    }
    table {
      font-size: 0.9rem;
    }
    .badge {
      padding: 0.5em 0.75em;
      font-size: 0.8rem;
    }
    .kembalibtn {
      display: inline-block;
      margin: 1.5rem auto;
      padding: 10px 20px;
      background: #0071bc;
      color: white;
      border-radius: 8px;
      text-align: center;
      text-decoration: none;
    }
    .kembalibtn:hover {
      background: #005b90;
    }
    @media screen and (max-width: 768px) {
      table {
        font-size: 0.8rem;
      }
      header {
        flex-direction: column;
        align-items: flex-start;
      }
    }
</style>