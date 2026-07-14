<?php

require_once '../../config/session.php';
require_once '../../controllers/DashboardController.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../layouts/header.php';
?>

        <nav class="navbar navbar-expand-lg bg-white shadow-sm border-bottom">

            <div class="container">

                <a
                    href="#"
                    class="navbar-brand d-flex align-items-center">

                    <div class="logo-circle me-3">

                        <i class="bi bi-cloud-check-fill"></i>

                    </div>

                    <div>

                        <div class="brand-title">

                            InvoiceVault

                        </div>

                        <small class="brand-subtitle">

                            Cloud Invoice Manager

                        </small>

                    </div>

                </a>

                <div class="d-flex align-items-center">

                    <div class="user-info text-end me-3">

                        <small class="text-muted d-block">

                            Login sebagai

                        </small>

                        <strong>

                            <?= htmlspecialchars($_SESSION['admin_name']); ?>

                        </strong>

                    </div>

                    <a
                        href="../../logout.php"
                        class="btn btn-outline-danger btn-sm">

                        <i class="bi bi-box-arrow-right me-1"></i>

                        Logout

                    </a>

                </div>

            </div>

        </nav>

        <div class="container mt-4">

            <?php if(isset($_GET['success'])): ?>

                <div class="toast-container">

                    <div
                        class="toast custom-toast show align-items-center text-bg-success border-0"
                        role="alert">

                        <div class="d-flex">

                            <div class="toast-body">

                                <strong>

                                    Berhasil

                                </strong>

                                <br>

                                <?= $message ?>

                            </div>

                            <button
                                type="button"
                                class="btn-close btn-close-white me-2 m-auto"
                                data-bs-dismiss="toast">

                            </button>

                        </div>

                    </div>

                </div>

                <script>

                setTimeout(function(){

                    const toast=document.querySelector('.toast');

                    if(toast){

                        toast.classList.remove('show');

                    }

                },3000);

                </script>

            <?php endif; ?>

                
                    <div class="card search-card mb-4">

                        <div class="card-body">

                            <form method="GET">

                                <div class="row g-3 align-items-center">

                                    <div class="col-lg-5">

                                        <div class="input-group modern-input">

                                            <span class="input-group-text">

                                                <i class="bi bi-search"></i>

                                            </span>

                                            <input
                                                type="text"
                                                name="search"
                                                class="form-control"
                                                placeholder="Cari nama invoice..."
                                                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

                                        </div>

                                    </div>

                                    <div class="col-lg-3">

                                        <select
                                            name="bulan"
                                            class="form-select modern-select">

                                            <option value="">
                                                Semua Bulan
                                            </option>

                                            <?php foreach ($bulanList as $bulan): ?>

                                                <option
                                                    value="<?= $bulan ?>"
                                                    <?= (($_GET['bulan'] ?? '') == $bulan) ? 'selected' : '' ?>>

                                                    <?= $bulan ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </div>

                                    <div class="col-lg-2">

                                        <button
                                            type="submit"
                                            class="btn btn-primary w-100 toolbar-btn">

                                            <i class="bi bi-search me-2"></i>

                                            Cari

                                        </button>

                                    </div>

                                    <div class="col-lg-2">

                                        <a
                                            href="dashboard.php"
                                            class="btn btn-secondary w-100 toolbar-btn">

                                            <i class="bi bi-arrow-clockwise me-2"></i>

                                            Reset

                                        </a>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

        </div>

    <?php if (isset($_GET['error'])): ?>

        <?php

        $pesan = "";

        if ($_GET['error'] == "duplicate") {
            $pesan = "File dengan nama tersebut sudah ada.";
        }

        if ($_GET['error'] == "format") {
            $pesan = "Hanya file PDF yang diperbolehkan.";
        }

        if ($_GET['error'] == "upload") {
            $pesan = "Upload gagal.";
        }

        ?>

        <div class="alert alert-danger alert-dismissible fade show mb-4">

            <?= $pesan; ?>

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php endif; ?>

        <div class="row g-3 mb-4">

            <div class="col-lg-4 col-md-6">

                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <h6 class="text-muted mb-2">

                            Total Invoice

                        </h6>

                        <h2 class="fw-bold">

                            <?= $totalInvoice ?>

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <h6 class="text-muted mb-2">

                            Total Storage

                        </h6>

                        <h2 class="fw-bold">

                            <?= $totalStorage ?>

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <h6 class="text-muted mb-2">

                            Upload Hari Ini

                        </h6>

                        <h2 class="fw-bold">

                            <?= $uploadToday ?>

                        </h2>

                    </div>

                </div>

            </div>

        </div> 

    <div class="card shadow-sm upload-card mb-4">

        <div class="card-header upload-header">

            <div>

                <h5 class="mb-1">

                    <i class="bi bi-cloud-arrow-up-fill text-primary me-2"></i>

                    Upload Invoice

                </h5>

                <small class="text-muted">

                    Upload file invoice dalam format PDF.

                </small>

            </div>

        </div>

        <div class="card-body">

            <form
                action="../../controllers/UploadController.php"
                method="POST"
                enctype="multipart/form-data"
                id="uploadForm">

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        File Invoice

                    </label>

                    <input
                        type="file"
                        id="fileInput"
                        name="invoice"
                        class="form-control"
                        accept=".pdf"
                        required>

                    <small class="text-muted">

                        Format file yang diperbolehkan hanya PDF.

                    </small>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Nama File

                    </label>

                    <input
                        type="text"
                        id="namaFile"
                        name="nama_file"
                        class="form-control"
                        readonly>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Progress Upload

                    </label>

                    <div class="progress modern-progress">

                        <div
                            id="progressBar"
                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                            style="width:0%">

                            0%

                        </div>

                    </div>

                </div>

                <div class="text-end">

                    <button
                        type="submit"
                        class="btn btn-primary px-4">

                        <i class="bi bi-upload me-2"></i>

                        Upload Invoice

                    </button>

                </div>

            </form>
        </div>

    </div>

    <div class="card table-card mb-4">

        <div class="card-header">

            <i class="bi bi-folder2-open me-2 text-primary"></i>

            Daftar Invoice

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Invoice</th>

                            <th>Ukuran</th>

                            <th>Tanggal Upload</th>

                            <th class="text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php if(count($invoiceList)>0): ?>

                            <?php foreach($invoiceList as $index=>$invoice): ?>

                            <tr>

                                <td>

                                    <?= $index+1 ?>

                                </td>

                                <td>

                                    <span class="file-badge">

                                        PDF

                                    </span>

                                    <?= htmlspecialchars($invoice['nama_file']) ?>

                                </td>

                                <td>

                                    <span class="size-badge">

                                        <?= round($invoice['ukuran']/1024,2) ?>

                                        KB

                                    </span>

                                </td>

                                <td>

                                    <?= date('d M Y H:i',strtotime($invoice['upload_at'])) ?>

                                </td>

                                <td class="text-center">

                                    <a
                                        href="../../controllers/PreviewController.php?id=<?= $invoice['id'] ?>"
                                        target="_blank"
                                        class="btn btn-info action-btn"
                                        title="Preview">

                                        <i class="bi bi-eye-fill"></i>

                                    </a>

                                    <a
                                        href="../../controllers/DownloadController.php?id=<?= $invoice['id'] ?>"
                                        class="btn btn-success action-btn"
                                        title="Download">

                                        <i class="bi bi-download"></i>

                                    </a>

                                    <a
                                        href="../../controllers/DeleteController.php?id=<?= $invoice['id'] ?>"
                                        class="btn btn-danger action-btn btn-delete"
                                        title="Delete">

                                        <i class="bi bi-trash-fill"></i>

                                    </a>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-5">

                                    <i class="bi bi-folder-x display-5 text-secondary"></i>

                                    <br><br>

                                    Belum ada invoice.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php
require_once '../layouts/footer.php';
?>