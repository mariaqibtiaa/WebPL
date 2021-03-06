<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['sub'])) {
        $sub = $_REQUEST['sub'];
        switch ($sub) {
            case 'back':
                include "backup.php";
                break;
            case 'rest':
                include "restore.php";
                break;
            case 'usr':
                include "user.php";
                break;
        }
    } else {

        if (isset($_REQUEST['submit'])) {

            //validasi form kosong
            if (
                $_REQUEST['nama'] == "" || $_REQUEST['alamat'] == "" || $_REQUEST['supervisor'] == ""
                || $_REQUEST['website'] == ""
            ) {
                $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                header("Location: ././admin.php?page=sett");
                die();
            } else {

                $id_instansi = "1";
                $nama = $_REQUEST['nama'];
                $alamat = $_REQUEST['alamat'];
                $supervisor = $_REQUEST['supervisor'];
                $website = $_REQUEST['website'];

                //validasi input data
                if (!preg_match("/^[a-zA-Z0-9. -]*$/", $nama)) {
                    $_SESSION['namains'] = 'Form Nama Instansi hanya boleh mengandung karakter huruf, angka, spasi, titik(.) dan minus(-)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,()\/ -]*$/", $alamat)) {
                        $_SESSION['alamat'] = 'Form Alamat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {

                        if (!preg_match("/^[a-zA-Z., ]*$/", $supervisor)) {
                            $_SESSION['supervisor'] = 'Form Nama Supervisor hanya boleh mengandung karakter huruf, spasi, titik(.) dan koma(,)<br/><br/>';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            //validasi url website
                            if (!filter_var($website, FILTER_VALIDATE_URL)) {
                                $_SESSION['website'] = 'Format URL Website tidak valid';
                                header("Location: ././admin.php?page=sett");
                                die();
                            } else {

                                $ekstensi = array('png', 'jpg');
                                $logo = $_FILES['logo']['name'];
                                $x = explode('.', $logo);
                                $eks = strtolower(end($x));
                                $ukuran = $_FILES['logo']['size'];
                                $target_dir = "upload/";

                                //jika form logo tidak kosong akan mengeksekusi script dibawah ini
                                if (!empty($logo)) {

                                    $nlogo = $logo;
                                    //validasi gambar
                                    if (in_array($eks, $ekstensi) == true) {
                                        if ($ukuran < 2000000) {

                                            $query = mysqli_query($config, "SELECT logo FROM tbl_instansi");
                                            list($logo) = mysqli_fetch_array($query);

                                            unlink($target_dir . $logo);

                                            move_uploaded_file($_FILES['logo']['tmp_name'], $target_dir . $nlogo);

                                            $query = mysqli_query($config, "UPDATE tbl_instansi SET nama='$nama',alamat='$alamat',supervisor='$supervisor',website='$website',logo='$nlogo' WHERE id_instansi='$id_instansi'");

                                            if ($query == true) {
                                                $succEdit = $_SESSION['succEdit'];
                                                echo "<script>
                                                alert('SUKSES, Data Berhasil Di Update!');
                                                document.location='././admin.php?page=sett';
                                                    </script>";
                                                die();
                                            } else {
                                                $errQ = $_SESSION['errQ'];
                                                echo "<script>
                                                alert('ERROR! Ada masalah dengan query');
                                                document.location='././admin.php?page=sett';
                                                    </script>";
                                            }
                                        } else {
                                            $errSize = $_SESSION['errSize'];
                                            echo "<script>
                                            alert('Ukuran file yang diupload terlalu besar!');
                                            document.location='././admin.php?page=sett';
                                                </script>";
                                        }
                                    } else {
                                        $errSize = $_SESSION['errSize'];
                                        echo "<script>
                                        alert('Format file gambar yang diperbolehkan hanya *.JPG dan *.PNG!');
                                        document.location='././admin.php?page=sett';
                                            </script>";
                                    }
                                } else {

                                    //jika form logo kosong akan mengeksekusi script dibawah ini
                                    $query = mysqli_query($config, "UPDATE tbl_instansi SET nama='$nama',alamat='$alamat',supervisor='$supervisor',website='$website' WHERE id_instansi='$id_instansi'");

                                    if ($query == true) {
                                        $succEdit = $_SESSION['succEdit'];
                                        echo "<script>
                                        alert('SUKSES, Data Berhasil Di Update!');
                                        document.location='././admin.php?page=sett';
                                            </script>";
                                        die();
                                    } else {
                                        $errQ = $_SESSION['errQ'];
                                        echo "<script>
                                        alert('ERROR! Ada masalah dengan query');
                                        document.location='././admin.php?page=sett';
                                            </script>";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {

            $query = mysqli_query($config, "SELECT * FROM tbl_instansi");
            if (mysqli_num_rows($query) > 0) {
                $no = 1;
                while ($row = mysqli_fetch_array($query)) { ?>

                    <?php
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
                    ?>
                    <div id="main">
                        <div class="wrapper">
                            <!-- START CONTENT -->
                            <section id="content">
                                <!--start container-->
                                <div class="container">
                                    <!-- Row form Start -->
                                    <br />
                                    <div class="row jarak-form">

                                        <!-- Form START -->
                                        <form class="col s12" method="post" action="?page=sett" enctype="multipart/form-data">

                                            <!-- Row in form START -->
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input type="hidden" value="<?php echo $id_instansi; ?>" name="id_instansi">
                                                    <i class="material-icons prefix md-prefix">school</i>
                                                    <input id="nama" type="text" class="validate" name="nama" value="<?php echo $row['nama']; ?>" required>
                                                    <?php
                                                    if (isset($_SESSION['namains'])) {
                                                        $namains = $_SESSION['namains'];
                                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $namains . '</div>';
                                                        unset($_SESSION['namains']);
                                                    }
                                                    ?>
                                                    <label for="nama">Nama Instansi</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <i class="material-icons prefix md-prefix">account_box</i>
                                                    <input id="supervisor" type="text" class="validate" name="supervisor" value="<?php echo $row['supervisor']; ?>" required>
                                                    <?php
                                                    if (isset($_SESSION['supervisor'])) {
                                                        $supervisor = $_SESSION['supervisor'];
                                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $supervisor . '</div>';
                                                        unset($_SESSION['supervisor']);
                                                    }
                                                    ?>
                                                    <label for="supervisor">Nama Supervisor</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <i class="material-icons prefix md-prefix">place</i>
                                                    <input id="alamat" type="text" class="validate" name="alamat" value="<?php echo $row['alamat']; ?>" required>
                                                    <?php
                                                    if (isset($_SESSION['alamat'])) {
                                                        $alamat = $_SESSION['alamat'];
                                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $alamat . '</div>';
                                                        unset($_SESSION['alamat']);
                                                    }
                                                    ?>
                                                    <label for="alamat">Alamat</label>
                                                </div>
                                                <div class="input-field col s12">
                                                    <i class="material-icons prefix md-prefix">language</i>
                                                    <input id="website" type="url" class="validate" name="website" value="<?php echo $row['website']; ?>" required>
                                                    <?php
                                                    if (isset($_SESSION['website'])) {
                                                        $website = $_SESSION['website'];
                                                        echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $website . '</div>';
                                                        unset($_SESSION['website']);
                                                    }
                                                    ?>
                                                    <label for="website">Website</label>
                                                </div>
                                                <div class="input-field col s12 tooltipped" data-position="top" data-tooltip="Jika tidak ada logo, biarkan kosong">
                                                    <div class="file-field input-field">
                                                        <div class="btn red darken-1">
                                                            <span>File</span>
                                                            <input type="file" id="logo" name="logo">
                                                        </div>
                                                        <div class="file-path-wrapper">
                                                            <input class="file-path validate" type="text" placeholder="Upload Logo instansi">
                                                        </div>
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
                                                        <small class="red-text">*Format file yang diperbolehkan hanya *.JPG, *.PNG dan ukuran maksimal file 2 MB. Disarankan gambar berbentuk kotak atau lingkaran!</small>
                                                    </div>
                                                </div>
                                                <div class="input-field col s12 center">
                                                    <img class="logo" src="upload/<?php echo $row['logo']; ?>" />
                                                </div>
                                            </div>
                                            <!-- Row in form END -->

                                            <div class="row">
                                                <div class="col 6">
                                                    <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                                </div>
                                                <div class="col 6">
                                                    <a href="./admin.php" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
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
        }
    }
}
?>