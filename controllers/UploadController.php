<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../views/dashboard/dashboard.php?success=upload");
    exit;
}

$file = $_FILES['invoice'];

if ($file['error'] != 0) {
    die("Terjadi kesalahan saat upload.");
}

$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if ($extension != "pdf") {
    header("Location: ../views/dashboard/dashboard.php?error=format");
    exit;
}

$folderUpload = "../uploads/";

$tujuan = $folderUpload . $file['name'];

// Cek apakah file sudah ada
if (file_exists($tujuan)) {
    header("Location: ../views/dashboard/dashboard.php?error=duplicate");
    exit;
}

if (move_uploaded_file($file['tmp_name'], $tujuan)) {

    $namaFile = $file['name'];

    $ukuran = $file['size'];

    $tipeFile = $extension;

    $bulan = date("F");

    $tahun = date("Y");

    $s3Key = "-";

    $s3Url = "-";

    $adminId = $_SESSION['admin_id'];

    $query = "INSERT INTO invoice
                (
                    admin_id,
                    nama_file,
                    ukuran,
                    tipe_file,
                    bulan,
                    tahun,
                    s3_key,
                    s3_url
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                )";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "isississ",
        $adminId,
        $namaFile,
        $ukuran,
        $tipeFile,
        $bulan,
        $tahun,
        $s3Key,
        $s3Url
    );

    mysqli_stmt_execute($stmt);

    header("Location: ../views/dashboard/dashboard.php?success=upload");
    exit;

} else {

    header("Location: ../views/dashboard/dashboard.php?error=upload");
    exit;

}