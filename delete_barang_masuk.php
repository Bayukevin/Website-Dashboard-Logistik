<?php
session_start();
include('config/connection.php');

if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Query untuk menghapus data barang masuk berdasarkan ID
    $sql = "DELETE FROM barang_masuk WHERE id_barang = $id_barang";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: list_barang_masuk.php"); // Redirect ke halaman list_barang_masuk setelah data berhasil dihapus
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID barang tidak diberikan.";
    exit;
}
?>
