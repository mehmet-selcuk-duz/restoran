<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

$orderId = $_GET['id'];
$query = "SELECT o.*, u.username, r.name as restaurant_name, r.address_province, r.address_district, r.address_detail FROM `order` o 
          JOIN users u ON o.user_id = u.id 
          JOIN restaurant r ON o.restaurant_id = r.id 
          WHERE o.id = :orderId";
$stmt = $pdo->prepare($query);
$stmt->execute(['orderId' => $orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);


$orderItemsQuery = "SELECT oi.*, f.name as food_name FROM order_items oi 
                    JOIN food f ON oi.food_id = f.id 
                    WHERE oi.order_id = :orderId";
$orderItemsStmt = $pdo->prepare($orderItemsQuery);
$orderItemsStmt->execute(['orderId' => $orderId]);
$orderItems = $orderItemsStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderStatus = $_POST['order_status'];

    $updateQuery = "UPDATE `order` SET order_status = :orderStatus WHERE id = :orderId";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute(['orderStatus' => $orderStatus, 'orderId' => $orderId]);

    header("Location: edit-order.php?id=$orderId");
    exit();
}
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active">Sipariş Düzenle</li>
        </ol>
        <div class="box_general pb-3">
            <div class="header_box">
                <h2 class="d-inline-block">Sipariş Düzenle <?php echo $order['id']; ?></h2>
            </div>
            <div class="list_general order">
                <ul>
                    <li>
                        <figure><img src="img/item_1.jpg" alt=""></figure>
                        <h4><?php echo $order['restaurant_name']; ?> <i class="pending"><?php echo $order['order_status']; ?></i></h4>
                        <ul class="booking_list">
                            <li><strong>Müşteri</strong> <?php echo $order['username']; ?></li>
                            <li><strong>Tarih</strong> <?php echo $order['created_at']; ?></li>
                            <li><strong>Addres</strong> <?php echo $order['address_province'] . ', ' . $order['address_district'] . ', ' . $order['address_detail']; ?></li>
                            <li><strong>Ödeme Yöntemi</strong></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <hr>
            <h5>Sipariş Detayları</h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>İd</th>
                            <th>Yemek</th>
                            <th>Miktat</th>
                            <th>Fiyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td><?php echo $item['food_id']; ?></td>
                            <td><?php echo $item['food_name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo $item['price']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <form method="POST" action="edit-order.php?id=<?php echo $order['id']; ?>">
                <div class="form-group">
                    <label>Sipariş Düzenle</label>
                    <div class="styled-select">
                        <select name="order_status" class="form-control">
                            <option value="1" <?php echo $order['order_status'] == 1 ? 'selected' : ''; ?>>Hazırlanıyor</option>
                            <option value="2" <?php echo $order['order_status'] == 2 ? 'selected' : ''; ?>>Yola Çıktı</option>
                            <option value="3" <?php echo $order['order_status'] == 3 ? 'selected' : ''; ?>>Teslim Edildi</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Güncelle</button>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>