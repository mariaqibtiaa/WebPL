<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if (
            $_REQUEST['no_ska'] == "" || $_REQUEST['nama_ska'] == "" || $_REQUEST['nip_ska'] == ""
            || $_REQUEST['tgl_masuk'] == ""  || $_REQUEST['dept_ska'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_ska = $_REQUEST['id_ska'];
            $no_ska = $_REQUEST['no_ska'];
            $nama_ska = $_REQUEST['nama_ska'];
            $nip_ska = $_REQUEST['nip_ska'];
            $tgl_masuk = $_REQUEST['tgl_masuk'];
            $dept_ska = $_REQUEST['dept_ska'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_ska)) {
                $_SESSION['eno_ska'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $nama_ska)) {
                    $_SESSION['enama_ska'] = 'Form Asal Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9., -]*$/", $nip_ska)) {
                        $_SESSION['enip_ska'] = 'Form nip_ska hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan koma(,) dan minus (-)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[0-9.-]*$/", $tgl_masuk)) {
                            $_SESSION['etgl_masuk'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $dept_ska)) {
                                $_SESSION['edept_ska'] = 'Form dept_ska hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                $query = mysqli_query($config, "UPDATE tbl_ska SET no_ska='$no_ska', nama_ska='$nama_ska',nip_ska='$nip_ska',tgl_masuk='$tgl_masuk',dept_ska='$dept_ska' WHERE id_ska='$id_ska'");

                                if ($query == true) {
                                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
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
    } else {

        $id_ska = mysqli_real_escape_string($config, $_REQUEST['id_ska']);
        $query = mysqli_query($config, "SELECT id_ska, no_ska, nama_ska, nip_ska, tgl_masuk, dept_ska FROM tbl_ska WHERE id_ska='$id_ska'");
        list($id_ska, $no_ska, $nama_ska, $nip_ska, $tgl_masuk, $dept_ska) = mysqli_fetch_array($query);
?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper #b71c1c red darken-4">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Data Surat Keterangan Aktif</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Secondary Nav END -->
        </div>
        <!-- Row END -->

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
            <form class="col s12" method="POST" action="?page=sk&act=edit" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_ska" type="text" class="validate" name="no_ska" value="<?php echo $no_ska; ?>" required>
                        <?php
                        if (isset($_SESSION['eno_ska'])) {
                            $eno_ska = $_SESSION['eno_ska'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_ska . '</div>';
                            unset($_SESSION['eno_ska']);
                        }
                        ?>
                        <label for="no_ska">Nomor Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="hidden" name="id_ska" value="<?php echo $id_ska; ?>">
                        <i class="material-icons prefix md-prefix">text_fields</i>
                        <input id="nama_ska" type="text" class="validate" value="<?php echo $nama_ska; ?>" name="nama_ska" required>
                        <?php
                        if (isset($_SESSION['enama_ska'])) {
                            $enama_ska = $_SESSION['enama_ska'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enama_ska . '</div>';
                            unset($_SESSION['enama_ska']);
                        }
                        ?>
                        <label for="nama_ska">Nama</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">filter_1</i>
                        <input id="nip_ska" type="text" class="validate" name="nip_ska" value="<?php echo $nip_ska; ?>" required>
                        <?php
                        if (isset($_SESSION['enip_ska'])) {
                            $enip_ska = $_SESSION['enip_ska'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $enip_ska . '</div>';
                            unset($_SESSION['enip_ska']);
                        }
                        ?>
                        <label for="nip_ska">NIP</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">featured_play_list</i>
                        <input id="dept_ska" type="text" class="validate" name="dept_ska" value="<?php echo $dept_ska; ?>" required>
                        <?php
                        if (isset($_SESSION['edept_ska'])) {
                            $edept_ska = $_SESSION['edept_ska'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $edept_ska . '</div>';
                            unset($_SESSION['edept_ska']);
                        }
                        ?>
                        <label for="dept_ska">Departemen</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_masuk" type="text" name="tgl_masuk" class="datepicker" value="<?php echo $tgl_masuk; ?>" required>
                        <?php
                        if (isset($_SESSION['etgl_masuk'])) {
                            $etgl_masuk = $_SESSION['etgl_masuk'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $etgl_masuk . '</div>';
                            unset($_SESSION['etgl_masuk']);
                        }
                        ?>
                        <label for="tgl_masuk">Tanggal Masuk</label>
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

            </form>
            <!-- Form END -->

        </div>
        <!-- Row form END -->

<?php
    }
}
?>