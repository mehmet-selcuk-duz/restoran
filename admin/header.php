<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once "../system/config.php";

$user_query = "SELECT * FROM users WHERE username = :username";
$stmt = $pdo->prepare($user_query);
$stmt->execute(['username' => $_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
    
    $isAuthorized = $user['role'] == 2;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>Lezzet Sepeti - Yönetim Paneli</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer" id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
        <a class="navbar-brand" href="/admin/"><img src="img/logo.png" alt="" width="167" height="36"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="/admin/">
                        <i class="fa fa-fw fa-dashboard"></i>
                        <span class="nav-link-text">Anasayfa</span>
                    </a>
                </li>
                
                <?php if ($isAuthorized): ?>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
                        <a class="nav-link" href="users.php">
                            <i class="fa fa-fw fa-user"></i>
                            <span class="nav-link-text">Kullanıcılar</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
                        <a class="nav-link" href="companies.php">
                            <i class="fa fa-fw fa-user"></i>
                            <span class="nav-link-text">Firmalar</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
                        <a class="nav-link" href="restaurants.php">
                            <i class="fa fa-fw fa-user"></i>
                            <span class="nav-link-text">Restoranlar</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
                        <a class="nav-link" href="coupons.php">
                            <i class="fa fa-fw fa-user"></i>
                            <span class="nav-link-text">Kuponlar</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
                        <a class="nav-link" href="comments.php">
                            <i class="fa fa-fw fa-user"></i>
                            <span class="nav-link-text">Yorumlar</span>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
                    <a class="nav-link" href="foods.php">
                        <i class="fa fa-fw fa-user"></i>
                        <span class="nav-link-text">Yemekler</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="My profile">
                    <a class="nav-link" href="orders.php">
                        <i class="fa fa-fw fa-user"></i>
                        <span class="nav-link-text">Siparişler</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-fw fa-sign-out"></i>Çıkış Yap</a>
                </li>
            </ul>
        </div>
    </nav>