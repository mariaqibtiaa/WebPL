<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        $dari_tanggal = $_REQUEST['dari_tanggal'];
        $sampai_tanggal = $_REQUEST['sampai_tanggal'];

        if ($_REQUEST['dari_tanggal'] == "" || $_REQUEST['sampai_tanggal'] == "") {
            header("Location: ./admin.php?page=ask");
            die();
        } else {

            $query = mysqli_query($config, "SELECT * FROM tbl_surat_keluar WHERE tgl_surat BETWEEN '$dari_tanggal' AND '$sampai_tanggal' ORDER by no_sk DESC");

            echo '
            <!-- Row form Start -->
            <div id="main">
                <div class="wrapper">
                    <!-- START CONTENT -->
                    <section id="content">
                        <!--start container-->
                        <div class="container">
                            <div class="section">
                            <div class="col m7">
                            <ul class="left">
                                <h4 class="header">Agenda Surat Keluar</h4>
                            </ul>
                        </div>
                    <!-- Row form Start -->
                    <div class="row jarak-form black-text">
                        <form class="col s12" method="post" action="">
                            <div class="input-field col s3">
                                <i class="material-icons prefix md-prefix">date_range</i>
                                <input id="dari_tanggal" type="text" name="dari_tanggal" id="dari_tanggal" required>
                                <label for="dari_tanggal">Dari Tanggal</label>
                            </div>
                            <div class="input-field col s3">
                                <i class="material-icons prefix md-prefix">date_range</i>
                                <input id="sampai_tanggal" type="text" name="sampai_tanggal" id="sampai_tanggal" required>
                                <label for="sampai_tanggal">Sampai Tanggal</label>
                            </div>
                            <div class="col s6">
                                <button type="submit" name="submit" class="btn-large blue waves-effect waves-light"> TAMPILKAN</button>
                            </div>
                        </form>
                    </div>
                    <!-- Row form END -->

                    <div class="row agenda">
                        <div class="col s10">
                            <div class="separator"></div>
                            <p class="warna agenda">Agenda Surat Keluar dari tanggal <strong>' . $tgl = date('d M Y ', strtotime($dari_tanggal)) . '</strong> sampai dengan tanggal <strong>' . $tgl = date('d M Y ', strtotime($sampai_tanggal)) . '</strong></p>
                        </div>
                    </div>
                    <div id="colres" class="warna cetak">
                        <table class="bordered" id="tbl" width="100%">
                            <thead class="blue lighten-4">
                                <tr>
                                    <th width="4%">No</th>
                                    <th width="15%">Nomor Surat</th>
                                    <th width="11%">Tanggal<br/> Surat</th>
                                    <th width="30%">Isi Ringkas</th>
                                    <th width="25%">Kepada</th>
                                    <th width="15%">pic</th>
                            </thead>

                            <tbody>
                                <tr>';

            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) {

                    echo '  <td>' . $no++ . '</td>
                            <td>' . $row['no_sk'] . '</td>
                            <td>' . $tgl = date('d M Y ', strtotime($row['tgl_surat'])) . '</td>
                            <td>' . $row['isi_sk'] . '</td>
                            <td>' . $row['kepada_sk'] . '</td>
                            <td>' . $row['pic_sk'] . '
                            </td>
                                </tr>
                            </tbody>';
                }
            } else {
                echo '<tr><td colspan="9"><center><p class="add">Tidak ada agenda surat</p></center></td></tr>';
            }
            echo '
                            </table>
                        </div>
                    <div class="jarak2"></div>
                    </div>
                    </section>
                    </div>
                    </div>';
        }
    } else {
        echo '
        <!-- Row form Start -->
        <div id="main">
            <div class="wrapper">
                <!-- START CONTENT -->
                <section id="content">
                    <!--start container-->
                    <div class="container">
                        <div class="section">
                        <div class="col m7">
                        <ul class="left">
                            <h4 class="header">Agenda Surat Keluar</h4>
                        </ul>
                    </div>
                <!-- Row form Start -->
                <div class="row jarak-form black-text">
                    <form class="col s12" method="post" action="">
                        <div class="input-field col s3">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="dari_tanggal" type="text" name="dari_tanggal" id="dari_tanggal" required>
                            <label for="dari_tanggal">Dari Tanggal</label>
                        </div>
                        <div class="input-field col s3">
                            <i class="material-icons prefix md-prefix">date_range</i>
                            <input id="sampai_tanggal" type="text" name="sampai_tanggal" id="sampai_tanggal" required>
                            <label for="sampai_tanggal">Sampai Tanggal</label>
                        </div>
                        <div class="col s6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light"> TAMPILKAN</button>
                        </div>
                    </form>
                </div>
                <div class="jarak"></div>
                </div>
                </section>
                </div>
                </div>';
    }
}
