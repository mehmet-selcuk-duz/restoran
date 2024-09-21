<?php 
require_once "header.php"; 

$sql = "
    SELECT f.id AS food_id, f.name AS food_name, f.discount, f.image_path, r.id AS restaurant_id, r.name AS restaurant_name, r.address_detail, 
           COALESCE(AVG(c.score), 0) AS avg_score
    FROM food f
    JOIN restaurant r ON f.restaurant_id = r.id
    LEFT JOIN comments c ON f.restaurant_id = c.restaurant_id
    GROUP BY f.id
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link href="css/listing.css" rel="stylesheet">
<br><br><br>
<main>
		<div class="page_header element_to_stick">
		    <div class="container">
		    	<div class="row">
		    		<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
		        		<h1><?php if (!empty($adres)): ?><?php echo $adres; ?><?php endif; ?></h1>
		    		</div>
		    	</div>
		    </div>
		</div>

	    <div class="container margin_30_20">

	        <div class="promo mb_30">
	            <h3>İlk 14 gün boyunca Ücretsiz Teslimat!</h3>
	            <p>İlk 14 gün Ücretsiz Teslimat kampanyası, yeni müşterilere siparişlerinde teslimat ücreti almıyor. Harika bir fırsat!</p>
	            <i class="icon-food_icon_delivery"></i>
	        </div>

	        <div class="row isotope-wrapper">
	            <?php foreach ($foods as $food): ?>
	            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 isotope-item delivery">
	                <div class="strip">
	                    <figure>
	                        <span class="ribbon off"><?php echo $food['discount']; ?>% İndirim</span>
	                        <img src="img/lazy-placeholder.png" data-src="<?php echo $food['image_path']; ?>" class="img-fluid lazy" alt="">
	                        <a href="detail.php?id=<?php echo $food['restaurant_id']; ?>" class="strip_info">
	                            <small><?php echo $food['restaurant_name']; ?></small>
	                            <div class="item_title">
	                                <h3><?php echo $food['food_name']; ?></h3>
	                                <small><?php echo $food['address_detail']; ?></small>
	                            </div>
	                        </a>
	                    </figure>
	                    <ul>
	                        <li><span class="take yes">Hızlı Paket</span> <span class="deliv yes">Hızlı Teslimat</span></li>
	                        <li>
							<div class="score"><strong><?php echo number_format($food['avg_score'], 1); ?></strong></div>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	            <?php endforeach; ?>
	        </div>

	        <div class="pagination_fg">
	            <a href="#">&laquo;</a>
	            <a href="#" class="active">1</a>
	            <a href="#">2</a>
	            <a href="#">3</a>
	            <a href="#">&raquo;</a>
	        </div>
	    </div>
	</main>

<?php require_once "footer.php"; ?>
