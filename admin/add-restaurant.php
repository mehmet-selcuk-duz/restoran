<?php
require_once "header.php";

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $address_province = $_POST['address_province'];
    $address_district = $_POST['address_district'];
    $address_detail = $_POST['address_detail'];
    $company_id = $_POST['company_id'];

    $image_path = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    $query = "INSERT INTO restaurant (name, description, address_province, address_district, address_detail, image_path, company_id) 
              VALUES (:name, :description, :address_province, :address_district, :address_detail, :image_path, :company_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'name' => $name,
        'description' => $description,
        'address_province' => $address_province,
        'address_district' => $address_district,
        'address_detail' => $address_detail,
        'image_path' => $image_path,
        'company_id' => $company_id
    ]);

    header("Location: restaurants.php?success=1");
    exit;
}

$query = "SELECT id, name FROM company";
$stmt = $pdo->prepare($query);
$stmt->execute();
$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active">Restoran Ekle</li>
        </ol>
        <div class="box_general padding_bottom">
            <div class="header_box">
                <h2><i class="fa fa-file"></i>Temel Bilgiler</h2>
            </div>
            <form action="add-restaurant.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Restoran Adı</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Şirket</label>
                            <select name="company_id" class="form-control" required>
                                <?php foreach ($companies as $company): ?>
                                    <option value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Açıklama</label>
                            <input type="text" name="description" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Adres İl</label>
                            <input type="text" name="address_province" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Adres İlçe</label>
                            <input type="text" name="address_district" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Adres Detayı</label>
                            <input type="text" name="address_detail" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Resim Yükle</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Ekle</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
