<?php
require_once "header.php"; 

require_once "../system/config.php";

if (isset($_GET['delete'])) {
    $food_id = $_GET['delete'];
    $query = "UPDATE food SET deleted_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$food_id]);
    header("Location: foods.php?success=1");
    exit;
}

if (isset($_GET['activate'])) {
    $food_id = $_GET['activate'];
    $query = "UPDATE food SET deleted_at = NULL WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$food_id]);
    header("Location: foods.php?success=1");
    exit;
}

$query = "SELECT food.*, restaurant.name as restaurant_name 
          FROM food 
          JOIN restaurant ON food.restaurant_id = restaurant.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$foods = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active">Yemekler</li>
        </ol>
        <div class="box_general">
            <div class="header_box">
                <h2 class="d-inline-block">Yemekler</h2>
                <a href="add-food.php" class="btn btn-success float-right">Yemek Ekle <i class="fa fa-fw fa-plus"></i></a>
            </div>
            <div class="list_general">
                <ul>
                    <?php foreach ($foods as $food): ?>
                    <li>
                        <figure><img src="<?php echo $food['image_path']; ?>" alt=""></figure>
                        <small><?php echo $food['restaurant_name']; ?></small>
                        <h4><?php echo $food['name']; ?></h4>
                        <p><?php echo $food['description']; ?></p>
                        <p>Fiyat: <?php echo $food['price']; ?> ₺</p>
                        <p>İndirim: <?php echo $food['discount']; ?> %</p>
                        <p>
                            <a href="edit-food.php?id=<?php echo $food['id']; ?>" class="btn_1 gray">Düzenle <i class="fa fa-fw fa-pencil"></i></a>
                            <?php if (is_null($food['deleted_at'])): ?>
                                <a href="?delete=<?php echo $food['id']; ?>" class="btn btn-danger">Sil <i class="fa fa-fw fa-trash"></i></a>
                            <?php else: ?>
                                <a href="?activate=<?php echo $food['id']; ?>" class="btn btn-success">Aktif Et <i class="fa fa-fw fa-check"></i></a>
                            <?php endif; ?>
                        </p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
