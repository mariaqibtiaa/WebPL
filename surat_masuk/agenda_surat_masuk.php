<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    echo '
            <style type="text/css">
                .hidd {
                    display: none
                }
                @media print{
                    body {
                        font-size: 12px!important;
                        color: #212121;
                    }
                    .separator {
                        border-bottom: 2px solid #616161;
                        margin: 1rem 0 -.7rem;
                    }
                }
            </style>';

    if (isset($_REQUEST['submit'])) {

        $dari_tanggal = $_REQUEST['dari_tanggal'];
        $sampai_tanggal = $_REQUEST['sampai_tanggal'];

        if ($_REQUEST['dari_tanggal'] == "" || $_REQUEST['sampai_tanggal'] == "") {
            header("Location: ./admin.php?page=asm");
            die();
        } else {

            $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE tgl_surat BETWEEN '$dari_tanggal' AND '$sampai_tanggal' ORDER BY no_sm ASC");

            $query2 = mysqli_query($config, "SELECT nama FROM tbl_instansi");
            list($nama) = mysqli_fetch_array($query2);

            echo '
                    <!-- SHOW DAFTAR AGENDA -->
                    <!-- Row Start -->
                    <div class="row">
                        <!-- Secondary Nav START -->
                        <div class="col s12">
                            <div class="z-depth-1">
                                <nav class="secondary-nav">
                                    <div class="nav-wrapper #b71c1c red darken-4">
                                        <div class="col 12">
                                            <ul class="left">
                                                <li class="waves-effect waves-light"><a href="?page=asm" class="judul"><i class="material-icons">print</i> Cetak Agenda Surat Masuk<a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <!-- Secondary Nav END -->
                    </div>
                    <!-- Row END -->

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
                                <button type="submit" name="submit" class="btn-large blue waves-effect waves-light"> TAMPILKAN <i class="material-icons">visibility</i></button>
                            </div>
                        </form>
                    </div>
                    <!-- Row form END -->

                    <div class="row agenda">
                        <div class="col s10">
                            <div class="separator"></div>
                            <h5 class="hid">AGENDA SURAT MASUK</h5>';

            $y = substr($dari_tanggal, 0, 4);
            $m = substr($dari_tanggal, 5, 2);
            $d = substr($dari_tanggal, 8, 2);
            $y2 = substr($sampai_tanggal, 0, 4);
            $m2 = substr($sampai_tanggal, 5, 2);
            $d2 = substr($sampai_tanggal, 8, 2);

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

            if ($m2 == "01") {
                $nm2 = "Januari";
            } elseif ($m2 == "02") {
                $nm2 = "Februari";
            } elseif ($m2 == "03") {
                $nm2 = "Maret";
            } elseif ($m2 == "04") {
                $nm2 = "April";
            } elseif ($m2 == "05") {
                $nm2 = "Mei";
            } elseif ($m2 == "06") {
                $nm2 = "Juni";
            } elseif ($m2 == "07") {
                $nm2 = "Juli";
            } elseif ($m2 == "08") {
                $nm2 = "Agustus";
            } elseif ($m2 == "09") {
                $nm2 = "September";
            } elseif ($m2 == "10") {
                $nm2 = "Oktober";
            } elseif ($m2 == "11") {
                $nm2 = "November";
            } elseif ($m2 == "12") {
                $nm2 = "Desember";
            }
            echo '

                            <p class="warna agenda">Agenda Surat Masuk dari tanggal <strong>' . $d . " " . $nm . " " . $y . '</strong> sampai dengan tanggal <strong>' . $d2 . " " . $nm2 . " " . $y2 . '</strong></p>
                        </div>
                        <div class="col s2">
                            <button type="submit" onClick="window.print()" class="btn-large deep-orange waves-effect waves-light right">CETAK <i class="material-icons">print</i></button>
                        </div>
                    </div>
                    <div id="colres" class="warna cetak">
                        <table class="bordered" id="tbl" width="100%">
                            <thead class="blue lighten-4">
                                <tr>
                                <th width="3%">No</th>
                                <th width="15%">Nomor Surat</th>
                                <th width="10%">Tanggal<br/> Surat</th>
                                <th width="18%">kategori</th>
                                <th width="30%">Isi Ringkas</th>
                                <th width="12%">Kepada</th>
                                <th width="12%">PIC</th>
                            </thead>

                            <tbody>
                                <tr>';

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
                                        <td>' . $row['no_sm'] . '</td>
                                        <td>' . $d . " " . $nm . " " . $y . '</td>
                                        <td>' . $row['kategori_sm'] . '</td>
                                        <td>' . $row['isi_sm'] . '</td>
                                        <td>' . $row['kepada_sm'] . '</td>
                                        <td>' . $row['pic_sm'] . '</td>
                            </td>
                        </tr>
                    </tbody>';
                }
            } else {
                echo '<tr><td colspan="9"><center><p class="add">Tidak ada agenda surat</p></center></td></tr>';
            }
            echo '
                        </table>
                    </div>';
        }
    } else {

        echo '
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <div class="z-depth-1">
                            <nav class="secondary-nav">
                                <div class="nav-wrapper #b71c1c red darken-4">
                                    <div class="col 12">
                                        <ul class="left">
                                            <li class="waves-effect waves-light"><a href="?page=ask" class="judul"><i class="material-icons">print</i> Cetak Agenda Surat Masuk<a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

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
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light"> TAMPILKAN <i class="material-icons">visibility</i></button>
                        </div>
                    </form>
                </div>
                <!-- Row form END -->';
    }
}
