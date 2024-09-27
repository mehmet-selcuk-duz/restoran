<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Ansonika">
    <title>LezzetSepeti - Kayıt Ol</title>

    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">

    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="css/order-sign_up.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">
    
</head>

<body id="register_bg">
	
	<div id="register">
		<aside>
			<figure>
				<a href="index.html"><img src="img/logo.png" width="140" height="35" alt=""></a>
			</figure>
			<form id="kayit" method="post" action="system/function.php">
				<div class="form-group">
					<input class="form-control" type="text" name="username" placeholder="Kullanıcı Adı">
					<i class="icon_pencil-edit"></i>
				</div>
				<div class="form-group">
					<input class="form-control" type="text" name="name" placeholder="Ad">
					<i class="icon_pencil-edit"></i>
				</div>
				<div class="form-group">
					<input class="form-control" type="text" name="surname" placeholder="Soyad">
					<i class="icon_pencil-edit"></i>
				</div>
				<div class="form-group">
					<input class="form-control" type="password" name="password" placeholder="Şifre">
					<i class="icon_lock_alt"></i>
				</div>
				<div id="pass-info" class="clearfix"></div>
                <input type="hidden" name="islem" value="register">
				<a href="#" onclick="document.getElementById('kayit').submit();" class="btn_1 gradient full-width">Kayıt Ol</a>
				<div class="text-center mt-2"><small>Zaten Hesabın Varmı? <strong><a href="login.php">Giriş Yap</a></strong></small></div>
			</form>
			<div class="copy">© 2024 LezzetSepeti</div>
		</aside>
	</div>

    <script src="js/common_scripts.min.js"></script>
    <script src="js/common_func.js"></script>
    <script src="assets/validate.js"></script>
	
	<script src="js/pw_strenght.js"></script>	
  
</body>
</html>