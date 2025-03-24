<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
require_once("../config/database.php");

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM arsip");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_arsip = $result['total'] ?? 0;

    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total 
        FROM arsip 
        WHERE jadwal_aktif <= CURDATE() 
        AND jadwal_inaktif > CURDATE()
    ");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $arsip_aktif = $result['total'] ?? 0;

    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total 
        FROM arsip 
        WHERE jadwal_inaktif <= CURDATE() 
        AND jadwal_inaktif > DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    ");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $arsip_inaktif = $result['total'] ?? 0;

    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total 
        FROM arsip 
        WHERE jadwal_inaktif <= DATE_SUB(CURDATE(), INTERVAL 3 DAY)
    ");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $arsip_pemusnahan = $result['total'] ?? 0;

} catch (PDOException $e) {
    $total_arsip = $arsip_aktif = $arsip_inaktif = $arsip_pemusnahan = 0;
}

$sqlRecentFiles = "SELECT * FROM arsip ORDER BY upload_date DESC LIMIT 5";
$stmtRecentFiles = $pdo->prepare($sqlRecentFiles);
$stmtRecentFiles->execute();
$recentFiles = $stmtRecentFiles->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Dashboard</title>
</head>
<body>
    <nav>
        <img src="img/bpjs.png" class="img">
        <div class="top-right">
            <a href="logout.php" class="logoutbtn">Logout</a>
            <!-- <img src=""> -->
            <span class="username"><?php if (isset($_SESSION['username'])): ?>
            <?php echo htmlspecialchars($_SESSION['username']); ?></li>
        <?php endif; ?></span>
        </div>
    </nav>
    
    <div class="sidebar">
        <a href="dashboard/SDM.php" class="sidetext">SDM, Umum dan Komunikasi</a>
        <a href="dashboard/perencanaan.php" class="sidetext">Perencanaan dan Keuangan</a>
        <a href="dashboard/kepersertaan.php" class="sidetext">Kepersertaan dan Mutu Layanan</a>
        <a href="dashboard/jaminan.php" class="sidetext">Jaminan Pelayanan Kesehatan</a>
        <a href="dashboard/inputdata.php" class="sidetext">Masukan Data</a>
    </div>
    
    <div class="card-container">
        <div class="row">
            <div class="col-md-3">
                <a href="listarsip/totalarsip.php" class="text-decoration-none card-link">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6>Total Arsip</h6>
                            <p><?php echo htmlspecialchars($total_arsip); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="listarsip/arsipaktif.php" class="text-decoration-none card-link">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6>Arsip Aktif</h6>
                            <p><?php echo htmlspecialchars($arsip_aktif); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="listarsip/arsipinaktif.php" class="text-decoration-none card-link">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h6>Arsip Inaktif</h6>
                            <p><?php echo number_format($arsip_inaktif); ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="listarsip/pemusnahan.php" class="text-decoration-none card-link">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h6>Pemusnahan</h6>
                            <p><?php echo number_format($arsip_pemusnahan); ?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
            <h4 class="mb-3">Baru saja</h4>
        </div>
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Nomor Berkas</th>
                <th>Kode Klasifikasi</th>
                <th>Judul Berkas</th>
                <th>Uraian Isi</th>
                <th>Bidang</th>
                <th>Upload Date</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($recentFiles as $file) { ?>
            <tr>
                <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                <td><?php echo htmlspecialchars($file["kode_klasifikasi"]); ?></td>
                <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                <td>
                    <a href="detailsugestion.php?id=<?php echo urlencode($file['id']); ?>" class="btn btn-sm btn-info">Detail</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</body>
</html>
<style>
body {
    display: flex;
    flex-direction: column;
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

nav {
    width: 100%;
    background: #fff;
    position: fixed;
    top: 0;
    left: 0;
    padding: 15px 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 1000;
}

.img {
    height: 38px;
    width: 180px;
    object-fit: cover;
}

.top-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.username {
    font-weight: bold;
    font-size: 1rem;
    color: #333;
}

.logoutbtn {
    font-size: 1rem;
    font-weight: 500;
    color: white;
    border: none;
    background-color: #dc3545;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
}

.sidebar {
    width: 230px;
    height: 100vh;
    background-color: #fff;
    position: fixed;
    top: 60px;
    left: 0;
    padding-top: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.sidetext {
    padding: 10px 15px;
    display: block;
    color: black;
    text-decoration: none;
    text-align: center;
    width: 90%;
    font-size: 14px;
    border-radius: 5px;
}

.sidetext:hover {
    background: #007bff;
    color: white;
    transform: scale(1.05);
}

.card-container {
    margin-left: 250px;
    padding: 80px 20px 20px;
    flex-grow: 1;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.row {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

.card-link {
    display: block;
    text-decoration: none;
}

.card {
    width: 150px;
    height: 90px;
    padding: 3px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    margin: 10px auto; 
}

.card:hover {
    transform: scale(1.05);
}

.table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    text-align: center;
}

.btn-info {
    background-color: #17a2b8;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
}

.btn-info:hover {
    background-color: #138496;
}
</style>