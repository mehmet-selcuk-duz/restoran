<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

// Silme işlemi
if (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $query = "DELETE FROM restaurant WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $message = "Restoran başarıyla silindi!";
    header("Location: restaurants.php?success=1");
    exit;
}

$query = "SELECT restaurant.id, restaurant.name, restaurant.description, restaurant.address_province, restaurant.address_district, restaurant.address_detail, restaurant.image_path, company.name as company_name 
          FROM restaurant 
          JOIN company ON restaurant.company_id = company.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active">Restoranlar</li>
        </ol>
        <div class="box_general">
            <div class="header_box">
                <h2 class="d-inline-block">Restoranlar</h2>
                <a href="add-restaurant.php" class="btn btn-success float-right">Restoran Ekle <i class="fa fa-fw fa-plus"></i></a>
            </div>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success text-right">
                    <?php echo $message ?? 'İşlem başarıyla tamamlandı!'; ?>
                </div>
            <?php endif; ?>

            <div class="list_general">
                <ul>
                    <?php foreach ($restaurants as $restaurant): ?>
                    <li>
                        <figure><img src="<?php echo $restaurant['image_path']; ?>" alt=""></figure>
                        <h4><?php echo $restaurant['name']; ?></h4>
                        <p><?php echo $restaurant['description']; ?></p>
                        <p><?php echo $restaurant['address_province']; ?>, <?php echo $restaurant['address_district']; ?>, <?php echo $restaurant['address_detail']; ?></p>
                        <small><?php echo $restaurant['company_name']; ?></small>

                        <p>
                            <a href="edit-restaurant.php?id=<?php echo $restaurant['id']; ?>" class="btn_1 gray">Düzenle <i class="fa fa-fw fa-pencil"></i></a>
                            <a href="restaurants.php?action=delete&id=<?php echo $restaurant['id']; ?>" class="btn btn-danger" onclick="return confirm('Restorantı silmek istediğinize emin misiniz?');">Sil <i class="fa fa-fw fa-trash"></i></a>
                        </p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
