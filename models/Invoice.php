<?php

class Invoice
{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database;
    }

    public function getAll()
    {
        $query = "SELECT * FROM invoice ORDER BY upload_at DESC";
        $result = mysqli_query($this->conn, $query);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function search($keyword)
    {
        $query = "SELECT *
                FROM invoice
                WHERE nama_file LIKE ?
                ORDER BY upload_at DESC";

        $stmt = mysqli_prepare($this->conn, $query);

        $search = "%" . $keyword . "%";

        mysqli_stmt_bind_param($stmt, "s", $search);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function filterByMonth($bulan)
    {
        $query = "SELECT *
                FROM invoice
                WHERE bulan = ?
                ORDER BY upload_at DESC";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, "s", $bulan);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function countInvoice()
    {
        $query = "SELECT COUNT(*) AS total FROM invoice";
        $result = mysqli_query($this->conn, $query);

        return mysqli_fetch_assoc($result)['total'];
    }

    public function totalStorage()
    {
        $query = "SELECT SUM(ukuran) AS total FROM invoice";
        $result = mysqli_query($this->conn, $query);

        $data = mysqli_fetch_assoc($result);

        return $data['total'] ?? 0;
    }

    public function uploadToday()
    {
        $query = "SELECT COUNT(*) AS total
                  FROM invoice
                  WHERE DATE(upload_at) = CURDATE()";

        $result = mysqli_query($this->conn, $query);

        return mysqli_fetch_assoc($result)['total'];
    }

    public function formatSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return round($bytes / 1073741824, 2) . " GB";
        }

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . " MB";
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . " KB";
        }

        return $bytes . " B";
    }

    public function getById($id)
    {
        $query = "SELECT * FROM invoice WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    public function delete($id)
    {
        $query = "DELETE FROM invoice WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);
    }

    public function getInvoices($search = "", $bulan = "")
{
    $query = "SELECT *
              FROM invoice
              WHERE 1=1";

    $params = [];
    $types = "";

    if ($search != "") {

        $query .= " AND nama_file LIKE ?";

        $params[] = "%" . $search . "%";

        $types .= "s";
    }

    if ($bulan != "") {

        $query .= " AND bulan = ?";

        $params[] = $bulan;

        $types .= "s";
    }

    $query .= " ORDER BY upload_at DESC";

    $stmt = mysqli_prepare($this->conn, $query);

    if (!empty($params)) {

        mysqli_stmt_bind_param(
            $stmt,
            $types,
            ...$params
        );

    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

public function calculateStatistics($invoiceList)
{
    $totalInvoice = count($invoiceList);

    $totalStorage = 0;

    $uploadToday = 0;

    date_default_timezone_set("Asia/Jakarta");

    foreach ($invoiceList as $invoice) {

        $totalStorage += $invoice['ukuran'];

        if (
            date("Y-m-d", strtotime($invoice['upload_at']))
            ==
            date("Y-m-d")
        ) {

            $uploadToday++;

        }

    }

    return [

        "totalInvoice" => $totalInvoice,

        "totalStorage" => $this->formatSize($totalStorage),

        "uploadToday" => $uploadToday

    ];
}
}