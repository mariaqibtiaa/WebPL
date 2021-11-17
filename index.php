<?php
ob_start();
session_start();

//cek session
if (isset($_SESSION['id_user'])) {
    header("Location: ./admin.php");
    die();
}
require('include/config.php');
?>

<!doctype html>
<html lang="en">

<!-- Head START -->

<head>

    <title>Aplikasi Manajemen Surat</title>

    <!-- Meta START -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

    <!-- Global style START -->
    <!-- Bootstrap core CSS -->
    <link href="asset/css/dashboard.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }

            #alert-message {
                border-radius: 3px;
                color: #f44336;
                font-size: 1.15rem;
                margin: 15px 15px -15px;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="asset/css/floating-labels.css" rel="stylesheet">
    <!-- Global style END -->

</head>
<!-- Head END -->

<!-- Body START -->

<body class="#e0e0e0 grey lighten-2 bg">
    <?php
    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if ($_REQUEST['username'] == "" || $_REQUEST['password'] == "") {
            echo '<div class="upss red-text"><i class="material-icons">error_outline</i> <strong>ERROR!</strong> Username dan Password wajib diisi.
                                <a class="btn-large waves-effect waves-light blue-grey col s11" href="./" style="margin: 20px 0 0 5px;"><i class="material-icons md-24">arrow_back</i> Kembali ke login form</a></div>';
        } else {

            $username = trim(htmlspecialchars(mysqli_real_escape_string($config, $_REQUEST['username'])));
            $password = trim(htmlspecialchars(mysqli_real_escape_string($config, $_REQUEST['password'])));

            $query = mysqli_query($config, "SELECT id_user, username FROM tbl_user WHERE username=BINARY'$username' AND password=MD5('$password')");

            if (mysqli_num_rows($query) > 0) {
                list($id_user, $username) = mysqli_fetch_array($query);

                session_start();

                //buat session
                $_SESSION['id_user'] = $id_user;
                $_SESSION['username'] = $username;

                header("Location: ./admin.php");
                die();
            } else {

                //session error
                $_SESSION['errLog'] = '';
                header("Location: ./");
                die();
            }
        }
    } else {
    ?>

        <!-- Form START -->
        <form class="form-signin" method="POST" action="">
            <div class="text-center mb-4">
                <img class="mb-4" src="asset/images/logo/login-logo.png" width="150">
                <h1 class="h3 mb-3 font-weight-normal">PT. Dagsap Endura Eatore</h1>
                <h3 class="h3 mb-3 font-weight-normal">Departemen HRD/GA</h3>
                <p>Silahkan masukkan username dan password<br />sebelum masuk ke dalam sistem pengarsipan surat</p>
            </div>
            <div class="row">
                <?php
                if (isset($_SESSION['errLog'])) {
                    $errLog = $_SESSION['errLog'];
                    echo "<script>
                    alert('Maaf, Login GAGAL, pastikan username dan password anda Benar..!');
                    document.location='index.php';
                  </script>";
                    unset($_SESSION['errLog']);
                }
                ?>
                <br />
            </div>
            <div class="form-label-group">
                <input type="text" id="username" name="username" class="form-control" required autocomplete="off">
                <label for="username">Username</label>
            </div>
            <div class="form-label-group">
                <input type="password" id="password" name="password" class="form-control" required autocomplete="off">
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-lg btn-danger btn-block" name="submit">Sign In</button>
            <p class="mt-5 mb-3 text-muted text-center">&copy; <?= date('Y') ?> by PT. Dagsap Endura Eatore</p>
        </form>
        <!-- Form END -->
    <?php
    }
    ?>
    </div>
    <!-- Row Form START -->


    </div>
    <!-- Col END -->

    </div>
    <!-- Row END -->

    </div>
    <!-- Container END -->

    <!-- Javascript START -->
    <script type="text/javascript" src="asset/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="asset/js/materialize.min.js"></script>
    <script type="text/javascript" src="asset/js/bootstrap.min.js"></script>
    <script data-pace-options='{ "ajax": false }' src='asset/js/pace.min.js'></script>

    <!-- Jquery auto hide untuk menampilkan pesan error -->
    <script type="text/javascript">
        $("#alert-message").alert().delay(3000).slideUp('slow');
    </script>
    <!-- Javascript END -->

    <noscript>
        <meta http-equiv="refresh" content="0;URL='./enable-javascript.html'" />
    </noscript>

</body>
<!-- Body END -->

</html>