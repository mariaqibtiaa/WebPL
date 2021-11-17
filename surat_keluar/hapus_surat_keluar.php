<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_SESSION['errQ'])) {
        $errQ = $_SESSION['errQ'];
        echo '<div id="alert-message" class="row jarak-card">
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

    $id_sk = mysqli_real_escape_string($config, $_REQUEST['id_sk']);
    $query = mysqli_query($config, "SELECT * FROM tbl_surat_keluar WHERE id_sk='$id_sk'");

    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {

            echo '<!-- Row form Start -->
            <div id="main">
                <div class="wrapper">
            <!-- START CONTENT -->
                    <section id="content"><br/>
                <!--start container-->
                        <div class="container">
				<div class="row jarak-card">
				    <div class="col m12">
                        <div class="card">
                            <div class="card-content">
        				        <table>
        				            <thead class="red lighten-5 red-text">
        				                <div class="confir red-text"><i class="material-icons md-36">error_outline</i>
        				                Apakah Anda yakin akan menghapus data ini?</div>
        				            </thead>

        				            <tbody>
        				                <tr>
                                            <td width="13%">No. Surat</td>
                                            <td width="1%">:</td>
                                            <td width="86%">' . $row['no_sk'] . '</td>
                                        </tr>
                                        <tr>
                                            <td width="13%">Tanggal Surat</td>
                                            <td width="1%">:</td>
                                            <td width="86%">' . $tgl = date('d M Y ', strtotime($row['tgl_surat'])) . '</td>
                                        </tr>
        				                <tr>
        				                    <td width="13%">Isi Ringkas</td>
        				                    <td width="1%">:</td>
        				                    <td width="86%">' . $row['isi_sk'] . '</td>
        				                </tr>
        				                <tr>
        				                    <td width="13%">File</td>
        				                    <td width="1%">:</td>
                                            <td width="86%">';
            if (!empty($row['file'])) {
                echo ' <a class="blue-text" href="?page=gsk&act=fsk&id_sk=' . $row['id_sk'] . '">' . $row['file'] . '</a>';
            } else {
                echo ' Tidak ada file yang diupload';
            }
            echo '</td>
                                        </tr>
        				                <tr>
                                            <td width="13%">Kepada</td>
                                            <td width="1%">:</td>
                                            <td width="86%">' . $row['kepada_sk'] . '</td>
                                        </tr>
                                        <tr>
                                            <td width="13%">pic</td>
                                            <td width="1%">:</td>
                                            <td width="86%">' . $row['pic_sk'] . '</td>
                                        </tr>
        				            </tbody>
    				   		    </table>
				            </div>
                            <div class="card-action">
        		                <a href="?page=tsk&act=del&submit=yes&id_sk=' . $row['id_sk'] . '" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        		                <a href="?page=tsk" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <br/>
            </section>
            </div>
            </div>
                <!-- Row form END -->';

            if (isset($_REQUEST['submit'])) {
                $id_sk = $_REQUEST['id_sk'];

                //jika ada file akan mengekseskusi script dibawah ini
                if (!empty($row['file'])) {

                    unlink("upload/surat_keluar/" . $row['file']);
                    $query = mysqli_query($config, "DELETE FROM tbl_surat_keluar WHERE id_sk='$id_sk'");

                    if ($query == true) {
                        $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                        header("Location: ./admin.php?page=tsk");
                        die();
                    } else {
                        $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                        echo '<script language="javascript">
                                    window.location.href="./admin.php?page=tsk&act=del&id_sk=' . $id_sk . '";
                                  </script>';
                    }
                } else {

                    //jika tidak ada file akan mengekseskusi script dibawah ini
                    $query = mysqli_query($config, "DELETE FROM tbl_surat_keluar WHERE id_sk='$id_sk'");

                    if ($query == true) {
                        $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus';
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
