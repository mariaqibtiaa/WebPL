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
                border: table-cell;
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
                    border: table-cell;
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
                .tgh {
                    text-align: center;
                }
                .disp {
                    text-align: center;
                    margin: -.5rem 0;
                }
                #logo {
                    margin-top: 50px;
                    width: 200px;
                    height: 110px;
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

    echo '</div>
            <p class="tgh" id="lbr">AGENDA SURAT MASUK</p>
            <p class="tgh">PT. DAGSAP ENDURA EATORE</p>
            <p class="tgh">Departemen HRD & GA</p>
        <!--DataTables example-->
        <div id="table-datatables">
            <div class="row">
            <div class="col m12" id="colres">
            <table class="responsive-table">
                <thead>
                            <tr>
                            <th width="4%">No</th>
                            <th width="18%">No. Surat</th>
                            <th width="20%">Tanggal Surat</th>
                            <th width="17%">Perihal Surat</th>
                            <th width="16%">Asal Surat</th>
                            <th width="25%">Isi Ringkas
                            </tr>
                        </thead>
                        <tbody>';
    //script untuk menampilkan data
    $query = mysqli_query($config, "SELECT * FROM tbl_surat_masuk ORDER by no_sm DESC");
    if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_array($query)) {

            echo '<tr>
                            <td>' . $no++ . '</td>
                            <td>' . $row['no_sm'] . '</td>
                            <td>' . $tgl = date('d M Y ', strtotime($row['tgl_surat'])) . '</td>
                            <td>' . $row['perihal_sm'] . '</td>
                            <td>' . $row['asal_sm'] . '</td>
                            <td>' . substr($row['isi_sm'], 0, 200) . '</td>
            </tr>
        </tbody>';
        }
    }
    echo '</table><br/><br/>
        </div>
    </div>
    <!-- Row form END -->
        </div>

    </div>
    <!-- Container END -->
    </body>';
}
