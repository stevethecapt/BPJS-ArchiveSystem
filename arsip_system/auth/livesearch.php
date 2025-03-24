<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../config/database.php");

if (!$pdo) {
    die("Koneksi database gagal!");
}

if (isset($_POST['search'])) {
    $search = trim($_POST['search']);
    
    $stmt = $pdo->prepare("SELECT judul_berkas FROM arsip WHERE judul_berkas LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        echo '<ul>';
        foreach ($results as $row) {
            echo '<li>' . htmlspecialchars($row['judul_berkas']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<ul><li>Tidak ditemukan</li></ul>';
    }
}
?>
