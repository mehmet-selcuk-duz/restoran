<?php
session_start();

require_once "system/config.php";

if (isset($_SESSION['username'])) {
$user_query = "SELECT * FROM users WHERE username = :username";
$stmt = $pdo->prepare($user_query);
$stmt->execute(['username' => $_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$company_id = $user['company_id'];

if ($company_id) {
    $company_query = "SELECT name FROM company WHERE id = :company_id";
    $stmt = $pdo->prepare($company_query);
    $stmt->execute(['company_id' => $company_id]);
    $company = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($company) {
        $company_name = $company['name'];
    } else {
        $company_name = "Şirket bulunamadı";
    }
} else {
    $company_name = "Şirket bilgisi yok";
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Lezzet Sepeti - Kaliteli teslimat veya paket yemek">
    <meta name="author" content="Ansonika">
    <title>Lezzet Sepeti - Kaliteli teslimat veya paket yemek</title>

    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">
<style>
    .gps-button {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #007bff;
        font-size: 1.2rem;
    }
    .gps-button:hover {
        color: #0056b3;
    }
</style>
</head>

<body>
                
    <header class="header black_nav clearfix element_to_stick">
        <div class="container">
            <div id="logo">
                <a href="/">
                    <img src="img/logo.png" width="162" height="40" alt="">
                </a>
            </div>
            <div class="layer"></div>
            <ul id="top_menu">
            <?php
            if (!isset($_SESSION['username'])) {
            ?>
                <li><a href="#sign-in-dialog" class="login">Sign In</a></li>
            <?php
            }else{
            ?>
                <li><a href="/account.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                    </svg>
                </a></li>
            <?php
            }
            ?>
                <li><a href="/cart.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                    </svg>
                </a></li>
            </ul>
        </div>
    </header>