<?php
session_start();
include('config/connection.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_barang_keluar = $_GET['id'];
    $sql_delete = "DELETE FROM barang_keluar WHERE id_barang_keluar = $id_barang_keluar";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: list_barang_keluar.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
