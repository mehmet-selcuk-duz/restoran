<?php require_once "header.php"; ?>

<link href="css/order-sign_up.css" rel="stylesheet">
<link href="css/detail-page.css" rel="stylesheet">
<br>
<main class="bg_gray">
		
		<div class="container margin_60_20">
		    <div class="row justify-content-center">
		        <div class="col-xl-6 col-lg-8">
		        	<div class="box_order_form">
					    <div class="head">
					        <div class="title">
					            <h3>Hesap Düzenleme</h3>
					        </div>
					    </div>
                        <form method="post" action="system/function.php">
					    <div class="main">
					        <div class="row">
					            <div class="col-md-6">
					                <div class="form-group">
					                    <label>Ad</label>
					                    <input class="form-control" name="name" value="<?php echo $user["name"]; ?>">
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="form-group">
					                    <label>Soyad</label>
					                    <input class="form-control" name="surname" value="<?php echo $user["surname"]; ?>">
					                </div>
					            </div>
					        </div>
					        <div class="form-group">
					            <label>Kullanıcı Adı</label>
					            <input class="form-control" name="username" value="<?php echo $user["username"]; ?>">
					        </div>
                                <input type="hidden" name="islem" value="account-edit">
                                <input type="hidden" name="u_id" value="<?php echo $user["id"]; ?>">
                                <button type="submit" class="btn_1 outline">Kaydet</button>
					    </div>
                        </form>
					</div>
		        	<div class="box_order_form">
					    <div class="head">
					        <div class="title">
					            <h3>Şifre Değiştirme</h3>
					        </div>
					    </div>
                        <form method="post" action="system/function.php">
					    <div class="main">
					        <div class="form-group">
					            <label>Yeni Şifre</label>
					            <input class="form-control" type="password" name="password">
					        </div>
					        <div class="form-group">
					            <label>Yeni Şifre Tekrar</label>
					            <input class="form-control" type="password" name="r-password">
					        </div>
                                <input type="hidden" name="islem" value="password-update">
                                <input type="hidden" name="u_id" value="<?php echo $user["id"]; ?>">
                                <button type="submit" class="btn_1 outline">Kaydet</button>
					    </div>
                        </form>
					</div>
		        </div>
		        <div class="col-xl-4 col-lg-4" id="sidebar_fixed">
		            <div class="box_order">
		                <div class="head">
		                    <h3>Hesap Bilgileri</h3>
		                </div>
		                <div class="main">
		                	<ul>
                                <li>Ad Soyad: <span><?php echo $user["name"]; ?> <?php echo $user["surname"]; ?></span></li>
		                		<li>Oluşturma Tarihi: <span><?php echo $user["created_at"]; ?></span></li>
		                		<li>Fİrma: <span><?php echo $company_name; ?></span></li>
		                	</ul>
		                	<hr>
		                	<ul class="clearfix">
		                		<li class="total">Bakiye<span><?php echo $user["balance"]; ?></span></li>
		                	</ul>
		                    <a href="add-funds.php" class="btn_1 gradient full-width mb_5">Bakiye Yükle</a>
		                </div>
		            </div>
		        </div>

		    </div>
		</div>
		
	</main>

<?php require_once "footer.php"; ?>