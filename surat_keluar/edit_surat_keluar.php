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
        <!-- START CONTENT -->
        <section id="content"><br /><br />';

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if (
            $_REQUEST['kepada_sk'] == "" || $_REQUEST['no_sk'] == "" || $_REQUEST['isi_sk'] == ""
            || $_REQUEST['tgl_surat'] == ""  || $_REQUEST['pic_sk'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $id_sk = $_REQUEST['id_sk'];
            $kepada_sk = $_REQUEST['kepada_sk'];
            $no_sk = $_REQUEST['no_sk'];
            $isi_sk = $_REQUEST['isi_sk'];
            $tgl_surat = $_REQUEST['tgl_surat'];
            $pic_sk = $_REQUEST['pic_sk'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $kepada_sk)) {
                $_SESSION['kepada_skk'] = 'Form Kepada hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_sk)) {
                    $_SESSION['no_skk'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi_sk)) {
                        $_SESSION['isi_skk'] = 'Form Isi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[0-9.-]*$/", $tgl_surat)) {
                            $_SESSION['tgl_suratk'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $pic_sk)) {
                                $_SESSION['pic_skk'] = 'Form pic hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
                                $file = $_FILES['file']['name'];
                                $x = explode('.', $file);
                                $eks = strtolower(end($x));
                                $ukuran = $_FILES['file']['size'];
                                $target_dir = "upload/surat_keluar/";

                                //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                if ($file != "") {

                                    $rand = rand(1, 10000);
                                    $nfile = $rand . "-" . $file;

                                    //validasi file
                                    if (in_array($eks, $ekstensi) == true) {
                                        if ($ukuran < 2500000) {

                                            $id_sk = $_REQUEST['id_sk'];
                                            $query = mysqli_query($config, "SELECT file FROM tbl_surat_keluar WHERE id_sk='$id_sk'");
                                            list($file) = mysqli_fetch_array($query);

                                            //jika file sudah ada akan mengeksekusi script dibawah ini
                                            if (!empty($file)) {
                                                unlink($target_dir . $file);

                                                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                                $query = mysqli_query($config, "UPDATE tbl_surat_keluar SET kepada_sk='$kepada_sk',no_sk='$no_sk',isi_sk='$isi_sk',tgl_surat='$tgl_surat',file='$nfile',pic_sk='$pic_sk' WHERE id_sk='$id_sk'");

                                                if ($query == true) {
                                                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                    header("Location: ./admin.php?page=tsk");
                                                    die();
                                                } else {
                                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                    echo '<script language="javascript">window.history.back();</script>';
                                                }
                                            } else {

                                                //jika file kosong akan mengeksekusi script dibawah ini
                                                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                                $query = mysqli_query($config, "UPDATE tbl_surat_keluar SET kepada_sk='$kepada_sk',no_sk='$no_sk',isi_sk='$isi_sk',tgl_surat='$tgl_surat',file='$nfile',pic_sk='$pic_sk' WHERE id_sk='$id_sk'");

                                                if ($query == true) {
                                                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                    header("Location: ./admin.php?page=tsk");
                                                    die();
                                                } else {
                                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                    echo '<script language="javascript">window.history.back();</script>';
                                                }
                                            }
                                        } else {
                                            $_SESSION['errSize'] = 'Ukuran file yang diupload terlalu besar!';
                                            echo '<script language="javascript">window.history.back();</script>';
                                        }
                                    } else {
                                        $_SESSION['errFormat'] = 'Format file yang diperbolehkan hanya *.JPG, *.PNG, *.DOC, *.DOCX atau *.PDF!';
                                        echo '<script language="javascript">window.history.back();</script>';
                                    }
                                } else {

                                    //jika form file kosong akan mengeksekusi script dibawah ini
                                    $id_sk = $_REQUEST['id_sk'];

                                    $query = mysqli_query($config, "UPDATE tbl_surat_keluar SET kepada_sk='$kepada_sk',no_sk='$no_sk',isi_sk='$isi_sk',tgl_surat='$tgl_surat',pic_sk='$pic_sk' WHERE id_sk='$id_sk'");

                                    if ($query == true) {
                                        $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                        header("Location: ./admin.php?page=tsk");
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
    } else {

        $id_sk = mysqli_real_escape_string($config, $_REQUEST['id_sk']);
        $query = mysqli_query($config, "SELECT id_sk, kepada_sk, no_sk, isi_sk, tgl_surat, file, pic_sk FROM tbl_surat_keluar WHERE id_sk='$id_sk'");
        list($id_sk, $kepada_sk, $no_sk, $isi_sk, $tgl_surat, $file, $pic_sk) = mysqli_fetch_array($query);
?>

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
        <div class="col m7">
            <ul class="left">
                <h4 class="header">Edit Data Surat Keluar</h4>
            </ul>
        </div>
        <!-- Row form Start -->
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="POST" action="?page=tsk&act=edit" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_sk" type="text" class="validate" name="no_sk" value="<?php echo $no_sk; ?>" required>
                        <?php
                        if (isset($_SESSION['no_skk'])) {
                            $no_skk = $_SESSION['no_skk'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_skk . '</div>';
                            unset($_SESSION['no_skk']);
                        }
                        ?>
                        <label for="no_sk">Nomor Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_surat" type="text" name="tgl_surat" class="datepicker" value="<?php echo $tgl_surat; ?>" required>
                        <?php
                        if (isset($_SESSION['tgl_suratk'])) {
                            $tgl_suratk = $_SESSION['tgl_suratk'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_suratk . '</div>';
                            unset($_SESSION['tgl_suratk']);
                        }
                        ?>
                        <label for="tgl_surat">Tanggal Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="hidden" name="id_sk" value="<?php echo $id_sk; ?>">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <input id="kepada_sk" type="text" class="validate" name="kepada_sk" value="<?php echo $kepada_sk; ?>" required>
                        <?php
                        if (isset($_SESSION['kepada_skk'])) {
                            $kepada_skk = $_SESSION['kepada_skk'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kepada_skk . '</div>';
                            unset($_SESSION['kepada_skk']);
                        }
                        ?>
                        <label for="kepada_sk">Kepada</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">featured_play_list</i>
                        <input id="pic_sk" type="text" class="validate" name="pic_sk" value="<?php echo $pic_sk; ?>" required>
                        <?php
                        if (isset($_SESSION['pic_skk'])) {
                            $pic_skk = $_SESSION['pic_skk'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pic_skk . '</div>';
                            unset($_SESSION['pic_skk']);
                        }
                        ?>
                        <label for="pic_sk">pic</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">description</i>
                        <textarea id="isi_sk" class="materialize-textarea validate" name="isi_sk" required><?php echo $isi_sk; ?></textarea>
                        <?php
                        if (isset($_SESSION['isi_skk'])) {
                            $isi_skk = $_SESSION['isi_skk'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $isi_skk . '</div>';
                            unset($_SESSION['isi_skk']);
                        }
                        ?>
                        <label for="isi_sk">Isi Ringkas</label>
                    </div>
                    <div class="input-field col s12">
                        <div class="file-field input-field tooltipped" data-position="top" data-tooltip="Jika tidak ada file/scan gambar surat, biarkan kosong">
                            <div class="btn red darken-1">
                                <span>File</span>
                                <input type="file" id="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/scan gambar surat keluar">
                                <?php
                                if (isset($_SESSION['errSize'])) {
                                    $errSize = $_SESSION['errSize'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errSize . '</div>';
                                    unset($_SESSION['errSize']);
                                }
                                if (isset($_SESSION['errFormat'])) {
                                    $errFormat = $_SESSION['errFormat'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errFormat . '</div>';
                                    unset($_SESSION['errFormat']);
                                }
                                ?>
                                <small class="red-text">*Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 2 MB!</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row in form END -->

                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <a href="?page=tsk" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                    </div>
                </div>
                <br />
            </form>
            <!-- Form END -->

        </div>
        <!-- Row form END -->
        </section>
        </div>
        </div>
<?php
    }
}
?>