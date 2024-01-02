<?php
session_start();
include('config/connection.php');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql_delete = "DELETE FROM users WHERE id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: list_karyawan.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
