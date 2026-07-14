<?php

class Admin
{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database;
    }

    public function login($username)
    {
        $query = "SELECT * FROM admin WHERE username = ?";

        $stmt = mysqli_prepare($this->conn, $query);

        mysqli_stmt_bind_param($stmt, "s", $username);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }
}