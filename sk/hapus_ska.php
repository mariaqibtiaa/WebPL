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

    $id_ska = mysqli_real_escape_string($config, $_REQUEST['id_ska']);
    $query = mysqli_query($config, "SELECT * FROM tbl_ska WHERE id_ska='$id_ska'");

    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {

            echo '
                <!-- Row form Start -->
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
                                    <td width="13%">Nomor Surat</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . $row['no_ska'] . '</td>
                                </tr>
                                <tr>
                                    <td width="13%">Tanggal Masuk</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . $tgl = date('d M Y ', strtotime($row['tgl_masuk'])) . '</td>
                                </tr>
				                <tr>
				                    <td width="13%">Nama</td>
				                    <td width="1%">:</td>
				                    <td width="86%">' . $row['nama_ska'] . '</td>
				                </tr>
                                    <td width="13%">NIP</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . $row['nip_ska'] . '</td>
                                </tr>
    			                <tr>
                                    <td width="13%">Departemen</td>
                                    <td width="1%">:</td>
                                    <td width="86%">' . $row['dept_ska'] . '</td>
    			                </tr>
    			            </tbody>
    			   		</table>
                        </div>
                        <div class="card-action">
        	                <a href="?page=sk&act=del&submit=yes&id_ska=' . $row['id_ska'] . '" class="btn-large deep-orange waves-effect waves-light white-text">HAPUS <i class="material-icons">delete</i></a>
        	                <a href="?page=sk" class="btn-large blue waves-effect waves-light white-text">BATAL <i class="material-icons">clear</i></a>
    	                </div>
    	            </div>
                </div>
            </div>
            <!-- Row form END -->';

            if (isset($_REQUEST['submit'])) {
                $id_ska = $_REQUEST['id_ska'];
                $query = mysqli_query($config, "DELETE FROM tbl_ska WHERE id_ska='$id_ska'");

                if ($query == true) {
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                    header("Location: ./admin.php?page=sk");
                    die();
                } else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                                    window.location.href="./admin.php?page=sk&act=del&id_ska=' . $id_ska . '";
                                  </script>';
                }
            }
        }
    }
}
