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
        echo '
        <div id="main">
        <div class="wrapper">
            <section id="content">
                <div class="container">';

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
                        <div class="section"><br/>
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
                                <th width="16%">Nomor Surat<br/>Tanggal Masuk</th>
                                <th width="24%">Nama</th>
                                <th width="17%">NIP</th>
                                <th width="12%">Departemen</th>
                                <th width="12%">Tanggal Buat Surat</th>
                                <th width="15%">Tindakan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>';

            //script untuk menampilkan data
            $query = mysqli_query($config, "SELECT * FROM tbl_ska WHERE nama_ska LIKE '%$cari%' ORDER BY no_ska DESC");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {
                    echo '              <td>' . $no++ . '</td>
                                        <td>' . $row['no_ska'] . '<br/><hr/>' . $tgl = date('d M Y ', strtotime($row['tgl_masuk'])) . '</td>
                                        <td>' . $row['nama_ska'] . '</td>
                                        <td>' . $row['nip_ska'] . '</td>
                                        <td>' . $row['dept_ska'] . '</td>
                                        <td>' . $tgl = date('d M Y ', strtotime($row['tgl_buat'])) . '</td>
                                        <td>
                                            <a class="btn-small blue waves-effect waves-light black-text" href="?page=sk&act=edit&id_ska=' . $row['id_ska'] . '"> EDIT</a>
                                            <a class="btn-small yellow darken-3 waves-effect waves-light black-text" href="?page=ctk&id_ska=' . $row['id_ska'] . '" target="_blank"> PRINT</a>
                                            <a class="btn-small deep-orange waves-effect waves-light black-text" href="?page=sk&act=del&id_ska=' . $row['id_ska'] . '"> DELETE</a>
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
                        </div>
                        <!-- Row form END -->';
        } else {
            echo '
                        <div class="section">
                        <h4 class="header">Surat Keterangan Aktif Kerja</h4>
                        <div class="col m4">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="?page=sk&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a></li>
                        </ul>
                        <ul>
                        <form method="post" action="?page=sk">
                            <div class="input-field">
                                <input id="search" type="search" name="cari" placeholder="cari surat berdasarkan nama karyawan" required>
                                <input type="submit" name="submit" class="hide">
                            </div>
                        </form>
                        </ul>
                        </div>
                            <!--DataTables example-->
                            <div id="table-datatables">
                                <div class="row">
                                <div class="col m12" id="colres">
                                <table class="bordered" id="tbl">
                                    <thead class="blue lighten-4" id="head">
                                                <tr>
                                                <th width="4%">No</th>
                                                <th width="16%">Nomor Surat<br/>Tanggal Masuk</th>
                                                <th width="24%">Nama</th>
                                                <th width="17%">NIP</th>
                                                <th width="12%">Departemen</th>
                                                <th width="12%">Tanggal Buat Surat</th>
                                                <th width="15%">Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>';
            //script untuk menampilkan data
            $query = mysqli_query($config, "SELECT * FROM tbl_ska ORDER BY no_ska DESC");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {

                    echo '  <td>' . $no++ . '</td>
                            <td>' . $row['no_ska'] . '<br/><hr/>' . $tgl = date('d M Y ', strtotime($row['tgl_masuk'])) . '</td>
                            <td>' . $row['nama_ska'] . '</td>
                            <td>' . $row['nip_ska'] . '</td>
                            <td>' . $row['dept_ska'] . '</td>
                            <td>' . $tgl = date('d M Y ', strtotime($row['tgl_buat'])) . '</td>
                            <td>
                                <a class="btn-small blue waves-effect waves-light black-text" href="?page=sk&act=edit&id_ska=' . $row['id_ska'] . '"> EDIT </a>
                                <a class="btn-small yellow darken-3 waves-effect waves-light black-text" href="?page=ctk&id_ska=' . $row['id_ska'] . '" target="_blank"> PRINT</a>
                                <a class="btn-small deep-orange waves-effect waves-light black-text" href="?page=sk&act=del&id_ska=' . $row['id_ska'] . '"> DELETE</a>
                            </td>
                        </tr>
                    </tbody>';
                }
            }
            echo '</table><br/><br/>
                            </div>
                        </div>
                        <!-- Row form END -->
                            </div>
                            </div>';
        }
    }
}
