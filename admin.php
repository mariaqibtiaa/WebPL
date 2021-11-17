<?php
ob_start();
//cek session
session_start();

if (empty($_SESSION['id_user'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
?>

    <!doctype html>
    <html lang="en">

    <!-- Body START -->

    <body class="bg">

        <header>
            <?php include('include/header.php'); ?>
        </header>
        <main>
            <div class="container">

                <?php
                if (isset($_REQUEST['page'])) {
                    $page = $_REQUEST['page'];
                    switch ($page) {
                        case 'tsm':
                            include "surat_masuk/transaksi_surat_masuk.php";
                            break;
                        case 'ctk':
                            include "sk/cetak_surat.php";
                            break;
                        case 'ctksm':
                            include "surat_masuk/cetak_suratm.php";
                            break;
                        case 'ctksk':
                            include "surat_keluar/cetak_suratk.php";
                            break;
                        case 'tsk':
                            include "surat_keluar/transaksi_surat_keluar.php";
                            break;
                        case 'sk':
                            include "sk/surat_keterangan.php";
                            break;
                        case 'asm':
                            include "surat_masuk/agenda_surat_masuk.php";
                            break;
                        case 'ask':
                            include "surat_keluar/agenda_surat_keluar.php";
                            break;
                        case 'sett':
                            include "pengaturan.php";
                            break;
                    }
                } else {
                ?>
                    <div id="main">
                        <div class="wrapper">
                            <!-- START CONTENT -->
                            <section id="content">
                                <!--start container-->
                                <div class="container">
                                    <h1>SELAMAT DATANG</h1>

                                    <hr class="my-4">
                                    <p>Dagsap Archive adalah program yang akan memudahkan anda dalam : <br /> 1. mengarsip surat masuk <br /> 2. mengarsip surat keluar <br /> 3. membuat surat keterangan aktif secara otomatis</p>
                                    <p>Anda dapat menggunakan menu-menu yang ada di samping, terima kasih</p>
                                    <p class="red-text">dibawah ini adalah untuk mempermudah anda mengetahui jumlah data keseluruhan yang ada di surat masuk, surat keluar dan surat keterangan aktif</p>
                                </div><br />
                                <!--card stats start-->
                                <div id="card-stats">

                                    <?php
                                    //menghitung jumlah surat masuk
                                    $count1 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_masuk"));

                                    //menghitung jumlah surat keluar
                                    $count2 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_keluar"));

                                    //menghitung jumlah surat keluar
                                    $count3 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_ska"));

                                    ?>

                                    <div class="row mt-1">
                                        <div class="col s12 m4">
                                            <div class="card gradient-45deg-indigo-light-blue">
                                                <div class="padding-4">
                                                    <div class="col s7 m7">
                                                        <i class="material-icons md-36">mail</i>
                                                        <p><?php echo $count1 ?> Jumlah Surat Masuk</p>
                                                    </div>
                                                    <div class="col s5 m5 right-align">Surat Masuk</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m4">
                                            <div class="card gradient-45deg-amber-amber">
                                                <div class="padding-4">
                                                    <div class="col s7 m7">
                                                        <i class="material-icons md-36">mail</i>
                                                        <p><?php echo $count2 ?> Jumlah Surat Keluar</p>
                                                    </div>
                                                    <div class="col s5 m5 right-align">Surat Keluar</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m4">
                                            <div class="card gradient-45deg-red-pink">
                                                <div class="padding-4">
                                                    <div class="col s7 m7">
                                                        <i class="material-icons md-36">drafts</i>
                                                        <p><?php echo $count3 ?> Jumlah SK Aktif</p>
                                                    </div>
                                                    <div class="col s5 m5 right-align">SK Aktif</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- //////////////////////////////////////////////////////////////////////////// -->
                        </div>
                        <!--end container-->
                        </section>
                        <!-- END CONTENT -->
                    </div>
                    <!-- END WRAPPER -->
            </div>
            <!-- END MAIN -->
        <?php
                }
        ?>

        </div>
        <!-- container END -->

        </main>
        <!-- Main END -->

        <!-- Include Footer START -->
        <?php include('include/footer.php'); ?>
        <!-- Include Footer END -->

    </body>
    <!-- Body END -->

    </html>

<?php
}
?>