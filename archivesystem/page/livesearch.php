<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../config/database.php");

if (!$pdo) {
    die("Koneksi database gagal!");
}

if (isset($_POST['search'])) {
    $search = trim($_POST['search']);
    echo '<div style="position: absolute; top: calc(100% - 12px); left: 0; 
            background: white; border: 1px solid #ccc; width: 100%;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1); z-index: 999;
            padding-top: 2px; padding-bottom: 2px;">';
    $stmt = $pdo->prepare("SELECT judul_berkas FROM arsip WHERE judul_berkas LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        $seen = [];
        echo '<div>';
        foreach ($results as $row) {
            $judul = htmlspecialchars($row['judul_berkas']);
            if (!in_array($judul, $seen)) {
                echo '<a href="search.php?search=' . urlencode($judul) . '
                "style="display: block; padding: 8px 15px; color: black; text-decoration: none;
                font-size: 16px; margin-left: 5px">' . $judul . '</a><br>';
                $seen[] = $judul;
            }
        }
        echo '</div>';
    }    
}
?>