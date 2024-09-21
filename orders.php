<?php require_once "header.php"; ?>

<link href="css/order-sign_up.css" rel="stylesheet">
<link href="css/detail-page.css" rel="stylesheet">
<br>
<main class="bg_gray">
		
		<div class="container margin_60_20">
		    <div class="row justify-content-center">
		        <div class="col-xl-12 col-lg-12">
		        	
                <div class="box_order_form">
					    <div class="head">
					        <div class="title">
					            <h3>Siparişler</h3>
					        </div>
					    </div>
					    <div class="main">
                        <section id="section-1">
	                        <div class="table_wrapper">
	                            <table class="table table-borderless cart-list menu-gallery">
	                                <thead>
	                                    <tr>
	                                        <th>Restoran</th>
	                                        <th>Toplam Fiyat</th>
	                                        <th>Sipariş Tarihi</th>
	                                        <th>Detay</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                    <?php
	                                    $userId = $user["id"];
	                                    
	                                    $query = "
	                                    SELECT o.total_price, o.created_at, r.name AS restaurant_name, r.image_path, r.description, o.id AS order_id
	                                    FROM `order` o
	                                    INNER JOIN `restaurant` r ON o.restaurant_id = r.id
	                                    WHERE o.user_id = :user_id
	                                    ";
	                                    
	                                    $stmt = $pdo->prepare($query);
	                                    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
	                                    $stmt->execute();
	                                    
	                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	                                        ?>
	                                        <tr>
	                                        <td class="d-md-flex align-items-center">
	                                            <figure>
	                                            	<a href="admin/<?php echo htmlspecialchars($row['image_path']); ?>" title="Photo title" data-effect="mfp-zoom-in"><img src="admin/<?php echo htmlspecialchars($row['image_path']); ?>" data-src="admin/<?php echo htmlspecialchars($row['image_path']); ?>" alt="thumb" class="lazy"></a>
	                                            </figure>
	                                            <div class="flex-md-column">
	                                                <h4><?php echo htmlspecialchars($row['restaurant_name']); ?></h4>
	                                                <p>
                                                    <?php echo htmlspecialchars($row['description']); ?>
	                                                </p>
	                                            </div>
	                                        </td>
	                                            <td>
	                                                <strong><?php echo htmlspecialchars($row['total_price']); ?> TL</strong>
	                                            </td>
	                                            <td>
	                                                <strong><?php echo htmlspecialchars($row['created_at']); ?></strong>
	                                            </td>
	                                        <td class="options">
	                                            <div class="dropdown dropdown-options">
	                                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true"><i class="arrow_triangle-down"></i></a>
	                                                <div class="dropdown-menu p-4">
	                                                    <h5>Yemekler</h5>
	                                                    <ul class="list-group">
	                                                        <?php
	                                                        $orderId = $row['order_id'];
	                                                        $itemsQuery = "
	                                                        SELECT oi.quantity, oi.price, f.name AS food_name
	                                                        FROM `order_items` oi
	                                                        INNER JOIN `food` f ON oi.food_id = f.id
	                                                        WHERE oi.order_id = :order_id
	                                                        ";
	                                                        $itemsStmt = $pdo->prepare($itemsQuery);
	                                                        $itemsStmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
	                                                        $itemsStmt->execute();
	                                                        
	                                                        while ($item = $itemsStmt->fetch(PDO::FETCH_ASSOC)) {
	                                                            ?>
	                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
	                                                                <span><?php echo htmlspecialchars($item['food_name']); ?></span>
	                                                                <span>Miktar: <?php echo htmlspecialchars($item['quantity']); ?></span>
	                                                                <span><?php echo htmlspecialchars($item['price']); ?> TL</span>
	                                                            </li>
	                                                            <?php
	                                                        }
	                                                        ?>
	                                                    </ul>
	                                                </div>
	                                            </div>
	                                        </td>
	                                        </tr>
	                                        <?php
	                                    }
	                                    ?>
	                                </tbody>
	                            </table>
	                        </div>
	                    </section>
					        </div>
					    </div>
					</div>

		    </div>
		</div>
		
	</main>

<?php require_once "footer.php"; ?>
