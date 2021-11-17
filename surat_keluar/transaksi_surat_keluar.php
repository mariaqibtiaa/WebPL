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
        } ?>
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
                                    <p class="description">Hasil pencarian isi ringkas surat keluar untuk kata kunci <strong>"' . stripslashes($cari) . '"</strong><span class="right"><a href="?page=tsk"><i class="material-icons md-36" style="color: #333;">clear</i></a></span></p>
                                    </div>
                                </div>
                            </div>

                        <div class="col m12" id="colres">
                            <table class="bordered" id="tbl">
                                <thead class="blue lighten-4" id="head">
                                    <tr>
                                        <th width="4%">No</th>
                                        <th width="18%">No. Surat<br />Tgl Surat</th>
                                        <th width="39%">Isi Ringkas<br /> File</th>
                                        <th width="29%">Kepada<br />pic</th>
                                        <th width="10%">Tindakan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>';

            //script untuk mencari data
            $query = mysqli_query($config, "SELECT * FROM tbl_surat_keluar WHERE isi_sk LIKE '%$cari%' ORDER by no_sk DESC");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {

                    echo '              <td>' . $no++ . '</td>
                                        <td>' . $row['no_sk'] . '<br/><hr/>' . $tgl = date('d M Y ', strtotime($row['tgl_surat'])) . '</td>
                                        <td>' . substr($row['isi_sk'], 0, 200) . '<br/><br/><strong>File :</strong>';

                    if (!empty($row['file'])) {
                        echo ' <strong><a href="./upload/surat_keluar/' . $row['file'] . '" target="_blank">' . $row['file'] . '</a></strong>';
                    } else {
                        echo ' <em>Tidak ada file yang diupload</em>';
                    }
                    echo '</td>
                    <td>' . $row['kepada_sk'] . '<br/><hr/>' . $row['pic_sk'] . '</td>
                                        <td>
                                        <a class="btn-small blue waves-effect waves-light black-text" href="?page=tsk&act=edit&id_sk=' . $row['id_sk'] . '"> EDIT</a>
                                                <a class="btn-small deep-orange waves-effect waves-light black-text" href="?page=tsk&act=del&id_sk=' . $row['id_sk'] . '"> DELETE</a>
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
                        </div>
                        </section>
                        </div>
                        </div>
                        <!-- Row form END -->';
        } else {
            echo '
                        <div class="section">
                            <div class="col m3">
                                <ul class="left">
                                    <h4 class="header">Surat Keluar</h4>
                                    <li class="waves-effect waves-light"><a href="?page=tsk&act=add"><i class="material-icons md-24">add_circle</i> Tambah Data</a></li>
                                    <li class="waves-effect waves-light"><a href="?page=ask"><i class="material-icons md-24">filter_list</i> Filter Surat Masuk</a></li>
                                    <li class="waves-effect waves-light"><a href="?page=ctksk"  target="_blank"><i class="material-icons md-24">file_upload</i> Cetak Surat</a></li>
                                </ul>
                                <ul>
                                    <form method="post" action="?page=tsk">
                                        <div class="input-field">
                                            <input id="search" type="search" name="cari" placeholder="cari surat berdasarkan isi ringkas" required>
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
                                                    <th width="18%">No. Surat<br />Tgl Surat</th>
                                                    <th width="39%">Isi Ringkas<br /> File</th>
                                                    <th width="29%">Kepada<br />pic</th>
                                                    <th width="10%">Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

            //script untuk mencari data
            $query = mysqli_query($config, "SELECT * FROM tbl_surat_keluar ORDER BY no_sk DESC");
            $no = 1;
            while ($row = mysqli_fetch_array($query)) {
                echo '<tr>
                                                    <td>' . $no++ . '</td>
                                                    <td>' . $row['no_sk'] . '<br/><hr/>' . $tgl = date('d M Y ', strtotime($row['tgl_surat'])) . '</td>
                                                    <td>' . substr($row['isi_sk'], 0, 200) . '<br/><br/><strong>File :</strong>';

                if (!empty($row['file'])) {
                    echo ' <strong><a href="./upload/surat_keluar/' . $row['file'] . '" target="_blank">' . $row['file'] . '</a></strong>';
                } else {
                    echo ' <em>Tidak ada file yang diupload</em>';
                }
                echo '</td>
                                                <td>' . $row['kepada_sk'] . '<br/><hr/>' . $row['pic_sk'] . '</td>
                                                <td>
                                                        <a class="btn-small blue waves-effect waves-light black-text" href="?page=tsk&act=edit&id_sk=' . $row['id_sk'] . '">EDIT</a>
                                                        <a class="btn-small deep-orange waves-effect waves-light black-text" href="?page=tsk&act=del&id_sk=' . $row['id_sk'] . '"> DELETE</a>
                                                </td>
                                            </tr>
                                        </tbody>';
            }
            echo '</table><br/><br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </section>
                </div>
            </div>';
        }
    }
}
