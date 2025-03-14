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

    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM arsip WHERE jadwal_aktif <= CURDATE() AND jadwal_inaktif > CURDATE()");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $arsip_aktif = $result['total'] ?? 0;

    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM arsip WHERE jadwal_inaktif <= CURDATE()");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $arsip_inaktif = $result['total'] ?? 0;
} catch (PDOException $e) {
    $total_arsip = $arsip_aktif = $arsip_inaktif = 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav>
        <img src="img/bpjs.png" class="img" alt="logo">
        <div class="top-right">
            <a href="dashboard/arsiplist.php" class="logoutbtn">Logout</a>
            <img src="img/download.jpeg" alt="User Profile">
            <span class="username">Username</span>
        </div>
    </nav>
    
    <div class="sidebar">
        <h5>Bidang</h5>
        <a href="dashboard/SDM.php" class="sidetext">SDM, Umum dan Komunikasi</a>
        <a href="dashboard/perencanaan.php" class="sidetext">Perencanaan dan Keuangan</a>
        <a href="dashboard/kepersertaan.php" class="sidetext">Kepersertaan dan Mutu Layanan</a>
        <a href="dashboard/jaminan.php" class="sidetext">Jaminan Pelayanan Kesehatan</a>
        <a href="dashboard/inputdata.php" class="sidetext">Masukan Data</a>
    </div>
    
    <div class="content">
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
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h6>Arsip Inaktif</h6>
                        <p><?php echo htmlspecialchars($arsip_inaktif); ?></p>
                    </div>
                </div>
            </a>
        </div>
    </div>
        
        <h4 class="mt-4">Daftar Arsip</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Berkas</th>
                    <th>Unit Kerja</th>
                    <th>Tanggal</th>
                    <th>Klasifikasi</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Rawat Jalan Tingkat Pertama</td>
                    <td>PMU</td>
                    <td>13 Agustus 2025</td>
                    <td>Terbatas</td>
                    <td>Boks A1</td>
                    <td><a href="#" class="btn btn-sm btn-info">Detail</a></td>
                </tr>
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

nav .img {
    height: 38px;
    width: 180px;
    object-fit: cover;
}

.top-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar {
    width: 230px;
    height: 100vh;
    background-color: #fff;
    position: fixed;
    top: 60px;
    left: 0;
    padding-top: 20px;
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

.content {
    margin-left: 250px;
    padding: 80px 20px 20px;
    flex-grow: 1;
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
    margin-top: 20px;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
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
}

thead {
    background-color: #007bff;
    color: white;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
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