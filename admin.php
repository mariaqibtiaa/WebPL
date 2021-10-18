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

    <!-- Include Head START -->
    <?php include('include/head.php'); ?>
    <!-- Include Head END -->

    <!-- Body START -->

    <body class="bg">

        <!-- Header START -->
        <header>

            <!-- Include Navigation START -->
            <?php include('include/menu.php'); ?>
            <!-- Include Navigation END -->

        </header>
        <!-- Header END -->

        <!-- Main START -->
        <main>

            <!-- container START -->
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
                    <!-- Row START -->
                    <div class="row">
                        <div class="container">
                            <h1>Selamat Datang</h1>

                            <hr class="my-4">
                            <p class="lead">DagsapArchive adalah program yang akan memudahkan anda dalam mengarsip surat masuk dan surat keluar</p>
                            <p>Anda dapat menggunakan menu-menu yang ada di atas, terima kasih</p>
                        </div><br />
                        <!-- Welcome Message END -->

                        <?php


                        //menghitung jumlah surat masuk
                        $count1 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_masuk"));

                        //menghitung jumlah surat keluar
                        $count2 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_ska"));

                        //menghitung jumlah surat keluar
                        $count3 = mysqli_num_rows(mysqli_query($config, "SELECT * FROM tbl_surat_keluar"));


                        ?>

                        <!-- Info Statistic START -->
                        <div class="col s6">
                            <div class="card">
                                <div class="card-content center">
                                    <span class="card-title black-text"><i class="material-icons md-36">mail</i> Jumlah Surat Masuk</span>
                                    <?php echo '<h5 class="black-text link">' . $count1 . ' Surat Masuk</h5>'; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="card">
                                <div class="card-content center">
                                    <span class="card-title black-text"><i class="material-icons md-36">email</i> Jumlah Surat Keterangan Aktif</span>
                                    <?php echo '<h5 class="black-text link">' . $count2 . ' Surat Keterangan Aktif</h5>'; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col s6 m12">
                            <div class="card">
                                <div class="card-content center">
                                    <span class="card-title black-text"><i class="material-icons md-36">drafts</i> Jumlah Surat Keluar</span>
                                    <?php echo '<h5 class="black-text link">' . $count3 . ' Surat Keluar</h5>'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row END -->
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