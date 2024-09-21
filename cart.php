<?php 
require_once "header.php"; 

$basket_query = $pdo->prepare("
    SELECT b.quantity, b.id, f.name, f.price 
    FROM basket b 
    JOIN food f ON b.food_id = f.id 
    WHERE b.user_id = ?
");
$basket_query->execute([$user['id']]);
$basket_items = $basket_query->fetchAll(PDO::FETCH_ASSOC);

$total_price = 0;
?>
<link href="css/order-sign_up.css" rel="stylesheet">
<link href="css/detail-page.css" rel="stylesheet">
<br><br><br>

<main class="bg_gray">
		
		<div class="container margin_60_20">
		    <div class="row justify-content-center">
		        <div class="col-xl-6 col-lg-8">
		            <div class="box_order_form">
					    <div class="head">
					        <div class="title">
					            <h3>Payment Method</h3>
					        </div>
					    </div>
					    <div class="main">
					        <div class="payment_select">
					            <label class="container_radio">Credit Card
					                <input type="radio" value="" checked name="payment_method">
					                <span class="checkmark"></span>
					            </label>
					            <i class="icon_creditcard"></i>
					        </div>
					        <div class="payment_select">
					            <label class="container_radio">Bakiye
					                <input type="radio" value="" name="payment_method">
					                <span class="checkmark"></span>
					            </label>
					            <i class="icon_wallet"></i>
					        </div>
					    </div>
					</div>
		        </div>
		        <div class="col-lg-4" id="sidebar_fixed">
	                    <div class="box_order mobile_fixed">
	                        <div class="head">
	                            <h3>Sipariş Sepeti</h3>
	                            <a href="#0" class="close_panel_mobile"><i class="icon_close"></i></a>
	                        </div>
	                        <div class="main">
									<ul class="clearfix">
										<?php foreach ($basket_items as $item): ?>
										<?php 
											$item_total = $item['price'] * $item['quantity'];
											$total_price += $item_total;
										?>
										<li>
										<a href="system/function.php?islem=basket-delete&id=<?php echo $item['id']; ?>"><?php echo $item['quantity']; ?>x <?php echo htmlspecialchars($item['name']); ?></a>
											<span><?php echo htmlspecialchars($item_total); ?> TL</span>
										</li>
										<?php endforeach; ?>
									</ul>
									<ul class="clearfix">
										<li class="total">Toplam<span><?php echo htmlspecialchars($total_price); ?> TL</span></li>
									</ul>
									
									<div class="btn_1_mobile">
										<a href="system/function.php?islem=order&u_id=<?php echo $user['id']; ?>&total=<?php echo $total_price; ?>" class="btn_1 gradient full-width mb_5">Siparişi Tamamla</a>
									</div>
								</div>
							</div>
	                    
	                </div>

		    </div>
		</div>
		
	</main>

<?php require_once "footer.php"; ?>
