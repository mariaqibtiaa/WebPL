<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header("Location: ./");
    die();
} else {

    echo '
        <style type="text/css">
            table {
                background: #fff;
                padding: 5px;
            }
            tr,td {
                vertical-align: top!important;
            }
            #right {
                border-right: none !important;
            }
            #left {
                border-left: none !important;
            }
            .isi {
                height: 300px!important;
            }
            .disp {
                text-align: center;
                padding: 1.5rem 0;
                margin-bottom: .5rem;
            }
            .logodisp {
                float: left;
                position: relative;
                width: 75px;
                height: 75px;
                margin: 0 0 0 1rem;
            }
            #lead {
                width: auto;
                position: relative;
                margin: 25px 0 0 75%;
            }
            .lead {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: -10px;
            }
            .tgh {
                text-align: center;
                text-decoration: underline;
            }
            #nama {
                font-size: 2.1rem;
                margin-bottom: -1rem;
            }
            #alamat {
                font-size: 16px;
            }
            .up {
                text-transform: uppercase;
                margin: 0;
                line-height: 2.2rem;
                font-size: 1.5rem;
            }
            #lbr {
                font-size: 20px;
                font-weight: bold;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: -1.3rem 0 1.5rem;
            }
            @media print{
                body {
                    font-size: 12px;
                    color: #212121;
                }
                table {
                    width: 100%;
                    font-size: 12px;
                    color: #212121;
                }
                tr, td {
                    border: table-cell;
                    border: 1px  solid #444;
                    padding: 8px!important;

                }
                tr,td {
                    vertical-align: top!important;
                }
                #lbr {
                    font-size: 20px;
                }
                .isi {
                    height: 200px!important;
                }
                .tgh {
                    text-align: center;
                    text-decoration: underline;
                }
                .disp {
                    text-align: center;
                    margin: -.5rem 0;
                }
                .logodisp {
                    float: left;
                    position: relative;
                    width: 30px;
                    height: 30px;
                    margin: .5rem 0 0 .5rem;
                }
                #lead {
                    width: auto;
                    position: relative;
                    margin: 15px 0 0 75%;
                }
                .lead {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-bottom: -10px;
                }
                #nama {
                    font-size: 20px!important;
                    font-weight: bold;
                    text-transform: uppercase;
                    margin: -10px 0 -20px 0;
                }
                .up {
                    font-size: 17px!important;
                    font-weight: normal;
                }
                #alamat {
                    margin-top: -15px;
                    font-size: 13px;
                }
                #lbr {
                    font-size: 17px;
                    font-weight: bold;
                }
                .separator {
                    border-bottom: 2px solid #616161;
                    margin: -1rem 0 1rem;
                }

            }
        </style>

        <body onload="window.print()">

        <!-- Container START -->
        <div class="container">
            <div id="colres">
                <div class="disp">';
    $query2 = mysqli_query($config, "SELECT nama, alamat, logo FROM tbl_instansi");
    list($nama, $alamat, $logo) = mysqli_fetch_array($query2);
    if (!empty($logo)) {
        echo '<img class="up" id="nama" src="./upload/' . $logo . '"/>';
    } else {
        echo '<img class="up" id="nama" src="./asset/img/logo.png"/>';
    }
    if (!empty($kepsek)) {
        echo '<p class="tgh" id="lbr" colspan="5">' . $kepsek . '';
    } else {
        echo '<h1 class="tgh" id="lbr" colspan="5">SURAT KETERANGAN</h1>';
    }


    $id_surat = mysqli_real_escape_string($config, $_REQUEST['id_surat']);
    $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk WHERE id_surat='$id_surat'");

    if (mysqli_num_rows($query) > 0) {
        $no = 0;
        while ($row = mysqli_fetch_array($query)) {

            echo '<p id="right" width="18%"><strong>Dengan ini Kami menerangkan : </strong>
            <p id="left" style="border-right: none;" width="57%">: ' . $row['indeks'] . '
                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>
                                <td id="right" width="18%"><strong>Indeks Berkas</strong></td>
                                <td id="left" style="border-right: none;" width="57%">: ' . $row['indeks'] . '</td>
                                <td id="left" width="25"><strong>Kode</strong> : ' . $row['kode'] . '</td>
                            </tr>
                            <tr>';

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

                                <td id="right"><strong>Tanggal Surat</strong></td>
                                <td id="left" colspan="2">: ' . $d . " " . $nm . " " . $y . '</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Nomor Surat</strong></td>
                                <td id="left" colspan="2">: ' . $row['no_surat'] . '</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Asal Surat</strong></td>
                                <td id="left" colspan="2">: ' . $row['asal_surat'] . '</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Isi Ringkas</strong></td>
                                <td id="left" colspan="2">: ' . $row['isi'] . '</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Diterima Tanggal</strong></td>
                                <td id="left" style="border-right: none;">: ' . $d . " " . $nm . " " . $y . '</td>
                                <td id="left"><strong>No. Agenda</strong> : ' . $row['no_agenda'] . '</td>
                            </tr>
                            <tr>
                                <td id="right"><strong>Tanggal Penyelesaian</strong></td>
                                <td id="left" colspan="2">: </td>
                            </tr>';
        }
        echo '
                </tbody>
            </table>
            <div id="lead">
                <p>Kepala Sekolah</p>
                <div style="height: 50px;"></div>';
        $query = mysqli_query($config, "SELECT kepsek FROM tbl_instansi");
        list($kepsek) = mysqli_fetch_array($query);
        if (!empty($kepsek)) {
            echo '<p class="lead">' . $kepsek . '</p>';
        } else {
            echo '<p class="lead">H. Riza Fachri, S.Kom.</p>';
        }
        echo '
            </div>
        </div>
        <div class="jarak2"></div>
    </div>
    <!-- Container END -->

    </body>';
    }
}
