<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    $id_sm = $_REQUEST['id_sm'];

    $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_sm='$id_sm'");

    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {

            echo '
    <div id="main">
        <div class="wrapper">
            <!-- START CONTENT -->
            <section id="content">
                <!--start container-->
                <div class="container"><br />
                            <!-- Perihal START -->
                            <div class="col s12">
                                <div class="card blue lighten-5">
                                    <div class="card-content">
                                    <p class="waves-effect waves-light hide-on-small-only"><a href="?page=tsm"><i class="material-icons">arrow_back</i> Kembali</a></p>
                                        <h4 class="header">Disposisi Surat Masuk</h4>
                                        <p><span class="description strong">Perihal Surat: </span>' . $row['perihal_sm'] . '</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Perihal END -->';

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

            echo '
                            <!-- Row form Start -->
                            <div class="row jarak-form">

                                <div class="col m12" id="colres">
                                    <table class="bordered" id="tbl">
                                        <thead class="blue lighten-4" id="head">
                                            <tr>
                                                <th width="4%">No</th>
                                                <th width="24%">Tanggal Diterima<br/>Nama Penerima</th>
                                                <th width="24%">Nomor Surat<br/>Sifat</th>
                                                <th width="24%">Asal Surat<br/>Perihal Surat</th>
                                                <th width="24%">Tanggal Surat</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>';

            $query2 = mysqli_query($config, "SELECT * FROM tbl_disposisi 
                                            INNER JOIN tbl_surat_masuk 
                                            ON tbl_disposisi.id_sm = tbl_surat_masuk.id_sm WHERE tbl_disposisi.id_sm='$id_sm'");

            if (mysqli_num_rows($query2) > 0) {
                $no = 0;
                while ($row = mysqli_fetch_array($query2)) {
                    $no++;
                    echo ' <td>' . $no . '</td>
                                                    <td>' . $tgl = date('d M Y ', strtotime($row['tgl_diterima'])) . '<br/>' . $row['nama_penerima'] . '</td>
                                                    <td>' . $row['no_sm'] . '<br/>' . $row['sifat'] . '</td>
                                                    <td>' . $row['asal_sm'] . '<br/>' . $row['perihal_sm'] . '</td>
                                                    <td>' . $tgl = date('d M Y ', strtotime($row['tgl_surat'])) . '</td>
                                            </tr>
                                        </tbody>';
                }
            } else {
                echo '<tr><td colspan="5"><center><p class="add">Tidak ada data untuk ditampilkan. <u><a href="?page=tsm&act=disp&id_sm=' . $row['id_sm'] . '&sub=add">Tambah data baru</a></u></p></center></td></tr>';
            }
            echo '</table>
                                </div>
                            </div>
                            <!-- Row form END -->';
        }
    }
}
