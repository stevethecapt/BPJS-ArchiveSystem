<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Arsip</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f4f4f4;
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
            z-index: 1000;
        }

        nav .img {
            height: 38px;
            width: 180px;
            margin-right: auto;
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
            background-color: #f4f4f4;
            position: fixed;
            top: 60px;
            left: 0;
            padding-top: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidetext {
            padding: 8px 12px;
            display: block;
            color: black;
            text-decoration: none;
            text-align: center;
            width: 80%;
        }

        .logoutbtn {
            font-size: 1rem;
            font-weight: 500;
            color: white;
            border: none;
            background-color: rgb(199, 65, 65);
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
            margin-bottom: 20px;
        }


        .sidetext:hover {
            background: #e0e0e0;
        }

        .content {
            margin-left: 260px;
            padding: 80px 20px 20px;
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <nav>
        <img src="img/bpjs.png" class="img" alt="logo">
        <div class="top-right">
            <img src="img/download.jpeg" alt="User Profile">
            <span class="username">Username</span>
        </div>
    </nav>
    
    <div class="sidebar">
        <a href="dashboard/bidangSDM.php" class="sidetext">Bidang SDM, Umum dan Komunikasi</a>
        <a href="#" class="sidetext">Bidang Perencanaan dan Keuangan</a>
        <a href="#" class="sidetext">Bidang Kepersertaan dan Mutu Layanan</a>
        <a href="#" class="sidetext">Bidang Jaminan Pelayanan Kesehatan</a>
        <a href="logout.php" class="logoutbtn">Logout</a>
    </div>
    
    <div class="content">
        <h3>Dashboard Arsip</h3>
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Total Arsip</h5>
                        <p>100 Files</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Arsip Aktif</h5>
                        <p>75 Files</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5>Arsip Inaktif</h5>
                        <p>25 Files</p>
                    </div>
                </div>
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
                    <td>13 Agustus 2023</td>
                    <td>Terbatas</td>
                    <td>Boks A1</td>
                    <td><a href="#" class="btn btn-sm btn-info">Detail</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
