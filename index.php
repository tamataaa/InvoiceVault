<?php
require_once 'config/session.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: views/dashboard/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>InvoiceVault Login</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="assets/css/login.css">

    </head>

    <body class="login-page">

        <div class="login-wrapper">

            <div class="login-card">

                <div class="text-center mb-4">

                    <div class="login-logo">

                        <i class="bi bi-cloud-check-fill"></i>

                    </div>

                    <h2 class="login-title">

                        InvoiceVault

                    </h2>

                    <p class="login-subtitle">

                        Cloud Invoice Manager

                    </p>

                </div>

                <?php if (isset($_GET['error'])): ?>

                    <div class="alert alert-danger">

                        Username atau Password salah.

                    </div>

                <?php endif; ?>

                <form
                    action="controllers/LoginController.php"
                    method="POST">

                    <div class="mb-3">

                        <label class="form-label">

                            Username

                        </label>

                        <div class="input-group login-input">

                            <span class="input-group-text">

                                <i class="bi bi-person-fill"></i>

                            </span>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                placeholder="Masukkan username"
                                required>

                        </div>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">

                            Password

                        </label>

                        <div class="input-group login-input">

                            <span class="input-group-text">

                                <i class="bi bi-lock-fill"></i>

                            </span>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required>

                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                id="togglePassword">

                                <i
                                    id="toggleIcon"
                                    class="bi bi-eye-slash-fill">
                                </i>

                            </button>

                        </div>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100 login-btn">

                        Login

                    </button>

                </form>

                <div class="text-center mt-4">

                    <small>

                        © 2026 InvoiceVault

                    </small>

                </div>

            </div>

        </div>

        <script src="assets/js/login.js"></script>
    
    </body>

</html>