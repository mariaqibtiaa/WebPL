<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['act'])) {
        $act = $_REQUEST['act'];
        switch ($act) {
            case 'add':
                include "tambah_ska.php";
                break;
            case 'edit':
                include "edit_ska.php";
                break;
            case 'del':
                include "hapus_ska.php";
                break;
        }
    } else {

        echo '<!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <div class="z-depth-1">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper #b71c1c red darken-4">
                                    <div class="col m7">
                                        <ul class="left">
                                            <li class="waves-effect waves-light hide-on-small-only"><a href="?page=sk" class="judul"><i class="material-icons">class</i> Surat Keterangan Aktif</a></li>
                                            <li class="waves-effect waves-light"><a href="?page=sk&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a></li>';
        echo '
                                        </ul>
                                    </div>
                                    <div class="col m5 hide-on-med-and-down">
                                        <form method="post" action="?page=sk">
                                            <div class="input-field round-in-box">
                                                <input id="search" type="search" name="cari" required>
                                                <label for="search"><i class="material-icons">search</i></label>
                                                <input type="submit" name="submit" class="hidden">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->';

        if (isset($_SESSION['succAdd'])) {
            $succAdd = $_SESSION['succAdd'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card green lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succAdd . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['succAdd']);
        }
        if (isset($_SESSION['succEdit'])) {
            $succEdit = $_SESSION['succEdit'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card green lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succEdit . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['succEdit']);
        }
        if (isset($_SESSION['succDel'])) {
            $succDel = $_SESSION['succDel'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card green lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succDel . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['succDel']);
        }
        if (isset($_SESSION['succUpload'])) {
            $succUpload = $_SESSION['succUpload'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card green lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title green-text"><i class="material-icons md-36">done</i> ' . $succUpload . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['succUpload']);
        }

        echo '
                <!-- Row form Start -->
                <div class="row jarak-form">';

        if (isset($_REQUEST['submit'])) {
            $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
            echo '
                    <div class="col s12" style="margin-top: -18px;">
                        <div class="card blue lighten-5">
                            <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=sk"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="4%">No</th>
                                    <th width="20%">Nomor Surat<br/>Tanggal Masuk</th>
                                    <th width="19%">Nama</th>
                                    <th width="19%">NIP</th>
                                    <th width="14%">Departemen</th>
                                    <th width="24%">Tindakan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>';

            //script untuk menampilkan data
            $query = mysqli_query($config, "SELECT * FROM tbl_ska WHERE nama_ska LIKE '%$cari%' ORDER BY no_ska DESC");
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_array($query)) {
                    $no = 1;
                    $y = substr($row['tgl_masuk'], 0, 4);
                    $m = substr($row['tgl_masuk'], 5, 2);
                    $d = substr($row['tgl_masuk'], 8, 2);

                    if ($m == "01") {
                        $nm = "Januari";
                    } elseif ($m == "02") {
                        $nm = "Februari";
                    } elseif ($m == "03") {
                        $nm = "Maret";
                    } elseif ($m == "04") {
                        $nm = "April";
                    } elseif ($m == "05") {
                        $nm = "Mei";
                    } elseif ($m == "06") {
                        $nm = "Juni";
                    } elseif ($m == "07") {
                        $nm = "Juli";
                    } elseif ($m == "08") {
                        $nm = "Agustus";
                    } elseif ($m == "09") {
                        $nm = "September";
                    } elseif ($m == "10") {
                        $nm = "Oktober";
                    } elseif ($m == "11") {
                        $nm = "November";
                    } elseif ($m == "12") {
                        $nm = "Desember";
                    }

                    echo '              <td>' . $no++ . '</td>
                                        <td>' . $row['no_ska'] . '<br/><hr/>' . $d . " " . $nm . " " . $y . '</td>
                                        <td>' . $row['nama_ska'] . '</td>
                                        <td>' . $row['nip_ska'] . '</td>
                                        <td>' . $row['dept_ska'] . '</td>
                                        <td>
                                            <a class="btn small blue waves-effect waves-light" href="?page=sk&act=edit&id_ska=' . $row['id_ska'] . '">
                                                <i class="material-icons">edit</i> EDIT</a>
                                            <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_ska=' . $row['id_ska'] . '" target="_blank">
                                                <i class="material-icons">print</i> PRINT</a>
                                            <a class="btn small deep-orange waves-effect waves-light" href="?page=sk&act=del&id_ska=' . $row['id_ska'] . '">
                                                <i class="material-icons">delete</i> DEL</a>
                                        </td>
                                    </tr>
                                </tbody>';
                }
            } else {
                echo '<tr><td colspan="5"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
            }
            echo '</table><br/><br/>
                            </div>
                        </div>
                        <!-- Row form END -->';
        } else {

            echo '<div class="col m12" id="colres">
                                <table class="bordered" id="tbl">
                                    <thead class="blue lighten-4" id="head">
                                        <tr>
                                            <th width="4%">No</th>
                                            <th width="20%">Nomor Surat<br/>Tanggal Masuk</th>
                                            <th width="19%">Nama</th>
                                            <th width="19%">NIP</th>
                                            <th width="14%">Departemen</th>
                                            <th width="24%">Tindakan</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>';

            //script untuk menampilkan data
            $query = mysqli_query($config, "SELECT * FROM tbl_ska ORDER BY no_ska DESC");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {
                    $y = substr($row['tgl_masuk'], 0, 4);
                    $m = substr($row['tgl_masuk'], 5, 2);
                    $d = substr($row['tgl_masuk'], 8, 2);

                    if ($m == "01") {
                        $nm = "Januari";
                    } elseif ($m == "02") {
                        $nm = "Februari";
                    } elseif ($m == "03") {
                        $nm = "Maret";
                    } elseif ($m == "04") {
                        $nm = "April";
                    } elseif ($m == "05") {
                        $nm = "Mei";
                    } elseif ($m == "06") {
                        $nm = "Juni";
                    } elseif ($m == "07") {
                        $nm = "Juli";
                    } elseif ($m == "08") {
                        $nm = "Agustus";
                    } elseif ($m == "09") {
                        $nm = "September";
                    } elseif ($m == "10") {
                        $nm = "Oktober";
                    } elseif ($m == "11") {
                        $nm = "November";
                    } elseif ($m == "12") {
                        $nm = "Desember";
                    }

                    echo '  <td>' . $no++ . '</td>
                            <td>' . $row['no_ska'] . '<br/><hr/>' . $d . " " . $nm . " " . $y . '</td>
                            <td>' . $row['nama_ska'] . '</td>
                            <td>' . $row['nip_ska'] . '</td>
                            <td>' . $row['dept_ska'] . '</td>
                            <td>
                                <a class="btn small blue waves-effect waves-light" href="?page=sk&act=edit&id_ska=' . $row['id_ska'] . '">
                                    <i class="material-icons">edit</i> EDIT</a>
                                <a class="btn small yellow darken-3 waves-effect waves-light" href="?page=ctk&id_ska=' . $row['id_ska'] . '" target="_blank">
                                    <i class="material-icons">print</i> PRINT</a>
                                <a class="btn small deep-orange waves-effect waves-light" href="?page=sk&act=del&id_ska=' . $row['id_ska'] . '">
                                    <i class="material-icons">delete</i> DEL</a>
                            </td>
                        </tr>
                    </tbody>';
                }
            } else {
                echo '<tr><td colspan="5"><center><p class="add">Tidak ada data yang ditemukan. <u><a href="?page=sk&act=add">Tambah data baru</a></u></p></center></td></tr>';
            }
            echo '</table><br/><br/>
                            </div>
                        </div>
                        <!-- Row form END -->';
        }
    }
}
