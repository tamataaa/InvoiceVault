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

if (file_exists($file)) {
    unlink($file);
}

$invoiceModel->delete($id);

header("Location: ../views/dashboard/dashboard.php?success=delete");
exit;