<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../models/Admin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $adminModel = new Admin($conn);

    $admin = $adminModel->login($username);

    if ($admin) {

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['nama'];

            header("Location: ../views/dashboard/dashboard.php");
            exit;

        } else {

            header("Location: ../index.php?error=password");
            exit;

        }

    } else {

        header("Location: ../index.php?error=username");
        exit;

    }

}