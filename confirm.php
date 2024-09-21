<?php 
require_once "header.php"; 
?>
    <link href="css/order-sign_up.css" rel="stylesheet">
<br><br><br>

<main class="bg_gray">
		
		<div class="container margin_60_40">
		    <div class="row justify-content-center">
		        <div class="col-lg-4">
		        	<div class="box_order_form">
		                <div class="main">
		                	<div id="confirm">
								<div class="icon icon--order-success svg add_bottom_15">
									<svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
										<g fill="none" stroke="#8EC343" stroke-width="2">
											<circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
											<path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
										</g>
									</svg>
								</div>
								<h3>Sipariş Oluşturuldu!</h3>
								<p>Siparişiniz Başarıyla Oluşturuldu Yönlendiriliyorsunuz.</p>
							</div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		
	</main>
<script>
    setTimeout(function() {
    window.location.href = "/orders.php";
}, 3000);
</script>
<?php require_once "footer.php"; ?>
