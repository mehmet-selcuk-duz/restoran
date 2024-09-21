<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

if (isset($_GET['id'])) {
    $coupon_id = $_GET['id'];
    $query = "SELECT * FROM coupon WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$coupon_id]);
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $restaurant_id = $_POST['restaurant_id'];
    $name = $_POST['name'];
    $discount = $_POST['discount'];
    $coupon_id = $_POST['id'];

    $query = "UPDATE coupon SET restaurant_id = ?, name = ?, discount = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$restaurant_id, $name, $discount, $coupon_id]);

    header("Location: coupons.php?success=1");
    exit;
}

$query = "SELECT id, name FROM restaurant";
$stmt = $pdo->prepare($query);
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
            <li class="breadcrumb-item active">Kupon Düzenle</li>
        </ol>

        <div class="box_general">
            <div class="header_box">
                <h2 class="d-inline-block">Kupon Düzenle</h2>
            </div>
            <div class="form">
                <form action="edit-coupon.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $coupon['id']; ?>">
                    <div class="form-group">
                        <label for="restaurant_id">Restoran Seç</label>
                        <select name="restaurant_id" class="form-control" required>
                            <?php foreach ($restaurants as $restaurant): ?>
                                <option value="<?php echo $restaurant['id']; ?>" <?php echo ($restaurant['id'] == $coupon['restaurant_id']) ? 'selected' : ''; ?>>
                                    <?php echo $restaurant['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Kupon Adı</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $coupon['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="discount">İndirim (%)</label>
                        <input type="number" name="discount" class="form-control" value="<?php echo $coupon['discount']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
