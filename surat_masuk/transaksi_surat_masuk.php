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
                include "tambah_surat_masuk.php";
                break;
            case 'edit':
                include "edit_surat_masuk.php";
                break;
            case 'del':
                include "hapus_surat_masuk.php";
                break;
            case 'disp':
                include "disposisi.php";
                break;
        }
    } else {

        echo '<div id="main">
        <div class="wrapper">
        <!-- START CONTENT -->
        <section id="content">
            <!--start container-->
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
?>

        <!-- Row form Start -->
        <div class="row jarak-form">

    <?php
        if (isset($_REQUEST['submit'])) {
            $cari = mysqli_real_escape_string($config, $_REQUEST['cari']);
            echo '
                    <div class="section"><br/>
                        <div class="col s12" style="margin-top: -18px;">
                            <div class="card blue lighten-5">
                                <div class="card-content">
                                <p class="description">Hasil pencarian isi ringkas surat masuk untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=tsm"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col m12" id="colres">
                        <table class="responsive-table" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                <tr>
                                <th width="4%">No</th>
                                <th width="18%">No. Surat<br/>Tgl Surat</th>
                                <th width="21%">Perihal Surat</th>
                                <th width="15%">Asal Surat</th>
                                <th width="32%">Isi Ringkas<br/> File</th>
                                <th width="10%">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>';

            //script untuk mencari data
            $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE isi_sm LIKE '%$cari%' ORDER by no_sm DESC");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {

                    echo '
                                    <td>' . $no++ . '</td>
                                    <td>' . $row['no_sm'] . '<br/><hr/>' . $tgl = date('d M Y ', strtotime($row['tgl_surat'])) . '</td>
                                    <td>' . $row['perihal_sm'] . '</td>
                                    <td>' . $row['asal_sm'] . '</td>
                                    <td>' . substr($row['isi_sm'], 0, 200) . '<br/><br/><strong>File :</strong>';

                    if (!empty($row['file'])) {
                        echo ' <strong><a href="./upload/surat_masuk/' . $row['file'] . '" target="_blank">' . $row['file'] . '</a></strong>';
                    } else {
                        echo '<em>Tidak ada file yang di upload</em>';
                    }
                    echo '</td>
                        <td>
                            <a class="btn-small blue waves-effect waves-light black-text" href="?page=tsm&act=edit&id_sm=' . $row['id_sm'] . '"> EDIT</a>
                            <a class="btn-small deep-orange waves-effect waves-light black-text" href="?page=tsm&act=del&id_sm=' . $row['id_sm'] . '"> DELETE</a>
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

            // DIATAS ADALAH PENCARIAN
            // DIBAWAH ADALAH MENU

        } else {
            echo '
                <div class="section">
                <div class="card blue lighten-5">
                <div class="card-content">
                <h4 class="header">Arsip Surat Masuk</h4>
                <div class="col m6">
                <ul class="text-right">
                    <li class="waves-effect waves-light"><a href="?page=tsm&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a></li>
                    <li class="waves-effect waves-light"><a href="?page=asm"><i class="material-icons md-24">filter_list</i> Filter Surat Masuk</a></li>
                    <li class="waves-effect waves-light"><a href="?page=ctksm"  target="_blank"><i class="material-icons md-24">file_upload</i> Cetak Surat</a></li>
                    
                </ul>
                </div>
                <div class="col m6">
                <ul class="text-right">
                <form method="post" action="?page=tsm">
                    <div class="input-field round-in-box">
                        <input id="search" type="search" name="cari" placeholder="cari surat berdasarkan isi ringkas" required>
                        <input type="submit" name="submit" class="hide tooltipped" data-position="top" data-tooltip="Jika tidak ada logo, biarkan kosong">
                    </div>
                </form>
                </ul>
                </div>
                </div>
                </div>
                    <!--DataTables example-->
                    <div id="table-datatables">
                        <div class="row">
                        <div class="col m12" id="colres">
                        <table class="highlight" id="tbl">
                            <thead class="blue lighten-4" id="head">
                                        <tr>
                                        <th width="4%">No</th>
                                        <th width="18%">No. Surat<br/>Tgl Surat</th>
                                        <th width="21%">Perihal Surat</th>
                                        <th width="15%">Asal Surat</th>
                                        <th width="32%">Isi Ringkas<br/> File</th>
                                        <th width="10%">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            //script untuk menampilkan data
            $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk ORDER by tgl_surat DESC");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {

                    echo '<tr>
                                        <td>' . $no++ . '</td>
                                        <td>' . $row['no_sm'] . '<br/><hr/>' . $tgl = date('d M Y ', strtotime($row['tgl_surat'])) . '</td>
                                        <td>' . $row['perihal_sm'] . '</td>
                                        <td>' . $row['asal_sm'] . '</td>
                                        <td>' . substr($row['isi_sm'], 0, 200) . '<br/><br/><strong>File :</strong>';

                    if (!empty($row['file'])) {
                        echo ' <strong><a href="./upload/surat_masuk/' . $row['file'] . '" target="_blank">' . $row['file'] . '</a></strong>';
                    } else {
                        echo '<em>Tidak ada file yang di upload</em>';
                    }
                    echo '</td>
                            <td>
                                <a class="btn-small blue waves-effect waves-light black-text" href="?page=tsm&act=edit&id_sm=' . $row['id_sm'] . '"> EDIT</a>
                                <a class="btn-small #d50000 red accent-4 waves-effect waves-light black-text" href="?page=tsm&act=del&id_sm=' . $row['id_sm'] . '"> DELETE</a>
                                <a class="btn-small light-green waves-effect waves-light black-text" href="?page=tsm&act=disp&id_sm=' . $row['id_sm'] . '"> DISPOSISI</a>
                            </td>
                        </tr>
                    </tbody>';
                }
            } else {
                echo '<tr><td colspan="6"><center><p class="add">Tidak ada data yang ditemukan</p></center></td></tr>';
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
