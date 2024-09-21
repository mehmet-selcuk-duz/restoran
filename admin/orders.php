<?php
require_once "header.php"; 

require_once "../system/config.php";

// Silme işlemi
if (isset($_GET['delete'])) {
    $order_id = $_GET['delete'];
    $query = "DELETE FROM `order` WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$order_id]);
    header("Location: orders.php?success=1");
    exit;
}

$query = "SELECT `order`.*, users.username as user_name, restaurant.name as restaurant_name 
          FROM `order` 
          JOIN users ON `order`.user_id = users.id
          JOIN restaurant ON `order`.restaurant_id = restaurant.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active">Siparişler</li>
        </ol>

        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert" style="text-align: right;">
            Silme işlemi başarılı!
        </div>
        <?php endif; ?>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Siparişler Tablosu</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Restoran</th>
                                <th>Kullanıcı</th>
                                <th>Tarih</th>
                                <th>Durum</th>
                                <th>Düzenle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['restaurant_name']; ?></td>
                                <td><?php echo $order['user_name']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($order['created_at'])); ?></td>
                                <td>
                                    <?php if ($order['order_status'] == '1'): ?>
                                        <i class="pending">Hazırlanıyor</i>
                                    <?php elseif ($order['order_status'] == '2'): ?>
                                        <i class="badge badge-pill badge-primary">Yola Çıktı</i>
                                    <?php elseif ($order['order_status'] == '3'): ?>
                                        <i class="approved">Teslim Edildi</i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit-order.php?id=<?php echo $order['id']; ?>"><strong>Düzenle</strong></a> | 
                                    <a href="?delete=<?php echo $order['id']; ?>"><strong>Sil</strong></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer small text-muted">Son güncelleme dün saat 23:59'da</div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
