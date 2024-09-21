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
					            <h3>Bakiye Yükle</h3>
					        </div>
					    </div>
					    <div class="main">
					        <div class="payment_select">
					            <label class="container_radio">Kredi Kartı
					                <input type="radio" value="" checked name="payment_method">
					                <span class="checkmark"></span>
					            </label>
					            <i class="icon_creditcard"></i>
					        </div>
                            <form method="post" action="system/function.php">
					        <div class="form-group">
					            <label>Tutar</label>
					            <input type="number" class="form-control" id="name_card_order" name="tutar" placeholder="Tutar">
					        </div>
					        <div class="form-group">
					            <label>Kartın Üzerindeki İsim</label>
					            <input type="text" class="form-control" id="name_card_order" name="name_card_order" placeholder="Ad Soyad">
					        </div>
					        <div class="form-group">
					            <label>Kart Numarası</label>
					            <input type="text" id="card_number" name="card_number" class="form-control" placeholder="Kart Numarası">
					        </div>
					        <div class="row">
					            <div class="col-md-6">
					                <label>Sonlanma Tarihi</label>
					                <div class="row">
					                    <div class="col-md-6 col-6">
					                        <div class="form-group">
					                            <input type="text" id="expire_month" name="expire_month" class="form-control" placeholder="ay">
					                        </div>
					                    </div>
					                    <div class="col-md-6 col-6">
					                        <div class="form-group">
					                            <input type="text" id="expire_year" name="expire_year" class="form-control" placeholder="yıl">
					                        </div>
					                    </div>
					                </div>
					            </div>
					            <div class="col-md-6 col-sm-12">
					                <div class="form-group">
					                    <label>CVV</label>
					                    <div class="row">
					                        <div class="col-md-4 col-6">
					                            <div class="form-group">
					                                <input type="text" id="ccv" name="ccv" class="form-control" placeholder="CCV">
					                            </div>
					                        </div>
					                        <div class="col-md-8 col-6">
					                            <img src="img/icon_ccv.gif" width="50" height="29" alt="ccv"><small>3 Haneli Kod</small>
					                        </div>
					                    </div>
					                </div>
					            </div>
                                <input type="hidden" name="islem" value="balance-add">
                                <input type="hidden" name="ex_balance" value="<?php echo $user["balance"]; ?>">
                                <input type="hidden" name="u_id" value="<?php echo $user["id"]; ?>">
                                <button type="submit" class="btn_1 outline">Yükle</button>
                                </form>
					        </div>
					    </div>
					</div>

		    </div>
		</div>
		
	</main>

<?php require_once "footer.php"; ?>