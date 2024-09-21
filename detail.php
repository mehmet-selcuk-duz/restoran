<?php 
require_once "header.php"; 

$restaurant_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT company_id, name, description, address_province, address_district, address_detail, image_path FROM restaurant WHERE id = ?");
$stmt->execute([$restaurant_id]);
$restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

$company_id = $restaurant['company_id'];
$company_query = $pdo->prepare("SELECT name, description, logo_path FROM company WHERE id = ?");
$company_query->execute([$company_id]);
$company = $company_query->fetch();

$food_query = $pdo->prepare("SELECT id, name, description, image_path, price FROM food WHERE restaurant_id = ?");
$food_query->execute([$restaurant_id]);
$foods = $food_query->fetchAll(PDO::FETCH_ASSOC);

$basket_query = $pdo->prepare("
    SELECT b.quantity, b.id, f.name, f.price 
    FROM basket b 
    JOIN food f ON b.food_id = f.id 
    WHERE b.user_id = ?
");
$basket_query->execute([$user['id']]);
$basket_items = $basket_query->fetchAll(PDO::FETCH_ASSOC);

$total_price = 0;

$comments_query = $pdo->prepare("
    SELECT c.tittle, c.description, c.score, c.created_at, u.username 
    FROM comments c 
    JOIN users u ON c.user_id = u.id 
    WHERE c.restaurant_id = ?
");
$comments_query->execute([$restaurant_id]);
$comments = $comments_query->fetchAll(PDO::FETCH_ASSOC);

$average_score = 0;
if (count($comments) > 0) {
    $total_score = array_sum(array_column($comments, 'score'));
    $average_score = $total_score / count($comments);
}

?>
    <link href="css/detail-page.css" rel="stylesheet">
<br><br><br>

<main>
	    <div class="container margin_detail_2">
        <div class="row">
    <div class="col-lg-8">
        <div class="detail_page_head clearfix">
            <div class="rating">
                <div class="score"><span>Superb<em>15 Reviews</em></span><strong>8.9</strong></div>
            </div>
            <div class="title">
                <h1><?php echo htmlspecialchars($restaurant['name']); ?></h1>
                <p><?php echo htmlspecialchars($restaurant['address_province'] . ', ' . $restaurant['address_district'] . ', ' . $restaurant['address_detail']); ?></p>
            </div>
        </div>
        <h6>Hakkında:  "<?php echo htmlspecialchars($restaurant['name']); ?>"</h6>
        <p><?php echo htmlspecialchars($restaurant['description']); ?></p>

        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#companyModal">
            Firma Bilgileri
        </button>
            </div>
            <div class="col-lg-4">
                <div class="pictures magnific-gallery clearfix">
                <figure>
                    <a >
                        <img src="admin/<?php echo htmlspecialchars($restaurant['image_path']); ?>" class="lazy" alt="">
                    </a>
        </figure>
                </div>
            </div>
        </div>

        <div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="companyModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="companyModalLabel"><?php echo $company['name']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="admin/<?php echo $company['logo_path']; ?>" alt="<?php echo $company['name']; ?>" class="img-fluid">
                        <p><?php echo $company['description']; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>

	    </div>

	    <div class="bg_gray">
	        <div class="container margin_detail">
	            <div class="row">
	                <div class="col-lg-8 list_menu">
    <section id="section-1">
        <div class="table_wrapper">
            <table class="table table-borderless cart-list menu-gallery">
                <thead>
                    <tr>
                        <th>Yemek</th>
                        <th>Fiyat</th>
                        <th>Sipariş</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foods as $food): ?>
                    <tr>
                        <td class="d-md-flex align-items-center">
                            <figure>
                                <a href="admin/<?php echo htmlspecialchars($food['image_path']); ?>" title="<?php echo htmlspecialchars($food['name']); ?>" data-effect="mfp-zoom-in">
                                    <img src="admin/<?php echo htmlspecialchars($food['image_path']); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>" class="lazy">
                                </a>
                            </figure>
                            <div class="flex-md-column">
                                <h4><?php echo htmlspecialchars($food['name']); ?></h4>
                                <p><?php echo htmlspecialchars($food['description']); ?></p>
                            </div>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($food['price']); ?> TL</strong>
                        </td>
                        <td class="options">
                            <a href="#" data-toggle="modal" data-target="#addToBasketModal" data-food-id="<?php echo $food['id']; ?>">
                                <i class="icon_plus_alt2"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
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
										<a href="cart.php" class="btn_1 gradient full-width mb_5">Siparişi Tamamla</a>
									</div>
								</div>
							</div>
	                    
	                </div>
	            </div>
	        </div>
	    </div>

	    <div class="container margin_30_20">
            <div class="row">
                <div class="col-lg-8 list_menu">
                    <section id="section-5">
                        <h4>Yorumlar</h4>
                        <div class="row add_bottom_30 d-flex align-items-center reviews">
                            <div class="col-md-3">
                                <div id="review_summary">
                                    <strong><?php echo number_format($average_score, 1); ?></strong>
                                    <em>Ortalama Puan</em>
                                </div>
                            </div>
                        </div>
                        <div id="reviews">
                            <?php foreach ($comments as $comment): ?>
                                <div class="review_card">
                                    <div class="row">
                                        <div class="col-md-2 user_info">
                                            <figure><img src="img/avatar4.jpg" alt=""></figure>
                                            <h5><?php echo htmlspecialchars($comment['username']); ?></h5>
                                        </div>
                                        <div class="col-md-10 review_content">
                                            <div class="clearfix add_bottom_15">
                                                <span class="rating"><?php echo htmlspecialchars($comment['score']); ?><small>/10</small></span>
                                                <em><?php echo htmlspecialchars($comment['created_at']); ?></em>
                                            </div>
                                            <h4>"<?php echo htmlspecialchars($comment['tittle']); ?>"</h4>
                                            <p><?php echo htmlspecialchars($comment['description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-end">
    <button type="button" class="btn_1 gradient" data-toggle="modal" data-target="#leaveReviewModal">Yorum Yaz</button>
</div>
                    </section>
                </div>
            </div>
        </div>

<div class="modal fade" id="addToBasketModal" tabindex="-1" role="dialog" aria-labelledby="addToBasketModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToBasketModalLabel">Sepete Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="basketForm" method="POST" action="system/function.php">
                <div class="modal-body">
                    <input type="hidden" name="food_id" id="food_id">
                    <div class="form-group">
                        <label for="quantity">Miktar:</label>
                        <input type="number" class="form-control" name="quantity" value="1" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="note">Not:</label>
                        <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
					<input type="hidden" name="islem" value="basket-add">
					<input type="hidden" name="u_id" value="<?php echo $user["id"]; ?>">
                    <button type="submit" class="btn btn-primary">Sepete Ekle</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="leaveReviewModal" tabindex="-1" role="dialog" aria-labelledby="leaveReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveReviewModalLabel">Yorum Yaz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reviewForm" method="POST" action="system/function.php">
                <div class="modal-body">
                    <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>">
                    <div class="form-group">
                        <label for="title">Başlık:</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Yorum:</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="score">Puan:</label>
                        <select class="form-control" name="score" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <input type="hidden" name="islem" value="add-review">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button type="submit" class="btn btn-primary">Yorumu Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>
	</main>

<?php require_once "footer.php"; ?>
