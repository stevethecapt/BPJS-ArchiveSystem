<?php
require_once("../config/database.php");

// Ambil bidang dari parameter GET
$bidang = isset($_GET['bidang']) ? $_GET['bidang'] : '';

// Set header untuk .xls (bukan CSV lagi)
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=arsip_" . strtolower($bidang) . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

if (!empty($bidang)) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM arsip WHERE bidang = :bidang ORDER BY upload_date DESC");
        $stmt->bindParam(':bidang', $bidang);
        $stmt->execute();

        echo "<table border='1'>";
        echo "<thead style='background-color:#d9e1f2; font-weight:bold; text-align:center;'>
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
                    <th>Jadwal Aktif</th>
                    <th>Jadwal Inaktif</th>
                    <th>Keterangan</th>
                    <th>Lokasi Rak</th>
                    <th>Lokasi Shelf</th>
                    <th>Lokasi Boks</th>
                    <th>Klasifikasi Keamanan</th>
                    <th>Hak Akses</th>
                    <th>Upload Date</th>
                    <th>Bidang</th>
                </tr>
              </thead>";
        echo "<tbody>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $kurun_tanggal = date('d-m-Y', strtotime($row['kurun_tanggal']));
            $jadwal_aktif = date('d-m-Y', strtotime($row['jadwal_aktif']));
            $jadwal_inaktif = date('d-m-Y', strtotime($row['jadwal_inaktif']));
            $upload_date = date('d-m-Y', strtotime($row['upload_date']));

            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nomor_berkas']}</td>
                    <td>{$row['judul_berkas']}</td>
                    <td>{$row['nomor_item_berkas']}</td>
                    <td>{$row['kode_klasifikasi']}</td>
                    <td>{$row['uraian_isi']}</td>
                    <td>{$kurun_tanggal}</td>
                    <td>{$row['kurun_tahun']}</td>
                    <td>{$row['jumlah']}</td>
                    <td>{$row['satuan']}</td>
                    <td>{$row['tingkat_perkembangan']}</td>
                    <td>{$jadwal_aktif}</td>
                    <td>{$jadwal_inaktif}</td>
                    <td>{$row['keterangan']}</td>
                    <td>{$row['lokasi_rak']}</td>
                    <td>{$row['lokasi_shelf']}</td>
                    <td>{$row['lokasi_boks']}</td>
                    <td>{$row['klasifikasi_keamanan']}</td>
                    <td>{$row['hak_akses']}</td>
                    <td>{$upload_date}</td>
                    <td>{$row['bidang']}</td>
                  </tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } catch (PDOException $e) {
        echo "Gagal mengambil data arsip: " . $e->getMessage();
    }
} else {
    echo "Bidang tidak ditemukan di parameter URL.";
}
?>
