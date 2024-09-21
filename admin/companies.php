<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['action'] == 'delete') {
        $query = "UPDATE company SET deleted_at = NOW() WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $message = "Firma başarıyla silindi!";
    } elseif ($_GET['action'] == 'activate') {
        $query = "UPDATE company SET deleted_at = NULL WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $message = "Firma başarıyla aktif edildi!";
    }

    header("Location: companies.php?success=1");
    exit;
}

$query = "SELECT id, name, description, logo_path, deleted_at FROM company";
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
            <li class="breadcrumb-item active">Firmalar</li>
        </ol>
        <div class="box_general">
        <div class="header_box d-flex justify-content-between align-items-center">
                <h2 class="d-inline-block">Firmalar</h2>
                <a href="add-company.php" class="btn btn-success float-right">Firma Ekle <i class="fa fa-fw fa-plus"></i></a>
            </div>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success text-center">
                    <?php echo $message ?? 'İşlem başarıyla tamamlandı!'; ?>
                </div>
            <?php endif; ?>

            <div class="list_general">
                <ul>
                    <?php foreach ($companies as $company): ?>
                    <li>
                        <figure><img src="<?php echo $company['logo_path']; ?>" alt=""></figure>
                        <h4><?php echo $company['name']; ?></h4>
                        <p><?php echo $company['description']; ?></p>

                        <?php if ($company['deleted_at']): ?>
                            <p>
                            <a href="edit-company.php?id=<?php echo $company['id']; ?>" class="btn_1 gray">Düzenle <i class="fa fa-fw fa-pencil"></i></a>
                                <a href="companies.php?action=activate&id=<?php echo $company['id']; ?>" class="btn btn-success">Aktif Et <i class="fa fa-fw fa-check"></i></a>
                            </p>
                        <?php else: ?>
                            <p>
                                <a href="edit-company.php?id=<?php echo $company['id']; ?>" class="btn_1 gray">Düzenle <i class="fa fa-fw fa-pencil"></i></a>
                                <a href="companies.php?action=delete&id=<?php echo $company['id']; ?>" class="btn btn-danger" onclick="return confirm('Firmayı silmek istediğinize emin misiniz?');">Sil <i class="fa fa-fw fa-trash"></i></a>
                            </p>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
