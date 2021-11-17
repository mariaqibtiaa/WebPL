<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    echo '
    <div id="main">
    <div class="wrapper">
        <section id="content">
            <div class="container"><br />';

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if (
            $_REQUEST['no_ska'] == "" || $_REQUEST['nip_ska'] == "" || $_REQUEST['nama_ska'] == ""
            || $_REQUEST['tgl_masuk'] == ""  || $_REQUEST['tgl_buat'] == ""  || $_REQUEST['dept_ska'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_ska = $_REQUEST['no_ska'];
            $nip_ska = $_REQUEST['nip_ska'];
            $nama_ska = $_REQUEST['nama_ska'];
            $tgl_masuk = $_REQUEST['tgl_masuk'];
            $tgl_buat = $_REQUEST['tgl_buat'];
            $dept_ska = $_REQUEST['dept_ska'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_ska)) {
                $_SESSION['no_skak'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $nip_ska)) {
                    $_SESSION['nip_ska'] = 'Form Asal Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-),kurung() dan garis miring(/)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9., -]*$/", $nama_ska)) {
                        $_SESSION['nama_ska'] = 'Form nama_ska hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan koma(,) dan minus (-)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $dept_ska)) {
                            $_SESSION['dept_ska'] = 'Form dept_ska hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[0-9.-]*$/", $tgl_masuk)) {
                                $_SESSION['tgl_masuk'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if (!preg_match("/^[0-9.-]*$/", $tgl_buat)) {
                                    $_SESSION['tgl_buat'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $cek = mysqli_query($config, "SELECT * FROM tbl_ska WHERE no_ska='$no_ska'");
                                    $result = mysqli_num_rows($cek);

                                    if ($result > 0) {
                                        $_SESSION['errDup'] = 'Nomor Surat sudah terpakai, gunakan yang lain!';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    } else {

                                        $query = mysqli_query($config, "INSERT INTO tbl_ska(no_ska,nip_ska,nama_ska,dept_ska,tgl_masuk,tgl_buat)
                                                                        VALUES('$no_ska','$nip_ska','$nama_ska','$dept_ska','$tgl_masuk','$tgl_buat')");

                                        if ($query == true) {
                                            $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                            header("Location: ./admin.php?page=sk");
                                            die();
                                        } else {
                                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    } else { ?>

        <?php
        if (isset($_SESSION['errQ'])) {
            $errQ = $_SESSION['errQ'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errQ . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['errQ']);
        }
        if (isset($_SESSION['errEmpty'])) {
            $errEmpty = $_SESSION['errEmpty'];
            echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errEmpty . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
            unset($_SESSION['errEmpty']);
        }
        ?>
        <!-- Row form Start -->
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="POST" action="?page=sk&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_buat" type="text" name="tgl_buat" class="datepicker" required>
                        <label for="tgl_buat">Tanggal Buat Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_ska" type="text" class="validate" name="no_ska" required>
                        <?php
                        if (isset($_SESSION['no_skak'])) {
                            $no_skak = $_SESSION['no_skak'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_skak . '</div>';
                            unset($_SESSION['no_skak']);
                        }
                        if (isset($_SESSION['errDup'])) {
                            $errDup = $_SESSION['errDup'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                            unset($_SESSION['errDup']);
                        }
                        ?>
                        <label for="no_ska">Nomor Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">text_fields</i>
                        <input id="nama_ska" type="text" class="validate" name="nama_ska" required>
                        <?php
                        if (isset($_SESSION['nama_ska'])) {
                            $nama_ska = $_SESSION['nama_ska'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nama_ska . '</div>';
                            unset($_SESSION['nama_ska']);
                        }
                        ?>
                        <label for="nama_ska">Nama</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">filter_1</i>
                        <input id="nip_ska" type="text" class="validate" name="nip_ska" required>
                        <?php
                        if (isset($_SESSION['nip_ska'])) {
                            $nip_ska = $_SESSION['nip_ska'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $nip_ska . '</div>';
                            unset($_SESSION['nip_ska']);
                        }
                        ?>
                        <label for="nip_ska">NIP</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">featured_play_list</i>
                        <input id="dept_ska" type="text" class="validate" name="dept_ska" required>
                        <?php
                        if (isset($_SESSION['dept_ska'])) {
                            $dept_ska = $_SESSION['dept_ska'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $dept_ska . '</div>';
                            unset($_SESSION['dept_ska']);
                        }
                        ?>
                        <label for="dept_ska">Departemen</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_masuk" type="text" name="tgl_masuk" class="datepicker" required>
                        <label for="tgl_masuk">Tanggal Aktif</label>
                    </div>
                </div>
                <!-- Row in form END -->

                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <a href="?page=sk" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                    </div>
                </div>
                <br />
            </form>
            <!-- Form END -->

        </div>
        <!-- Row form END -->
        </div>
        </section>
        </div>
        </div>
<?php
    }
}
?>