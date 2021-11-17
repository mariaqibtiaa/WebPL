<?php
//cek session
if (!empty($_SESSION['id_user'])) {
?>
    <?php require('include/config.php'); ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
        <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
        <title>Dagsap Archive</title>
        <!-- Favicons-->
        <link rel="icon" href="asset/images/logo/logo.png" sizes="32x32">
        <!-- Favicons-->
        <link rel="apple-touch-icon-precomposed" href="asset/images/favicon/apple-touch-icon-152x152.png">
        <!-- For iPhone -->
        <meta name="msapplication-TileColor" content="#00bcd4">
        <meta name="msapplication-TileImage" content="asset/images/favicon/mstile-144x144.png">
        <!-- For Windows Phone -->
        <!-- CORE CSS-->
        <link href="asset/css//materialize.css" type="text/css" rel="stylesheet">
        <link href="asset/css//style.css" type="text/css" rel="stylesheet">
        <!-- Custome CSS-->
        <link href="asset/css/custom/custom.css" type="text/css" rel="stylesheet">
        <link href="asset/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">

        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
        <link href="asset/vendors/prism/prism.css" type="text/css" rel="stylesheet">
        <link href="asset/vendors/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">
        <link href="asset/vendors/flag-icon/css/flag-icon.min.css" type="text/css" rel="stylesheet">
        <link href="asset/js/materialize-plugin/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    </head>

    <body>
        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START HEADER -->
        <header id="header" class="page-topbar">
            <!-- start header nav-->
            <div class="navbar-fixed">
                <nav class="navbar-color #b71c1c red darken-4">
                    <div class="nav-wrapper">
                        <ul class="left">
                            <li>
                                <h1 class="logo-wrapper">
                                    <a>
                                        <span class="logo-text" style="margin-left: 50px;">HRD - PT. Dagsap Endura Eatore</span>
                                    </a>
                                </h1>
                            </li>
                        </ul>
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                                    <span class="avatar-status avatar-online">
                                        <img src="asset/images/avatar/avatar-13.png" alt="avatar">
                                        <i></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- profile-dropdown -->
                        <ul id="profile-dropdown" class="dropdown-content">
                            <li>
                                <a href="?page=sett" class="grey-text text-darken-1">
                                    <i class="material-icons">settings</i> Instansi</a>
                            </li>
                            <li>
                                <a href="logout.php" class="grey-text text-darken-1">
                                    <i class="material-icons">keyboard_tab</i> Logout</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- end header nav-->
        </header>
        <!-- END HEADER -->
        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START MAIN -->
        <div id="main">
            <!-- START WRAPPER -->
            <div class="wrapper">
                <!-- START LEFT SIDEBAR NAV-->
                <aside id="left-sidebar-nav">
                    <ul id="slide-out" class="side-nav fixed leftside-navigation">
                        <li class="user-details cyan darken-2">
                            <div class="row">
                                <div class="col col s4 m4 l4">
                                    <img src="asset/images/avatar/avatar-13.png" alt="" class="circle responsive-img valign profile-image cyan">
                                </div>
                                <div class="col col s8 m8 l8">
                                    <span class="user-roal">HRD-DEE</span>
                                </div>
                            </div>
                        </li>
                        <li class="no-padding">
                            <ul class="collapsible" data-collapsible="accordion">
                                <li class="bold">
                                    <a href="admin.php" class="waves-effect waves-red">
                                        <i class="material-icons">dashboard</i>
                                        <span class="nav-text">Dashboard</span>
                                    </a>
                                </li>
                                <li class="bold">
                                    <a href="?page=sk" class="waves-effect waves-red">
                                        <i class="material-icons">drafts</i>
                                        <span class="nav-text">Surat Keterangan Aktif</span>
                                    </a>
                                </li>
                                <li class="bold">
                                    <a href="?page=tsm" class="waves-effect waves-red">
                                        <i class="material-icons">mail_outline</i>
                                        <span class="nav-text">Surat Masuk</span>
                                    </a>
                                </li>
                                <li class="bold">
                                    <a href="?page=tsk" class="waves-effect waves-red">
                                        <i class="material-icons">drafts</i>
                                        <span class="nav-text">Surat Keluar</span>
                                    </a>
                                </li>
                                <li class="bold">
                                    <a href="?page=sett" class="waves-effect waves-red">
                                        <i class="material-icons">settings</i> Instansi</a>
                                </li>
                                <li class="bold">
                                    <a href="logout.php" class="waves-effect waves-red">
                                        <i class="material-icons">keyboard_tab</i> Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only">
                        <i class="material-icons">menu</i>
                    </a>
                </aside>
                <!-- END LEFT SIDEBAR NAV-->
            <?php
        } else {
            header("Location: ../");
            die();
        }
            ?>