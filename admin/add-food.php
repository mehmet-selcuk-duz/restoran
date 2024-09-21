<?php
require_once "header.php";
require_once "../system/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_id = $_POST['restaurant_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    $image = $_FILES['image']['name'];
    $target = "../img/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $image_path = $target;
    } else {
        $image_path = null;
    }

    $query = "INSERT INTO food (restaurant_id, name, description, price, discount, image_path) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$restaurant_id, $name, $description, $price, $discount, $image_path]);

    header("Location: foods.php");
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
            <li class="breadcrumb-item active">Yemek Ekle</li>
        </ol>
        <div class="box_general">
            <div class="header_box">
                <h2 class="d-inline-block">Yemek Ekle</h2>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Restoran Seç</label>
                    <select name="restaurant_id" class="form-control">
                        <?php foreach ($restaurants as $restaurant): ?>
                        <option value="<?php echo $restaurant['id']; ?>"><?php echo $restaurant['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Yemek Adı</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Fiyat</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>İndirim (%)</label>
                    <input type="number" name="discount" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Resim</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
