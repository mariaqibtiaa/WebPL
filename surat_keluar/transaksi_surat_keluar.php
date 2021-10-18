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
                include "tambah_surat_keluar.php";
                break;
            case 'edit':
                include "edit_surat_keluar.php";
                break;
            case 'del':
                include "hapus_surat_keluar.php";
                break;
        }
    } else {
?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <div class="z-depth-1">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper #b71c1c red darken-4">
                            <div class="col m7">
                                <ul class="left">
                                    <li class="waves-effect waves-light hide-on-small-only"><a href="?page=tsk" class="judul"><i class="material-icons">drafts</i> Surat Keluar</a></li>
                                    <li class="waves-effect waves-light">
                                        <a href="?page=tsk&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a>
                                    </li>
                                    <li class="waves-effect waves-light"><a href="?page=ask"><i class="material-icons md-24">file_upload</i> Cetak Data</a></li>
                                </ul>
                            </div>
                            <div class="col m5 hide-on-med-and-down">
                                <form method="post" action="?page=tsk">
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
        <!-- Row END -->

        <?php
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
        ?>

        <!-- Row form Start -->
        <div class="row jarak-form">

    <?php
        if (isset($_REQUEST['submit'])) {
            $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
            echo '
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=tsk"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="4%">No</th>
                                        <th width="20%">No. Surat<br/>Tgl Surat</th>
                                        <th width="15%">Tujuan</th>
                                        <th width="28%">Isi Ringkas<br/> File</th>
                                        <th width="15%">Kepada<br/>pic</th>
                                        <th width="18%">Tindakan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>';

            //script untuk mencari data
            $query = mysqli_query($config, "SELECT * FROM tbl_surat_keluar WHERE isi_sk LIKE '%$cari%' ORDER by no_sk DESC");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {

                    $y = substr($row['tgl_surat'], 0, 4);
                    $m = substr($row['tgl_surat'], 5, 2);
                    $d = substr($row['tgl_surat'], 8, 2);

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
                                        <td>' . $row['no_sk'] . '<br/><hr/>' . $d . " " . $nm . " " . $y . '</td>
                                        <td>' . $row['tujuan_sk'] . '</td>
                                        <td>' . substr($row['isi_sk'], 0, 200) . '<br/><br/><strong>File :</strong>';

                    if (!empty($row['file'])) {
                        echo ' <strong><a href="./upload/surat_keluar/' . $row['file'] . '" target="_blank">' . $row['file'] . '</a></strong>';
                    } else {
                        echo ' <em>Tidak ada file yang diupload</em>';
                    }
                    echo '</td>
                    <td>' . $row['kepada_sk'] . '<br/><hr/>' . $row['pic_sk'] . '</td>
                                        <td>
                                        <a class="btn small blue waves-effect waves-light" href="?page=tsk&act=edit&id_sk=' . $row['id_sk'] . '">
                                                    <i class="material-icons">edit</i> EDIT</a>
                                                <a class="btn small deep-orange waves-effect waves-light" href="?page=tsk&act=del&id_sk=' . $row['id_sk'] . '">
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

            echo '
                        <div class="col m12" id="colres">
                        <table class="bordered" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                    <th width="4%">No</th>
                                    <th width="20%">No. Surat<br/>Tgl Surat</th>
                                    <th width="15%">Tujuan</th>
                                    <th width="28%">Isi Ringkas<br/> File</th>
                                    <th width="15%">Kepada<br/>pic</th>
                                    <th width="18%">Tindakan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>';

            //script untuk mencari data
            $query = mysqli_query($config, "SELECT * FROM tbl_surat_keluar ORDER by no_sk DESC");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {

                    $y = substr($row['tgl_surat'], 0, 4);
                    $m = substr($row['tgl_surat'], 5, 2);
                    $d = substr($row['tgl_surat'], 8, 2);

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

                    echo '
                                    <td>' . $no++ . '</td>
                                    <td>' . $row['no_sk'] . '<br/><hr/>' . $d . " " . $nm . " " . $y . '</td>
                                    <td>' . $row['tujuan_sk'] . '</td>
                                    <td>' . substr($row['isi_sk'], 0, 200) . '<br/><br/><strong>File :</strong>';

                    if (!empty($row['file'])) {
                        echo ' <strong><a href="./upload/surat_keluar/' . $row['file'] . '" target="_blank">' . $row['file'] . '</a></strong>';
                    } else {
                        echo ' <em>Tidak ada file yang diupload</em>';
                    }
                    echo '</td>
                                    <td>' . $row['kepada_sk'] . '<br/><hr/>' . $row['pic_sk'] . '</td>
                                    <td>
                                            <a class="btn small blue waves-effect waves-light" href="?page=tsk&act=edit&id_sk=' . $row['id_sk'] . '">
                                                <i class="material-icons">edit</i> EDIT</a>
                                            <a class="btn small deep-orange waves-effect waves-light" href="?page=tsk&act=del&id_sk=' . $row['id_sk'] . '">
                                                <i class="material-icons">delete</i> DEL</a>
                                    </td>
                                </tr>
                            </tbody>';
                }
            } else {
                echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=tsk&act=add">Tambah data baru</a></u> </p></center></td></tr>';
            }
            echo '</table>
                        </div>
                    </div>
                    <!-- Row form END -->';
        }
    }
}
    ?>