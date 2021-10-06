<?php
//cek session
if (!empty($_SESSION['admin'])) {
?>

    <!-- RESPONSIVE MOBILE -->
    <nav class="#b71c1c red darken-4">
        <div class="nav-wrapper">
            <a href="./" class="brand-logo center hide-on-large-only">PT. DEE</a>
            <ul id="slide-out" class="side-nav" data-simplebar-direction="vertical">
                <li class="no-padding">
                    <div class="logo-side center">
                        <?php
                        $query = mysqli_query($config, "SELECT * FROM tbl_instansi");
                        while ($data = mysqli_fetch_array($query)) {
                            if (!empty($data['nama'])) {
                                echo '<h5 class="nama-side">' . $data['nama'] . '</h5>';
                            } else {
                                echo '<h5 class="nama-side">PT. Dagsap Endura Eatore</h5>';
                            }
                            if (!empty($data['alamat'])) {
                                echo '<p class="description-side">' . $data['alamat'] . '</p>';
                            } else {
                                echo '<p class="description-side">Jalan Raya Kediri Gg. Kwagean No. 04 Loceret Telp/Fax. (0358) 329806 Nganjuk 64471</p>';
                            }
                        }
                        ?>
                    </div>
                </li>
                <li class="no-padding">
                    <ul class=" collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header"><i class="material-icons">account_circle</i><?php echo $_SESSION['nama']; ?></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="?page=sett">Instansi</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><a href="./"><i class="material-icons middle">dashboard</i> Beranda</a></li>
                <li><a href="?page=sk"><i class="material-icons middle">dashboard</i> Surat Keterangan Aktif</a></li>
                <li><a href="?page=tsm"><i class="material-icons middle">dashboard</i> Surat Masuk</a></li>
                <li><a href="?page=tsk"><i class="material-icons middle">dashboard</i> Surat Keluar</a></li>
            </ul>
            <!-- AKHIR DARI RESPONSIVE MOBILE-->

            <!-- RESPONSIVE DESKTOP -->
            <ul class="center hide-on-med-and-down" id="nv">
                <li><a class="active" href="./" class="hide-on-med-and-down">PT. Dagsap Endura Eatore</a></li>
                <li>
                    <div class="grs">
                        </>
                </li>
                <li><a href="./">&nbsp; Beranda</a></li>
                <li><a href="?page=sk">Surat Keterangan Aktif</a></li>
                <li><a href="?page=tsm">Surat Masuk</a></li>
                <li><a href="?page=tsk">Surat Keluar</a></li>
                <li class="right" style="margin-right: 10px;"><a class="dropdown-button" href="#!" data-activates="logout"><i class="material-icons">account_circle</i> <?php echo $_SESSION['nama']; ?><i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='logout' class='dropdown-content #b71c1c red darken-4'>
                    <li><a href="?page=sett">Instansi</a></li>
                    <li><a href="logout.php"><i class="material-icons">settings_power</i> Logout</a></li>
                    <!-- AKHIR DARI RESPONSIVE DESKTOP -->
                </ul>
            </ul>
            <a href="#" data-activates="slide-out" class="button-collapse" id="menu"><i class="material-icons">menu</i></a>
        </div>
    </nav>

<?php
} else {
    header("Location: ../");
    die();
}
?>