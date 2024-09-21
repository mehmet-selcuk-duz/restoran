<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

$id = $_GET['id'];
$query = "SELECT * FROM company WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$company = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $logo_path = $company['logo_path'];

    if (!empty($_FILES['logo']['name'])) {
        $target_dir = "img/";
        $logo_name = basename($_FILES['logo']['name']);
        $target_file = $target_dir . $logo_name;
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_file)) {
            $logo_path = $target_file;
        }
    }

    $query = "UPDATE company SET name = :name, description = :description, logo_path = :logo_path WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['name' => $name, 'description' => $description, 'logo_path' => $logo_path, 'id' => $id]);

    header("refresh:3;url=companies.php");
    $message = "Firma başarıyla güncellendi!";
}
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-edit"></i> Firma Düzenle</h2>
            </div>
            <?php if (!empty($message)): ?>
                <div class="alert alert-success text-center">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Firma Adı</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $company['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="description" class="form-control" required><?php echo $company['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Logo</label>
                    <input type="file" name="logo" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Firma Güncelle</button>
            </form>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
