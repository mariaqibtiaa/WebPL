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
            $_REQUEST['no_sm'] == "" || $_REQUEST['kepada_sm'] == "" || $_REQUEST['isi_sm'] == ""
            || $_REQUEST['kategori_sm'] == "" || $_REQUEST['tgl_surat'] == ""  || $_REQUEST['pic_sm'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">window.history.back();</script>';
        } else {

            $no_sm = $_REQUEST['no_sm'];
            $kepada_sm = $_REQUEST['kepada_sm'];
            $isi_sm = $_REQUEST['isi_sm'];
            $kategori_sm = $_REQUEST['kategori_sm'];
            $tgl_surat = $_REQUEST['tgl_surat'];
            $pic_sm = $_REQUEST['pic_sm'];

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_sm)) {
                $_SESSION['no_sm'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {

                if (!preg_match("/^[a-zA-Z0-9.,() \/ -]*$/", $kepada_sm)) {
                    $_SESSION['kepada_sm'] = 'Form kepada hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-),kurung() dan garis miring(/)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,_()%&@\/\r\n -]*$/", $isi_sm)) {
                        $_SESSION['isi_sm'] = 'Form Isi Ringkas hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), kurung(), underscore(_), dan(&) persen(%) dan at(@)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z0-9., -]*$/", $kategori_sm)) {
                            $_SESSION['kategori_sm'] = 'Form kategori hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan koma(,) dan minus (-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[0-9.-]*$/", $tgl_surat)) {
                                $_SESSION['tgl_surat'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {

                                if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $pic_sm)) {
                                    $_SESSION['pic_sm'] = 'Form pic hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                    echo '<script language="javascript">window.history.back();</script>';
                                } else {

                                    $cek = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE no_sm='$no_sm'");
                                    $result = mysqli_num_rows($cek);

                                    if ($result > 0) {
                                        $_SESSION['errDup'] = 'Nomor Surat sudah terpakai, gunakan yang lain!';
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
                                                if ($ukuran < 2500000) {

                                                    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $nfile);

                                                    $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_sm,kepada_sm,isi_sm,kategori_sm,tgl_surat,
                                                                    file,pic_sm)
                                                                        VALUES('$no_sm','$kepada_sm','$isi_sm','$kategori_sm','$tgl_surat','$nfile','$pic_sm')");

                                                    if ($query == true) {
                                                        $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
                                                        header("Location: ./admin.php?page=tsm");
                                                        die();
                                                    } else {
                                                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                                        echo '<script language="javascript">window.history.back();</script>';
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
                                            $query = mysqli_query($config, "INSERT INTO tbl_surat_masuk(no_sm,kepada_sm,isi_sm,kategori_sm,tgl_surat, file,pic_sm)
                                                            VALUES('$no_sm','$kepada_sm','$isi_sm','$kategori_sm','$tgl_surat','','$pic_sm')");

                                            if ($query == true) {
                                                $_SESSION['succAdd'] = 'SUKSES! Data berhasil ditambahkan';
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
        }
    } else { ?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper #b71c1c red darken-4">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="?page=tsm&act=add" class="judul"><i class="material-icons">mail</i> Tambah Data Surat Masuk</a></li>
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
            <form class="col s12" method="POST" action="?page=tsm&act=add" enctype="multipart/form-data">

                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">looks_two</i>
                        <input id="no_sm" type="text" class="validate" name="no_sm" required>
                        <?php
                        if (isset($_SESSION['no_sm'])) {
                            $no_sm = $_SESSION['no_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_sm . '</div>';
                            unset($_SESSION['no_sm']);
                        }
                        if (isset($_SESSION['errDup'])) {
                            $errDup = $_SESSION['errDup'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                            unset($_SESSION['errDup']);
                        }
                        ?>
                        <label for="no_sm">Nomor Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">date_range</i>
                        <input id="tgl_surat" type="text" name="tgl_surat" class="datepicker" required>
                        <?php
                        if (isset($_SESSION['tgl_surat'])) {
                            $tgl_surat = $_SESSION['tgl_surat'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_surat . '</div>';
                            unset($_SESSION['tgl_surat']);
                        }
                        ?>
                        <label for="tgl_surat">Tanggal Surat</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">storage</i>
                        <input id="kategori_sm" type="text" class="validate" name="kategori_sm" required>
                        <?php
                        if (isset($_SESSION['kategori_sm'])) {
                            $kategori_sm = $_SESSION['kategori_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kategori_sm . '</div>';
                            unset($_SESSION['kategori_sm']);
                        }
                        ?>
                        <label for="kategori_sm">kategori Berkas</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">place</i>
                        <input id="kepada_sm" type="text" class="validate" name="kepada_sm" required>
                        <?php
                        if (isset($_SESSION['kepada_sm'])) {
                            $kepada_sm = $_SESSION['kepada_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $kepada_sm . '</div>';
                            unset($_SESSION['kepada_sm']);
                        }
                        ?>
                        <label for="kepada_sm">kepada</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">featured_play_list</i>
                        <input id="pic_sm" type="text" class="validate" name="pic_sm" required>
                        <?php
                        if (isset($_SESSION['pic_sm'])) {
                            $pic_sm = $_SESSION['pic_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $pic_sm . '</div>';
                            unset($_SESSION['pic_sm']);
                        }
                        ?>
                        <label for="pic_sm">pic</label>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix md-prefix">description</i>
                        <textarea id="isi_sm" class="materialize-textarea validate" name="isi_sm" required></textarea>
                        <?php
                        if (isset($_SESSION['isi_sm'])) {
                            $isi_sm = $_SESSION['isi_sm'];
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $isi_sm . '</div>';
                            unset($_SESSION['isi_sm']);
                        }
                        ?>
                        <label for="isi_sm">Isi Ringkas</label>
                    </div>
                    <div class="input-field col s12">
                        <div class="file-field input-field tooltipped" data-position="top" data-tooltip="Jika tidak ada file/scan gambar surat, biarkan kosong">
                            <div class="btn red darken-1">
                                <span>File</span>
                                <input type="file" id="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Upload file/scan gambar surat masuk">
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
                        <a href="?page=tsm" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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