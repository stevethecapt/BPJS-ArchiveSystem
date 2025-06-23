<?php
session_start();
require_once("../../config/database.php");

if (!$pdo) {
    die("Koneksi ke database gagal.");
}

try {
    $sql = "SELECT * FROM arsip WHERE TRIM(bidang) = :bidang ORDER BY upload_date DESC";
    $stmt = $pdo->prepare($sql);
    $bidang = "Jaminan Pelayanan Kesehatan";
    $stmt->bindParam(':bidang', $bidang, PDO::PARAM_STR);
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT fullname, username, email, phone, bidang FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Jaminan Pelayanan Kesehatan</title>
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
     <div class="logo">Menu</div>
        <nav>
        <a href="../dashboard.php" class="sidetext" title="Dashboard">Home</a>
        <a href="inputdata.php" class="sidetext" title="Masukan Data">Masukan Data</a>
        <a href="SDM.php" class="sidetext" title="SDM, Umum dan Komunikasi">SDM, Umum dan Komunikasi</a>
        <a href="perencanaan.php" class="sidetext" title="Perencanaan dan Keuangan">Perencanaan dan Keuangan</a>
        <a href="kepersertaan.php" class="sidetext" title="Kepersertaan dan Mutu Layanan">Kepersertaan dan Mutu Layanan</a>
        <a href="jaminan.php" class="sidetext active" title="Jaminan Pelayanan Kesehatan">Jaminan Pelayanan Kesehatan</a>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <img src="../../img/bpjs.png" alt="Logo BPJS" class="header-logo" />
            <form method="GET" action="../search.php" style="position: relative; margin-left: auto; margin-right: 20px;">
                <input type="text" id="search" name="search" placeholder="Cari arsip..." autocomplete="off"
                    style="padding: 8px 35px 8px 15px; border-radius: 15px; border: 1px solid #ccc; outline: none;">
                <button type="submit"
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                    <i class="fa fa-search" style="font-size: 16px; color: #666;"></i>
                </button>
                <div id="livesearch"
                    style="position: absolute; background: white; width: 100%; border: 1px solid #ccc; display: none;"></div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                $(document).ready(function () {
                    $("#search").keyup(function () {
                        var query = $(this).val();
                        if (query !== "") {
                            $.ajax({
                                url: "../livesearch.php",
                                method: "POST",
                                data: { search: query },
                                success: function (data) {
                                    $("#livesearch").fadeIn();
                                    $("#livesearch").html(data);
                                }
                            });
                        } else {
                            $("#livesearch").fadeOut();
                        }
                    });
                    $(document).on("click", "li", function () {
                        $("#search").val($(this).text());
                        $("#livesearch").fadeOut();
                    });
                    $(document).on("click", function (e) {
                        if (!$(e.target).closest("#search, #livesearch").length) {
                            $("#livesearch").fadeOut();
                        }
                    });
                });
                </script>
            </form>
            <div class="profile" style="position: relative;">
                <span style="cursor: pointer;" onclick="toggleProfilePopup()">
                    <?php echo htmlspecialchars($_SESSION['username'] ?? 'Pengguna'); ?>
                </span>
                <div id="profilePopup" style="display: none; position: absolute; top: 60px; right: 0; width: 250px; padding: 20px; background: #f4faff; border-radius: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); text-align: center; z-index: 999;">
                    <p style="font-size: 18px; font-weight: bold; margin-top: 10px; margin-bottom: 12px; color: #023858;">
                        <?php echo htmlspecialchars($user['fullname'] ?? 'Nama Tidak Ditemukan'); ?>
                    </p>
                    <p style="font-size: 14px; color: #666; margin-bottom: 8px;">
                        <?php echo htmlspecialchars($user['email'] ?? 'example@youremail.com'); ?>
                    </p>
                    <p style="font-size: 14px; color: #666; margin-bottom: 8px;">
                        <?php echo htmlspecialchars($user['phone'] ?? 'Your Number'); ?>
                    </p>
                    <p style="font-size: 14px; color: #666; margin-bottom: 12px;">
                        <?php echo htmlspecialchars($user['bidang'] ?? 'Bidang'); ?>
                    </p>
                    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                        <a href="../profile/profile.php" style="display: inline-flex; align-items: center; gap: 5px; background: transparent; color: #023858; text-decoration: none; padding: 8px 10px; border-radius: 10px; font-weight: bold; font-size: 13px;">
                            <i class="fas fa-user-edit"></i> Update Profile
                        </a>
                        <a href="logout.php" style="display: inline-flex; align-items: center; gap: 5px; background: transparent; color: #023858; text-decoration: none; padding: 8px 10px; border-radius: 10px; font-weight: bold; font-size: 13px;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            <script>
            function toggleProfilePopup() {
                var popup = document.getElementById("profilePopup");
                popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
            }
            </script>
        </header>
    <div class="content-section">
        <h2>Jaminan Pelayanan Kesehatan</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Berkas</th>
                        <th>Uraian Isi</th>
                        <th>Kode Klasifikasi</th>
                        <th>Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($file["id"]); ?></td>
                        <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                        <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                        <td><?php echo htmlspecialchars($file["kode_klasifikasi"]); ?></td>
                        <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="btn-container">
            <a href="inputdata.php" class="inputbtn">Input</a>
            <a href="detail.php?bidang=<?php echo urlencode($bidang); ?>" class="btn-info">Detail</a>
            <a href="../export_excel.php?bidang=<?php echo urlencode($bidang);?>" class="downloadbtn">Download</a>
        </div>
    </div>
</body>
</html>
<style>
    *, *::before, *::after {
      box-sizing: border-box;
    }
    body, html {
      margin: 0;
      height: 100%;
      font-family: 'Open Sans', sans-serif;
      background: #f8fafc;
      color: #023858;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      user-select: none;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    .dashboard {
      display: flex;
      min-height: 100vh;
      background: #f8fafc;
    }

    .sidebar {
        width: 220px;
        background: #0071bc;
        display: flex;
        flex-direction: column;
        padding: 2rem 1.5rem;
        box-shadow: 2px 0 6px rgba(0,0,0,0.1);
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
    }

    .sidebar .logo {
      font-weight: 600;
      font-size: 1.8rem;
      color: rgb(243, 243, 243);
      margin-bottom: 3rem;
      text-align: center;
      letter-spacing: 1.5px;
      margin-top: 30px;
    }

    .sidebar nav a {
      padding: 12px 16px;
      margin-bottom: 0.9rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1.05rem;
      color:rgb(243, 243, 243);
      transition: background-color 0.25s ease, color 0.25s ease;
      display: block;
      user-select: none;
      text-align: center;
    }

    .sidebar nav a:hover, .sidebar nav a.active {
      background: #f4faff;
      color: #0071bc;
    }

    .main-content {
        flex: 1;
        padding: 2.5rem 3rem;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        box-shadow: inset 3px 0 8px rgba(0,0,0,0.05);
        margin-left: 220px;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.8rem;
        border-bottom: 2px solid #a7d4ff;
        padding-bottom: 0.8rem;
        position: sticky;
        top: 0;
        background: #ffffff;
        z-index: 900;
    }

    .header-logo {
        height: 2.6rem;
        font-weight: 600;
        color: #023858;
        user-select: none;
        display: inline-block;
        object-fit: contain;
    }

    .profile {
      display: flex;
      align-items: center;
    }

    .profile span {
      font-weight: 600;
      font-size: 1rem;
      color: #023858;
    }

    .content-section {
      background: #f4faff;
      padding: 2.3rem 2.8rem;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 113, 188, 0.1);
      color: #023858;
      user-select: none;
      max-width: 1100px;
      line-height: 1.5;
    }

    .content-section h2 {
      margin-bottom: 1.3rem;
      font-weight: 600;
      font-size: 1.9rem;
      letter-spacing: 1.1px;
    }

    .content-section p {
      font-size: 1rem;
    }

    @media (max-width: 860px) {
      .sidebar {
        width: 70px;
        padding: 2rem 1rem;
      }
      .sidebar .logo {
        font-size: 1rem;
        margin-bottom: 2rem;
        letter-spacing: 0;
        text-align: center;
      }
      .sidebar nav a {
        font-size: 0;
        padding: 12px 0;
      }
      .main-content {
        padding: 2rem 1.5rem;
      }
      header {
        flex-direction: column;
        align-items: flex-start;
      }
      header h1 {
        margin-bottom: 1rem;
      }
      .content-section {
        max-width: 100%;
        padding: 1.6rem 2rem;
      }
    }
    .content-section table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background-color: #f4faff;
        color: #023858;
        border-radius: 10px;
        overflow: hidden;
        font-size: 0.95rem;
    }

    .content-section thead {
        background-color: #f4faff;
    }

    .content-section thead th {
        padding: 1rem 1.2rem;
        text-align: left;
        font-weight: 700;
        color: #005b90;
        border-bottom: 2px solid #005b90;
    }

    .content-section tbody tr {
        transition: background-color 0.2s ease;
    }

    .content-section tbody tr:hover {
        background-color: #eaf6ff;
    }

    .content-section tbody td {
        padding: 0.85rem 1.2rem;
        border-bottom: 1px solid #c6e4f9;
    }

    .content-section tbody tr:last-child td {
        border-bottom: none;
    }
    .content-section .btn-container {
        margin-top: 1.5rem;
    }
    .content-section .inputbtn {
        background-color: #0071bc;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s ease;
        margin-right: 10px;
    }

    .content-section .inputbtn:hover {
        background-color: #005b90;
    }
    .content-section .btn-info {
        background-color: #0071bc;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s ease;
        margin-right: 10px;
    }

    .content-section .btn-info:hover {
        background-color: #005b90;
    }
    .content-section .downloadbtn {
        background-color: #0071bc;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.2s ease;
        margin-right: 10px;
    }

    .content-section .downloadbtn:hover {
        background-color: #005b90;
    }
</style>