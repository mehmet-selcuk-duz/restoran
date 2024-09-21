<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

if (isset($_GET['delete'])) {
    $coupon_id = $_GET['delete'];
    $query = "DELETE FROM coupon WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$coupon_id]);
    header("Location: coupons.php?success=1");
    exit;
}

$query = "SELECT coupon.*, restaurant.name as restaurant_name 
          FROM coupon 
          JOIN restaurant ON coupon.restaurant_id = restaurant.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
            <li class="breadcrumb-item active">Kuponlar</li>
        </ol>

        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" role="alert" style="text-align: center;">
            İşlem başarılı!
        </div>
        <?php endif; ?>

        <div class="box_general">
            <div class="header_box">
                <h2 class="d-inline-block">Kuponlar</h2>
                <a href="add-coupon.php" class="btn btn-success float-right">Kupon Ekle <i class="fa fa-fw fa-plus"></i></a>
            </div>
            <div class="list_general">
                <ul>
                    <?php foreach ($coupons as $coupon): ?>
                    <li>
                        <small><?php echo $coupon['restaurant_name']; ?></small>
                        <h4><?php echo $coupon['name']; ?></h4>
                        <h6>İndirim: <?php echo $coupon['discount']; ?>%</h6>

                        <p>
                            <a href="edit-coupon.php?id=<?php echo $coupon['id']; ?>" class="btn_1 gray">Düzenle <i class="fa fa-fw fa-pencil"></i></a>
                            <a href="?delete=<?php echo $coupon['id']; ?>" class="btn_1 red">Sil <i class="fa fa-fw fa-trash"></i></a>
                        </p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
