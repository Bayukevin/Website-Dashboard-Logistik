<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: login.php");
    exit;
}

include('config/connection.php');

$username = $_SESSION['username'];

// Mendapatkan nama pengguna dari database
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $namaUser = $row['username']; // Ganti dengan kolom yang sesuai untuk menampilkan username
} else {
    $namaUser = "Nama Pengguna Tidak Ditemukan";
}

// Ambil data barang masuk dari tabel
$sql = "SELECT * FROM barang_masuk";
$result = $conn->query($sql);

// Ambil jumlah barang masuk dari tabel barang_masuk
$sql_barang_masuk = "SELECT COUNT(*) AS jumlah_barang_masuk FROM barang_masuk";
$result_barang_masuk = $conn->query($sql_barang_masuk);
$row_barang_masuk = $result_barang_masuk->fetch_assoc();
$jumlah_barang_masuk = $row_barang_masuk['jumlah_barang_masuk'];

// Ambil jumlah barang keluar dari tabel barang_keluar
$sql_barang_keluar = "SELECT COUNT(*) AS jumlah_barang_keluar FROM barang_keluar";
$result_barang_keluar = $conn->query($sql_barang_keluar);
$row_barang_keluar = $result_barang_keluar->fetch_assoc();
$jumlah_barang_keluar = $row_barang_keluar['jumlah_barang_keluar'];

// Ambil jumlah karyawan dari tabel users dengan role karyawan
$sql_jumlah_karyawan = "SELECT COUNT(*) AS jumlah_karyawan FROM users WHERE role = 'karyawan'";
$result_jumlah_karyawan = $conn->query($sql_jumlah_karyawan);
$row_jumlah_karyawan = $result_jumlah_karyawan->fetch_assoc();
$jumlah_karyawan = $row_jumlah_karyawan['jumlah_karyawan'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        
        <!-- Title -->
        <title>Dashboard Admin</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="assets/plugins/icomoon/style.css" rel="stylesheet">
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet"> 

      
        <!-- Theme Styles -->
        <link href="assets/css/concept.min.css" rel="stylesheet">
        <link href="assets/css/admin2.css" rel="stylesheet">
        <link href="assets/css/custom.css" rel="stylesheet">
    </head>
    <body>
        
        <!-- Page Container -->
        <div class="page-container">
            <div class="settings-sidebar">
                <div class="settings-sidebar-content">
                    <div class="settings-sidebar-header">
                        <span>Settings</span>
                        <a href="javascript: void(0);" class="settings-menu-close"><i class="icon-close"></i></a>
                    </div>
                    <div class="right-sidebar-settings">
                        <span class="settings-title">General Settings</span>
                        <ul class="sidebar-setting-list list-unstyled">
                            <li>
                                <span class="settings-option">Notifications</span><input type="checkbox" class="js-switch" checked />
                            </li>
                            <li>
                                <span class="settings-option">Activity log</span><input type="checkbox" class="js-switch" checked />
                            </li>
                            <li>
                                <span class="settings-option">Automatic updates</span><input type="checkbox" class="js-switch" />
                            </li>
                            <li>
                                <span class="settings-option">Allow backups</span><input type="checkbox" class="js-switch" />
                            </li>
                        </ul>
                        <span class="settings-title">Account Settings</span>
                        <ul class="sidebar-setting-list list-unstyled">
                            <li>
                                <span class="settings-option">Chat</span><input type="checkbox" class="js-switch" checked />
                            </li>
                            <li>
                                <span class="settings-option">Incognito mode</span><input type="checkbox" class="js-switch" />
                            </li>
                            <li>
                                <span class="settings-option">Public profile</span><input type="checkbox" class="js-switch" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="settings-overlay"></div>
            <!-- Page Content -->
            <div class="page-content">
                <div class="secondary-sidebar">
                    <div class="secondary-sidebar-bar">
                        <a href="#" class="logo-box">Logistic</a>
                    </div>
                    <div class="secondary-sidebar-profile">
                        <a href="#">
                            <img src="assets/images/avatars/avatar2.png">
                            <p><?php echo $namaUser; ?></p>
                            <i class="fas fa-angle-right"></i>
                        </a>
                        <ul class="secondary-sidebar-profile-menu list-unstyled d-flex">
                            <li class="flex-fill"><a href="#"><i class="fas fa-rocket"></i></a></li>
                            <li class="flex-fill"><a href="#"><i class="fas fa-globe-africa"></i></a></li>
                            <li class="flex-fill"><a href="#"><i class="fas fa-inbox"></i></a></li>
                            <li class="flex-fill"><a href="#"><i class="far fa-comments"></i></a></li>
                        </ul>
                    </div>
                    <div class="secondary-sidebar-menu">
                        <button class="btn btn-block btn-primary btn-settings-toggle settings-menu-link"><span>Settings</span><i class="fas fa-cogs"></i></button>
                        <ul class="accordion-menu">
                            <li class="active-page">
                                <a href="#">
                                    <i class="menu-icon icon-home4"></i><span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="list_barang_masuk.php">
                                    <i class="menu-icon icon-apps"></i><span>Data Barang Masuk</span>
                                </a>
                            </li>
                            <li>
                                <a href="list_barang_keluar.php">
                                    <i class="menu-icon icon-layers"></i><span>Data Barang Keluar</span>
                                </a>
                            </li>
                            <li class="menu-divider"></li>
                            <li>
                                <a href="laporan.php">
                                    <i class="menu-icon icon-book"></i><span>Laporan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Page Header -->
                <div class="page-header">
                    <div class="search-form">
                        <form action="#" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control search-input" placeholder="Type something...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" id="close-search" type="button"><i class="icon-close"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <nav class="navbar navbar-default navbar-expand-md">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <div class="logo-sm">
                                    <a href="javascript:void(0)" id="sidebar-toggle-button"><i class="fas fa-bars"></i></a>
                                    <a class="logo-box" href="index.html"><span>Logistic</span></a>
                                </div>
                                <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <i class="fas fa-angle-down"></i>
                                </button>
                            </div>
                        
                            <!-- Collect the nav links, forms, and other content for toggling -->
                        
                            <div class="collapse navbar-collapse justify-content-between" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav mr-auto">
                                    <li class="collapsed-sidebar-toggle-inv"><a href="javascript:void(0)" id="collapsed-sidebar-toggle-button"><i class="fas fa-bars"></i></a></li>
                                    <li><a href="javascript:void(0)" id="toggle-fullscreen"><i class="fas fa-expand"></i></a></li>
                                    <li><a href="javascript:void(0)" id="search-button"><i class="fas fa-search"></i></a></li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                                <ul class="nav navbar-nav">
                                    <li class="nav-item d-md-block"><a href="javascript:void(0)" class="right-sidebar-toggle" data-sidebar-id="main-right-sidebar"><i class="fas fa-envelope"></i></a></li>
                                    <li class="dropdown nav-item d-md-block">
                                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bell"></i></a>                                      
                                    </li>
                                    <li class="dropdown nav-item d-md-block">
                                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="assets/images/avatars/avatar1.png" alt="" class="rounded-circle"></a>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <li><a href="logout.php">Log Out</a></li>
                                        </ul>
                                    </li>
                                </ul>
                        </div><!-- /.container-fluid -->
                    </nav>
                </div><!-- /Page Header -->
                <!-- Page Inner -->
                <div class="page-inner no-page-title">
                    <div id="main-wrapper">
                        <div class="content-header">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-style-1">
                                    <li class="breadcrumb-item">Home</li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                            <h1 class="page-title">Dashboard</h1>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <div class="ds-stat">
                                                    <span class="ds-stat-name">Jumlah Barang Masuk</span>
                                                    <h3 class="ds-stat-number"><?php echo $jumlah_barang_masuk; ?> Unit</h3>
                                                    <div class="progress" style="height: 3px;">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="ds-stat">
                                                    <span class="ds-stat-name">Jumlah Barang Keluar</span>
                                                    <h3 class="ds-stat-number"><?php echo $jumlah_barang_keluar; ?> Unit</h3>
                                                    <div class="progress" style="height: 3px;">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="ds-stat">
                                                    <span class="ds-stat-name">Jumlah Karyawan</span>
                                                    <h3 class="ds-stat-number"><?php echo $jumlah_karyawan; ?> Orang</h3>
                                                    <div class="progress" style="height: 3px;">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="ds-stat">
                                                    <span class="ds-stat-name">Jam Realtime</span>
                                                    <h3 id="jam" class="ds-stat-number"></h3>
                                                    <div class="progress" style="height: 3px;">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Data Keluar Masuk Barang</h5>
                                        <div id="apex1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Donut Diagram</h5>
                                        <div class="popular-products">
                                            <canvas id="chartjs1">Donut Diagram Data Logistic</canvas>
                                            <div class="popular-product-list">
                                                <ul class="list-unstyled">
                                                    <li id="popular-product1">
                                                        <span>Data Barang Masuk</span>
                                                        <span class="product-color">59%</span>
                                                    </li>
                                                    <li id="popular-product2">
                                                        <span>Data Barang Keluar</span>
                                                        <span class="product-color">15%</span>
                                                    </li>
                                                    <li id="popular-product3">
                                                        <span>Data Stok Barang</span>
                                                        <span class="product-color">26%</span>
                                                    </li>
                                                </ul>
                                                <div class="alert alert-info" role="alert">
                                                    Based on last week's earnings.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="info-card">
                                            <h4 class="info-title">Jumlah Kryawan<span class="info-stats"><?php echo $jumlah_karyawan; ?> Orang</span></h4>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="info-card">
                                            <h4 class="info-title">Data Barang Masuk<span class="info-stats"><?php echo $jumlah_barang_masuk; ?> Unit</span></h4>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="info-card">
                                            <h4 class="info-title">Data Barang Keluar<span class="info-stats"><?php echo $jumlah_barang_keluar; ?> Unit</span></h4>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Data Barang</h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nama Barang</th>
                                                        <th scope="col">Jenis Barang</th>
                                                        <th scope="col">Jumlah Barang</th>
                                                        <th scope="col">Tanggal Masuk</th>
                                                        <th scope="col">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>".$row['nama_barang']."</td>";
                                                                echo "<td>".$row['jenis_barang']."</td>";
                                                                echo "<td>".$row['jumlah_barang']." Unit</td>";
                                                                echo "<td>".$row['tanggal_masuk']."</td>";
                                                                echo "<td><a href='edit_barang_masuk.php?id=".$row['id_barang']."'><button class='btn btn-warning'>Edit</button></a> <a href='delete_barang_masuk.php?id=".$row['id_barang']."'><button class='btn btn-danger'>Hapus</button></a></td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='6'>Tidak ada data barang masuk.</td></tr>";
                                                        }
                                                        ?>
                                                </tbody>
                                            </table>
                                        </div>      
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div><!-- Main Wrapper -->

                    
                <div class="page-footer">
                    <p>2024 &copy; Logistic</p>
                </div>
                </div><!-- /Page Inner -->
            </div><!-- /Page Content -->
        </div><!-- /Page Container -->
        
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-3.1.0.min.js"></script>
        <script src="assets/plugins/bootstrap/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>
        <script src="assets/plugins/apexcharts/dist/apexcharts.min.js"></script>
        <script src="assets/plugins/chartjs/chart.min.js"></script>
        <script src="assets/js/concept.min.js"></script>
        <script src="assets/js/pages/dashboard_admin2.js"></script>
        <script>
function updateTime() {
    // Buat objek Date
    let now = new Date();

    // Ambil informasi jam, menit, dan detik
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();

    // Tambahkan nol di depan jika angka kurang dari 10 (untuk format 2 digit)
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    // Tampilkan waktu dalam elemen dengan id 'jam'
    document.getElementById('jam').innerText = hours + ':' + minutes + ':' + seconds;
}

// Pembaruan waktu setiap detik
setInterval(updateTime, 1000);

// Pertama kali, panggil fungsi updateTime agar waktu terupdate segera saat halaman dimuat
updateTime();
</script>
    </body>
</html>