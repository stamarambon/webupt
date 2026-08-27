<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img style="height: 50px" src="img/BMKG.svg" alt="Logo BMKG" />
        </div>
        <div class="sidebar-brand-text pt-3 text-left ml-3">
            <p>Database<br />Pengamatan</p>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading">Menu</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-globe"></i>
            <span>Geofisika</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data:</h6>
                <a class="collapse-item" href="opsiGempa.php"><i class="fa fa-rss-square" aria-hidden="true"></i>
                    Gempabumi</a>
                <a class="collapse-item" href="petir.php"><i class="fa fa-bolt" aria-hidden="true"></i> Petir</a>
                <a class="collapse-item" href="tandaWaktu.php"><i class="fa fa-hourglass-start" aria-hidden="true"></i>
                    Tanda
                    Waktu</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="hujan.php">
            <i class="fas fa-fw fa-cloud"></i>
            <span>Hari Hujan</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
            aria-controls="collapseThree">
            <i class="fas fa-fw fa-image"></i>
            <span>Produk</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Infografis:</h6>
                <a class="collapse-item" href="grafisGempa.php"><i class="fa fa-rss-square" aria-hidden="true"></i>
                    Gempabumi</a>
                <a class="collapse-item" href="grafisPetir.php"><i class="fa fa-bolt" aria-hidden="true"></i> Petir</a>
                <h6 class="collapse-header">Videografis:</h6>
                <a class="collapse-item" href="opsiVideo.php"><i class="fa fa-film" aria-hidden="true"></i>
                    Videografis</a>
                <h6 class="collapse-header">Pers:</h6>
                <a class="collapse-item" href="berita.php"><i class="fa fa-newspaper" aria-hidden="true"></i>
                    Berita</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <div class="sidebar-heading">Arsip</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="permintaanData.php">
            <i class="fas fa-fw fa-folder"></i>
            <span>Permintaan Data</span><span class="mx-3 badge badge-primary">
                <?=$jlh_perm?>
            </span></a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">Lainnya</div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="pengaturan.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <form class="form-inline">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
            </form>

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
                                    placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
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
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                            <?php echo $_SESSION['username']; ?>
                        </span>
                        <img class="img-profile rounded-circle" src="img/BMKG.png" />
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- End of Topbar -->
