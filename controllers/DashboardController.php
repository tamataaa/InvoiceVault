<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Invoice.php';

$invoiceModel = new Invoice($conn);

/*
|--------------------------------------------------------------------------
| Ambil parameter dari URL
|--------------------------------------------------------------------------
*/

$search = isset($_GET['search'])
    ? trim($_GET['search'])
    : "";

$bulan = isset($_GET['bulan'])
    ? trim($_GET['bulan'])
    : "";

/*
|--------------------------------------------------------------------------
| Ambil daftar invoice
|--------------------------------------------------------------------------
*/

$invoiceList = $invoiceModel->getInvoices($search, $bulan);

/*
|--------------------------------------------------------------------------
| Hitung statistik berdasarkan invoice yang sedang tampil
|--------------------------------------------------------------------------
*/

$statistik = $invoiceModel->calculateStatistics($invoiceList);

$totalInvoice = $statistik['totalInvoice'];

$totalStorage = $statistik['totalStorage'];

$uploadToday = $statistik['uploadToday'];