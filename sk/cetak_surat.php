<?php
//cek session
if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header("Location: ./");
    die();
} else {

    echo '
        <style type="text/css">
            header,
            #non-printable {
                display: none !important;
            }
            #printable {
                display: block;
            }
            footer,
            #non-printable {
                display: none !important;
            }
            #printable {
                display: block;
            }
            table {
                background: #fff;
                padding: 5px;
            }
            tr,td {
                vertical-align: top!important;
                text-align: justify;
                font-size: 12pt;
            }
            
            .isi {
                height: 300px!important;
            }
            .disp {
                text-align: center;
                padding: 1.5rem 0;
                margin-bottom: .5rem;
            }
            #lead {
                width: auto;
                position: relative;
                margin: 0 0 0 15px;
            }
            .lead {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: -10px;
            }
            .leading {
                font-weight: bold;                
                margin-bottom: -10px;
            }
            .tgh {
                text-align: center;
            }
            #logo {
                margin-top: 1rem;
                margin-bottom: -1rem;
                width: 128.64px;
                height: 73.92px;
            }
            #lbr {
                font-size: 16pt;
                font-weight: bold;
            }
            #lbr spam.nosurat {
                font-size: 11pt;
                font-weight: 300;
            }
            table.bordered tr{
                border-bottom: 0;
            }

            @page {
                size: A4;
                margin: 0;
              }

            @media print{
                body {
                    font-size: 12pt;
                    color: #212121;
                    margin-left: 50px;
                    margin-right: 50px;
                }
                #printable {
                    display: block;
                }
                table {
                    width: 100%;
                    font-size: 12px;
                    color: #212121;
                }
                tr, td {
                    border: none !important;
                    padding: 8px!important;
                    text-align: justify;
                    font-size: 12pt;
                }
                tr,td {
                    vertical-align: top!important;
                }
                #lbr {
                    font-size: 16pt;
                }
                #lbr spam.nosurat{
                    font-size: 11pt;
                    font-weight: 300;
                }
                .tgh {
                    text-align: center;
                }
                .disp {
                    text-align: center;
                    margin: -.5rem 0;
                }
                #lead {
                    width: auto;
                    position: relative;
                    margin: 0 0 0 10px;
                }
                .lead {
                    font-weight: bold;
                    text-decoration: underline;
                    margin-bottom: -10px;
                    font-size: 12pt;
                }   
                .leading {
                    font-weight: bold;
                    font-size: 12pt;
                }
                #logo {
                    margin-top: 50px;
                    width: 200px;
                    height: 110px;
                }
                #alamat {
                    margin-top: -15px;
                    font-size: 13px;
                }
            }
        </style>

        <body onload="window.print()">
        <!-- Container START -->
        <div class="container">
                <div class="disp">';
    $query2 = mysqli_query($config, "SELECT logo FROM tbl_instansi");
    list($logo) = mysqli_fetch_array($query2);
    if (!empty($logo)) {
        echo '<img id="logo" src="./upload/' . $logo . '"/>';
    } else {
        echo '<img id="logo" src="./asset/img/logo.png"/>';
    }

    echo '</div>';

    $id_ska = mysqli_real_escape_string($config, $_REQUEST['id_ska']);
    $query = mysqli_query($config, "SELECT * FROM tbl_ska WHERE id_ska='$id_ska'");

    if (mysqli_num_rows($query) > 0) {
        $no = 0;
        while ($row = mysqli_fetch_array($query)) {

            echo '
                    <table class="bordered" id="tbl">
                        <tbody>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="tgh" id="lbr" colspan="3">SURAT KETERANGAN<br>
                                    <spam class="nosurat">Nomor: ' . $row['no_ska'] . '</spam><br>&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Dengan ini kami menerangkan :<br>&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td width="13%">Nama</td>
                                <td width="10">:</td>
                                <td >' . $row['nama_ska'] . '</td>
                            </tr>';
            $y = substr($row['tgl_masuk'], 0, 4);
            $m = substr($row['tgl_masuk'], 5, 2);
            $d = substr($row['tgl_masuk'], 8, 2);

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
                            <tr>
                                <td width="13%">NIP</td>
                                <td width="10">:</td>
                                <td >' . $row['nip_ska'] . '</td>
                                
                            </tr>
                            <tr>
                                <td width="13%">Departemen</td>
                                <td width="10">:</td>
                                <td >' . $row['dept_ska'] . '</td>
                                
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">Adalah benar karyawan di PT Dagsap Endura Eatore sejak tanggal ' . $d . " " . $nm . " " . $y . ' dan sampai saat ini masih aktif. Surat ini juga menerangkan bahwa yang bersangkutan berlokasi kerja di Kawasan Industri Sentul Jl. Cahaya Raya Kav. H-3 Kabupaten Bogor.
                                </td>
                            </tr>
                            <tr>
                            <td colspan="3">Demikian surat keterangan ini kami buat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.
                            </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Bogor, ' . $tgl = date('d M Y ', strtotime($row['tgl_buat'])) . '
                                </td>
                            </tr>
                            ';
        }
        echo '
                </tbody>
            </table>
            <div id="lead">
                <p>Hormat Kami,</p>
                <div style="height: 50px;"></div>';
        $query = mysqli_query($config, "SELECT supervisor FROM tbl_instansi");
        list($supervisor) = mysqli_fetch_array($query);
        if (!empty($supervisor)) {
            echo '
                <p class="lead">' . $supervisor . '</p>
                <p class="leading">Supervisor HRD&GA</p>';
        } else {
            echo '
                <p class="lead">Della Fenlies</p>
                <p class="leading">Supervisor HRD&GA</p>';
        }
        echo '
            </div>
    </div>
    <!-- Container END -->
    </body>';
    }
}
