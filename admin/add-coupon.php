<?php
require_once "header.php";
require_once "../system/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $restaurant_id = $_POST['restaurant_id'];
    $name = $_POST['name'];
    $discount = $_POST['discount'];

    $query = "INSERT INTO coupon (restaurant_id, name, discount) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$restaurant_id, $name, $discount]);

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
            <li class="breadcrumb-item active">Kupon Ekle</li>
        </ol>

        <div class="box_general">
            <div class="header_box">
                <h2 class="d-inline-block">Kupon Ekle</h2>
            </div>
            <div class="form">
                <form action="add-coupon.php" method="post">
                    <div class="form-group">
                        <label for="restaurant_id">Restoran Seç</label>
                        <select name="restaurant_id" class="form-control" required>
                            <?php foreach ($restaurants as $restaurant): ?>
                                <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Kupon Adı</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="discount">İndirim (%)</label>
                        <input type="number" name="discount" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
