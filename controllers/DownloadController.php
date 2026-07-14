<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Invoice.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = (int) $_GET['id'];

$invoiceModel = new Invoice($conn);

$invoice = $invoiceModel->getById($id);

if (!$invoice) {
    die("Data tidak ditemukan.");
}

$file = "../uploads/" . $invoice['nama_file'];

if (!file_exists($file)) {
    die("File tidak ditemukan.");
}

header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"" . $invoice['nama_file'] . "\"");

readfile($file);

exit;