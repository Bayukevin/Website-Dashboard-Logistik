<?php
session_start();
include('config/connection.php');

// Ambil data barang masuk dari tabel barang_masuk
$sql_barang_masuk = "SELECT * FROM barang_masuk";
$result_barang_masuk = $conn->query($sql_barang_masuk);

// Ambil data barang keluar dari tabel barang_keluar
$sql = "SELECT barang_keluar.id_barang_keluar, barang_masuk.nama_barang, barang_masuk.jenis_barang, barang_keluar.jumlah_barang, barang_keluar.tanggal_keluar
        FROM barang_keluar
        INNER JOIN barang_masuk ON barang_keluar.id_barang_masuk = barang_masuk.id_barang
        ORDER BY barang_keluar.tanggal_keluar DESC";

$result = $conn->query($sql);

require_once('vendor\tecnickcom\tcpdf\tcpdf.php');

// Inisialisasi objek TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Atur informasi dokumen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nama Anda');
$pdf->SetTitle('Laporan Barang Masuk dan Keluar');
$pdf->SetSubject('Laporan Barang');
$pdf->SetKeywords('Laporan, Barang, PDF');

// Atur ukuran font
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('helvetica', '', 10);

// Tambahkan halaman
$pdf->AddPage('L', 'A4');

// Tambahkan konten ke PDF
$content = '<h1 style="text-align:center;">Laporan Barang Masuk dan Barang Keluar</h1>';

$content .= '<h3>Barang Masuk</h3>';
$content .= '<table border="1" style="text-align:center;">
                <thead>
                    <tr>
                        <th><b>Nama Barang</b></th>
                        <th><b>Jenis Barang</b></th>
                        <th><b>Jumlah Barang Masuk</b></th>
                        <th><b>Tanggal Barang Masuk</b></th>
                    </tr>
                </thead>
                <tbody>';

if ($result_barang_masuk->num_rows > 0) {
    while ($row = $result_barang_masuk->fetch_assoc()) {
        $content .= '<tr>';
        $content .= '<td>' . $row['nama_barang'] . '</td>';
        $content .= '<td>' . $row['jenis_barang'] . '</td>';
        $content .= '<td>' . $row['jumlah_barang'] . '</td>';
        $content .= '<td>' . $row['tanggal_masuk'] . '</td>';
        $content .= '</tr>';
    }
} else {
    $content .= '<tr><td colspan="4">Tidak ada data barang masuk.</td></tr>';
}

$content .= '</tbody></table>';

$content .= '<h3>Barang Keluar</h3>';
$content .= '<table border="1" style="text-align:center;">
                <thead>
                    <tr>
                        <th><b>Nama Barang</b></th>
                        <th><b>Jenis Barang</b></th>
                        <th><b>Jumlah Barang Keluar</b></th>
                        <th><b>Tanggal Barang Keluar</b></th>
                    </tr>
                </thead>
                <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $content .= '<tr>';
        $content .= '<td>' . $row['nama_barang'] . '</td>';
        $content .= '<td>' . $row['jenis_barang'] . '</td>';
        $content .= '<td>' . $row['jumlah_barang'] . '</td>';
        $content .= '<td>' . $row['tanggal_keluar'] . '</td>';
        $content .= '</tr>';
    }
} else {
    $content .= '<tr><td colspan="4">Tidak ada data barang keluar.</td></tr>';
}

$content .= '</tbody></table>';
$content .= '<p color="#FFF">.</p>';
$content .= '<p color="#FFF">.</p>';
$content .= '<p color="#FFF">.</p>';
$content .= '<p color="#FFF">.</p>';
$content .= '<p color="#FFF">.</p>';
$content .= '<p color="#FFF">.</p>';
$content .= '<div style="text-align:right;">';
$content .= '<p>Yang Bertanggung Jawab</p>';
$content .= '<p color="#FFF">.</p>';
$content .= '<p color="#FFF">.</p>';
$content .= '<p>(........................................)</p>';
$content .= '</div>';

$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output('laporan_barang.pdf', 'I'); // Menampilkan PDF di browser

?>
