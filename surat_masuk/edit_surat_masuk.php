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
        <section id="content">
            <!--start container-->
            <div class="container"><br />';

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if (
            $_REQUEST['asal_sm'] == "" || $_REQUEST['no_sm'] == "" || $_REQUEST['isi_sm'] == ""
            || $_REQUEST['perihal_sm'] == "" || $_REQUEST['tgl_surat'] == ""  || $_REQUEST['pic_sm'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $asal_sm = $_REQUEST['asal_sm'];
            $no_sm = $_REQUEST['no_sm'];
            $isi_sm = $_REQUEST['isi_sm'];
            $perihal_sm = $_REQUEST['perihal_sm'];
            $tgl_surat = $_REQUEST['tgl_surat'];
            $pic_sm = $_REQUEST['pic_sm'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $asal_sm)) {
                $_SESSION['easal_sm'] = 'Form asal hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_sm)) {
                    $_SESSION['eno_sm'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi_sm)) {
                        $_SESSION['eisi_sm'] = 'Form Isi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9., -]*$/", $perihal_sm)) {
                            $_SESSION['eperihal_sm'] = 'Form perihal hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan koma(,) dan minus (-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[0-9.-]*$/", $tgl_surat)) {
                                $_SESSION['etgl_surat'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $pic_sm)) {
                                    $_SESSION['epic_sm'] = 'Form pic hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $ekstensi = array('jpg', 'png', 'jpeg', 'doc', 'docx', 'pdf');
                                    $file = $_FILES['file']['name'];
                                    $x = explode('.', $file);
                                    $eks = strtolower(end($x));
                                    $ukuran = $_FILES['file']['size'];
                                    $target_dir = "upload/surat_masuk/";

                                    //jika form file tidak kosong akan mengeksekusi script dibawah ini
                                    if ($file != "") {

                                        $rand = rand(1, 10000);
                                        $nfile = $rand . "-" . $file;

                                        //validasi file
                                        if (in_array($eks, $ekstensi) == true) {
                                            if ($ukuran < 2300000) {

                                                $id_sm = $_REQUEST['id_sm'];
                                                $query = mysqli_query($config, "SELECT file FROM tbl_surat_masuk WHERE id_sm='$id_sm'");
                                                list($file) = mysqli_fetch_array($query);

                                                //jika file tidak kosong akan mengeksekusi script dibawah ini
                                                if (!empty($file)) {
                                                    unlink($target_dir . $file);

                                                    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                                    $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET no_sm='$no_sm',perihal_sm='$perihal_sm',asal_sm='$asal_sm',isi_sm='$isi_sm',tgl_surat='$tgl_surat',pic_sm='$pic_sm',file='$nfile' WHERE id_sm='$id_sm'");

                                                    if ($query == true) {
                                                        $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                        header("Location: ./admin.php?page=tsm");
                                                        die();
                                                    } else {
                                                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                        echo '<script language="javascript">window.history.back();</script>';
                                                    }
                                                } else {

                                                    //jika file kosong akan mengeksekusi script dibawah ini
                                                    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                                    $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET asal_sm='$asal_sm',no_sm='$no_sm',isi_sm='$isi_sm',perihal_sm='$perihal_sm',tgl_surat='$tgl_surat',file='$nfile',pic_sm='$pic_sm', WHERE id_sm='$id_sm'");

                                                    if ($query == true) {
                                                        $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                                        header("Location: ./admin.php?page=tsm");
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
                                        $id_sm = $_REQUEST['id_sm'];

                                        $query = mysqli_query($config, "UPDATE tbl_surat_masuk SET asal_sm='$asal_sm',no_sm='$no_sm',isi_sm='$isi_sm',perihal_sm='$perihal_sm',tgl_surat='$tgl_surat',pic_sm='$pic_sm' WHERE id_sm='$id_sm'");

                                        if ($query == true) {
                                            $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                            header("Location: ./admin.php?page=tsm");
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
    } else {

        $id_sm = mysqli_real_escape_string($config, $_REQUEST['id_sm']);
        $query = mysqli_query($config, "SELECT id_sm, asal_sm, no_sm, isi_sm, perihal_sm, tgl_surat, file, pic_sm FROM tbl_surat_masuk WHERE id_sm='$id_sm'");
        list($id_sm, $asal_sm, $no_sm, $isi_sm, $perihal_sm, $tgl_surat, $file, $pic_sm) = mysqli_fetch_array($query);

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
                <h4 class="header">Edit Data Surat Masuk</h4>
            </ul>
        </div>
        <!-- Row form Start -->
        <div class="row jarak-form">

            <!-- Form START -->
            <form class="col s12" method="POST" action="?page=tsm&act=edit" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s12">
                        <input type="hidden" name="id_sm" value="<?php echo $id_sm; ?>">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <input id="asal_sm" type="text" class="validate" value="<?php echo $asal_sm; ?>" name="asal_sm" required>
                        <?php
                        if (isset($_SESSION['easal_sm'])) {
                            $easal_sm = $_SESSION['easal_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $easal_sm . '</div>';
                            unset($_SESSION['easal_sm']);
                        }
                        ?>
                        <label for="asal_sm">asal</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">storage</i>
                        <input id="perihal_sm" type="text" class="validate" name="perihal_sm" value="<?php echo $perihal_sm; ?>" required>
                        <?php
                        if (isset($_SESSION['eperihal_sm'])) {
                            $eperihal_sm = $_SESSION['eperihal_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eperihal_sm . '</div>';
                            unset($_SESSION['eperihal_sm']);
                        }
                        ?>
                        <label for="perihal_sm">perihal surat</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_sm" type="text" class="validate" name="no_sm" value="<?php echo $no_sm; ?>" required>
                        <?php
                        if (isset($_SESSION['eno_sm'])) {
                            $eno_sm = $_SESSION['eno_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eno_sm . '</div>';
                            unset($_SESSION['eno_sm']);
                        }
                        ?>
                        <label for="no_sm">Nomor Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_surat" type="text" name="tgl_surat" class="datepicker" value="<?php echo $tgl_surat; ?>" required>
                        <?php
                        if (isset($_SESSION['etgl_surat'])) {
                            $etgl_surat = $_SESSION['etgl_surat'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $etgl_surat . '</div>';
                            unset($_SESSION['etgl_surat']);
                        }
                        ?>
                        <label for="tgl_surat">Tanggal Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">description</i>
                        <textarea id="isi_sm" class="materialize-textarea validate" name="isi_sm" required><?php echo $isi_sm; ?></textarea>
                        <?php
                        if (isset($_SESSION['eisi_sm'])) {
                            $eisi_sm = $_SESSION['eisi_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $eisi_sm . '</div>';
                            unset($_SESSION['eisi_sm']);
                        }
                        ?>
                        <label for="isi_sm">Isi Ringkas</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">featured_play_list</i>
                        <input id="pic_sm" type="text" class="validate" name="pic_sm" value="<?php echo $pic_sm; ?>" required>
                        <?php
                        if (isset($_SESSION['epic_sm'])) {
                            $epic_sm = $_SESSION['epic_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $epic_sm . '</div>';
                            unset($_SESSION['epic_sm']);
                        }
                        ?>
                        <label for="pic_sm">pic</label>
                    </div>
                    <div class="input-field col s12">
                        <div class="file-field input-field tooltipped" data-position="top" data-tooltip="Jika tidak ada file/scan gambar surat, biarkan kosong">
                            <div class="btn red darken-1">
                                <span>File</span>
                                <input type="file" id="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" value="<?php echo $file; ?>" placeholder="Upload file/scan gambar surat masuk">
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
                            <br />
                        </div>
                    </div>
                </div>
                <!-- Row in form END -->

                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <a href="?page=tsm" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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