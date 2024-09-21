<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

if (isset($_GET['id'])) {
    $food_id = $_GET['id'];

    // Yiyeceği veritabanından al
    $query = "SELECT * FROM food WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$food_id]);
    $food = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$food) {
        header("Location: foods.php");
        exit;
    }

    $query = "SELECT id, name FROM restaurant";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: foods.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_id = $_POST['restaurant_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../img/" . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = $target;
        } else {
            $image_path = $food['image_path'];
        }
    } else {
        $image_path = $food['image_path'];
    }

    $query = "UPDATE food SET restaurant_id = ?, name = ?, description = ?, price = ?, discount = ?, image_path = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$restaurant_id, $name, $description, $price, $discount, $image_path, $food_id]);

    header("Location: foods.php?success=1");
    exit;
}
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="foods.php">Yemekler</a></li>
            <li class="breadcrumb-item active">Yemek Düzenle</li>
        </ol>
        <div class="box_general">
            <div class="header_box">
                <h2 class="d-inline-block">Yemek Düzenle</h2>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Restoran Seç</label>
                    <select name="restaurant_id" class="form-control">
                        <?php foreach ($restaurants as $restaurant): ?>
                        <option value="<?php echo $restaurant['id']; ?>" <?php echo $restaurant['id'] == $food['restaurant_id'] ? 'selected' : ''; ?>>
                            <?php echo $restaurant['name']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Yemek Adı</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $food['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="description" class="form-control" required><?php echo $food['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Fiyat</label>
                    <input type="number" name="price" class="form-control" value="<?php echo $food['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label>İndirim (%)</label>
                    <input type="number" name="discount" class="form-control" value="<?php echo $food['discount']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Resim</label>
                    <input type="file" name="image" class="form-control">
                    <img src="<?php echo $food['image_path']; ?>" alt="Food Image" width="100" height="100">
                </div>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
