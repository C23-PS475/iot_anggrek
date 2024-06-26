<?php
// Mulai session
session_start();

// Periksa apakah session 'username' sudah diset
if (!isset($_SESSION['username'])) {
    // Jika tidak, redirect pengguna ke halaman login
    header("Location: login.php");
    exit(); // Pastikan keluar dari skrip
}

// Koneksi ke database
$konek = mysqli_connect("localhost", "root", "", "iot_anggrek");

// Inisialisasi variabel filter
$dari_tgl = '';
$sampai_tgl = '';

if (isset($_POST['filter'])) {
    $dari_tgl = $_POST['dari_tgl'];
    $sampai_tgl = $_POST['sampai_tgl'];

    $query = "SELECT ID, kelembapan, suhu, relay_duration, tanggal 
              FROM sensor 
              WHERE tanggal BETWEEN '$dari_tgl' AND '$sampai_tgl'";
    $data_report = mysqli_query($konek, $query);
} else {
    $query = "SELECT ID, kelembapan, suhu, relay_duration, tanggal 
              FROM sensor";
    $data_report = mysqli_query($konek, $query);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Penyiraman Otomatis</title>

    <!-- Custom fonts for this template -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

</head>

<body id="page-top">

     <!-- Page Wrapper -->
     <div id="wrapper">

         <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: 	#008000;" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Monitoring Anggrek<sup>JTD</sup></div>
            </a>

             <!-- Divider -->
             <hr class="sidebar-divider my-0">

                 <!-- Nav Item - Dashboard -->
                 <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-info-circle"></i>
                        <span>Tentang</span></a>
                </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="tables.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Report</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            </ul>
            <!-- End of Sidebar -->

       <!-- Content Wrapper -->
       <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                        placeholder="Search for..." aria-label="Search"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['username']; ?>
                                    </span>
                                    <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="login.php" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Keluar
                                    </a>
                                </div>
                            </li>

                            </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <div class="row">

                     <!-- DataTales Example -->
                     <div class="col-xl-6 col-lg-5">
                     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold" style="color: #008000;">Profil DD ORCHID NURSERY</h5>
                        </div>
                        <div class="card-body">

                        <h4 style="color:black; text-align: justify;">
                        DD Orchid Nursery merupakan perusahaan yang bergerak dibidang budidaya pertanian khususnya Anggrek dan agrowisata. 
                        Berdirinya DD Orchid Nursery ini didorong oleh semakin berkurangnya lahan pertanian di Kelurahan Dadaprejo. 
                        DD Orchid berdiri pada tahun 2007 yang telah berkontribusi terhadap suplai Anggrek.
                        </h4>
                            
                        </div>
                    </div>
                </div>

                <!-- DataTales Example -->
                <div class="col-xl-6 col-lg-5">
                     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold" style="color: #008000;">Logo DD ORCHID NURSERY</h5>
                        </div>
                        <div class="card-body text-center">
                        <img src="img/LOGO BLACK DD ORCHID.png" class="img-fluid" alt="Logo DD Orchid Nursery" style="width: 37%; max-width: 60%;">
                        </div>
                    </div>
                </div>

                </div>

                <div class="row">

                     <!-- DataTales Example -->
                     <div class="col-xl-6 col-lg-5">
                     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold" style="color: #008000;">Visi dan Misi Perusahaan </h5>
                        </div>
                        <div class="card-body">
                        <h3 style="color:black">Visi Perusahaan</h3>
                        <p style="color:black; text-align:justify">Menjadikan DD Orchid Nursery sebagai perusahaan dengan produk berkualitas 
                            yang mengedepankan konservasi, inovasi dan edukasi berbasis pemberdayaan Masyarakat</p>
                        <h3 style="color:black">Misi Perusahaan</h3>
                        <p style="color:black">1. Menjadikan DD Orchid Nursery sebagai produsen anggrek yang berkualitas. </p>
                        <p style="color:black">2. Menciptakan sumberdaya manusia yang jujur, kreatif, inovatif, dan memiliki jiwa entrepreneurship  </p>
                        <p style="color:black">3. Mengeksplorasi potensi pariwisata dan ekonomi kreatif berbasis pemberdayaan masyarakat  </p>
                        <p style="color:black">4. Melestarikan anggrek spesies di Indonesia </p>
                        
                        


                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-5">
                     <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold" style="color: #008000;">Struktur Organisasi</h5>
                        </div>
                        <div class="card-body text-center">
                        <img src="img/SO.png" class="img-fluid" alt="Struktur Organisasi" style="width: 100%; max-width: 300%;">
                        </div>
                    </div>                        
                        </div>
                    </div>
                </div>




                </div>



                


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Dipersembahkan &copy; Politeknik Negeri Malang</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

     <!-- Logout Modal-->
     <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda akan keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih Keluar untuk meninggalkan halaman</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                    <a class="btn btn-primary" style="background-color:#008000;" href="login.php">Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });
    </script>

</body>

</html>
