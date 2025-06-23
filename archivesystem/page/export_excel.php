<?php
require '../vendor/autoload.php';
require_once("../config/database.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$bidang = $_GET['bidang'] ?? '';
$status = $_GET['status'] ?? '';
$filename = "arsip";
if (!empty($status)) {
    $filename .= "_{$status}";
} elseif (!empty($bidang)) {
    $filename .= "_" . strtolower($bidang);
}
$filename .= ".xlsx";

// Ambil data
try {
    if (!empty($status)) {
        $sql = "SELECT * FROM (
                    SELECT *, 
                        CASE 
                            WHEN CURDATE() < jadwal_inaktif THEN 'Aktif' 
                            WHEN CURDATE() BETWEEN jadwal_inaktif AND DATE_ADD(jadwal_inaktif, INTERVAL 1 YEAR) THEN 'Inaktif'
                            ELSE 'Pemusnahan'
                        END AS status_arsip
                    FROM arsip
                ) AS sub WHERE status_arsip = :status
                ORDER BY upload_date DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
    } elseif (!empty($bidang) && $bidang !== 'semua') {
        $stmt = $pdo->prepare("SELECT * FROM arsip WHERE bidang = :bidang ORDER BY upload_date DESC");
        $stmt->bindParam(':bidang', $bidang);
    } else {
        $stmt = $pdo->query("SELECT * FROM arsip ORDER BY upload_date DESC");
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Create spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $headers = [
        "ID", "Nomor Berkas", "Judul Berkas", "Nomor Item Berkas", "Kode Klasifikasi",
        "Uraian Isi", "Kurun Tanggal", "Kurun Tahun", "Jumlah", "Satuan",
        "Tingkat Perkembangan", "Jadwal Aktif", "Jadwal Inaktif", "Keterangan",
        "Lokasi Rak", "Lokasi Shelf", "Lokasi Boks", "Klasifikasi Keamanan",
        "Hak Akses", "Upload Date", "Bidang"
    ];
    $sheet->fromArray($headers, null, 'A1');

    // Isi data
    $rowNum = 2;
    foreach ($data as $row) {
        $sheet->fromArray([
            $row['id'],
            $row['nomor_berkas'],
            $row['judul_berkas'],
            $row['nomor_item_berkas'],
            $row['kode_klasifikasi'],
            $row['uraian_isi'],
            date('d-m-Y', strtotime($row['kurun_tanggal'])),
            $row['kurun_tahun'],
            $row['jumlah'],
            $row['satuan'],
            $row['tingkat_perkembangan'],
            date('d-m-Y', strtotime($row['jadwal_aktif'])),
            date('d-m-Y', strtotime($row['jadwal_inaktif'])),
            $row['keterangan'],
            $row['lokasi_rak'],
            $row['lokasi_shelf'],
            $row['lokasi_boks'],
            $row['klasifikasi_keamanan'],
            $row['hak_akses'],
            date('d-m-Y', strtotime($row['upload_date'])),
            $row['bidang'],
        ], null, "A{$rowNum}");
        $rowNum++;
    }

    // Styling header
    $sheet->getStyle('A1:U1')->getFont()->setBold(true);
    $sheet->getStyle('A1:U1')->getFill()->setFillType('solid')->getStartColor()->setRGB('BDD7EE');

    // Download file
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Cache-Control: max-age=0");

    $writer = new Xlsx($spreadsheet);
    $writer->save("php://output");

} catch (PDOException $e) {
    echo "Gagal mengambil data arsip: " . $e->getMessage();
}
