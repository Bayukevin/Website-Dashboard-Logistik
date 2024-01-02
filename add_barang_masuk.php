<?php
session_start();
include('config/connection.php');
$username = $_SESSION['username'];

// Dapatkan informasi pengguna dari database berdasarkan username
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $namaUser = $row['username']; 
} else {
    $namaUser = "Nama Pengguna Tidak Ditemukan";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $jenis_barang = $_POST['jenis_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];

    // Query untuk memasukkan data barang masuk ke dalam tabel
    $sql = "INSERT INTO barang_masuk (nama_barang, jenis_barang, jumlah_barang) VALUES ('$nama_barang', '$jenis_barang', '$jumlah_barang')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: list_barang_masuk.php"); // Redirect ke halaman list_barang_masuk setelah data berhasil dimasukkan
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
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
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Title -->
        <title>Tambah Data Barang Masuk</title>

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
                        <a href="app-profile.html">
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
                        <ul class="accordion-menu">
                            <li>
                                <a href="<?php echo ($_SESSION['role'] == 'admin') ? 'admin_dashboard.php' : 'karyawan_dashboard.php'; ?>">
                                    <i class="menu-icon icon-home4"></i><span>Dashboard</span>
                                </a>
                            </li>
                            <li class="active-page">
                                <a href="#">
                                    <i class="menu-icon icon-apps"></i><span>Data Barang Masuk</span>
                                </a>
                            </li>
                            <li>
                                <a href="list_barang_keluar.php">
                                    <i class="menu-icon icon-layers"></i><span>Data Barang Keluar</span>
                                </a>
                            </li>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <li>
                                <a href="list_karyawan.php">
                                    <i class="menu-icon icon-user"></i><span>Data Karyawan</span>
                                </a>
                            </li>
                            <?php } ?>
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
                                    <a class="logo-box" href="index.html"><span>concept</span></a>
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
                                    <li class="breadcrumb-item"><a href="#">Styles</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tables</li>
                                </ol>
                            </nav>
                            <h1 class="page-title">Tambah Data Barang Masuk</h1>
                        </div>
                        <h5 class="page-desc">Input data barang sebagai stok barang</h5>
                        <div class="divider"></div>
                        
                        <div class="row">
                            <div class="col-xl">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Data Barang Masuk</h4>
                                        <div class="table-responsive">
                                            <form action="add_barang_masuk.php" method="POST">
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
                                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Jenis Barang</label>
                                                    <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" placeholder="Masukkan Jenis Barang">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1" class="form-label">Jumlah Barang</label>
                                                    <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" placeholder="Masukkan Jumlah Barang">
                                                </div>
                                                <button class="btn btn-primary" type="submit">Tambah Barang</button>
                                                <a class="btn btn-danger" href="list_barang_masuk.php">Batal</a>
                                            </form>
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
        <script src="assets/js/concept.min.js"></script>
    </body>
</html>