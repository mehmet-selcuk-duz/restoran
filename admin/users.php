<?php 
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}

require_once "../system/config.php";

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $current_date = date('Y-m-d');

    $delete_query = "UPDATE users SET deleted_at = :deleted_at WHERE id = :id";
    $delete_stmt = $pdo->prepare($delete_query);
    $delete_stmt->execute(['deleted_at' => $current_date, 'id' => $delete_id]);

    if ($delete_stmt->rowCount()) {
        $success_message = "Kullanıcı başarıyla silindi.";
    } else {
        $error_message = "Kullanıcı silinirken bir hata oluştu.";
    }
}

if (isset($_GET['activate_id'])) {
    $activate_id = $_GET['activate_id'];

    $activate_query = "UPDATE users SET deleted_at = NULL WHERE id = :id";
    $activate_stmt = $pdo->prepare($activate_query);
    $activate_stmt->execute(['id' => $activate_id]);

    if ($activate_stmt->rowCount()) {
        $success_message = "Kullanıcı başarıyla aktif edildi.";
    } else {
        $error_message = "Kullanıcı aktif edilirken bir hata oluştu.";
    }
}

$query = "SELECT users.id, users.username, users.name, users.surname, users.company_id, users.role, users.deleted_at, 
          company.name as company_name, company.logo_path 
          FROM users 
          JOIN company ON users.company_id = company.id";

$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active">Kullanıcılar</li>
        </ol>

<?php if (isset($success_message)): ?>
    <div class="alert alert-success text-center" role="alert">
        <?php echo $success_message; ?>
    </div>
<?php elseif (isset($error_message)): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>
        <div class="box_general">
            <div class="header_box d-flex justify-content-between align-items-center">
                <h2 class="d-inline-block">Kullanıcılar</h2>
                <a href="add-user.php" class="btn btn-success float-right">Kullanıcı Ekle <i class="fa fa-fw fa-plus"></i></a>
            </div>

            <div class="list_general">
                <ul>
                    <?php foreach ($users as $user): ?>
                    <li>
                        <figure><img src="<?php echo $user['logo_path']; ?>" alt=""></figure>
                        <small><?php echo $user['company_name']; ?></small>
                        <h4><?php echo $user['name']; ?> <?php echo $user['surname']; ?></h4>
                        <p><?php echo $user['username']; ?></p>
                        <h6>Rol: 
                            <?php 
                            if ($user['role'] == 1) {
                                echo "Kullanıcı"; 
                            } elseif ($user['role'] == 2) {
                                echo "Admin"; 
                            }
                            ?>
                        </h6>

                        <p>
                        <a href="edit-user.php?id=<?php echo $user['id']; ?>" class="btn_1 gray">Düzenle <i class="fa fa-fw fa-pencil"></i></a>
                            <?php if ($user['deleted_at'] == null): ?>
                                <a href="users.php?delete_id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Kullanıcıyı silmek istediğinize emin misiniz?');">Sil <i class="fa fa-fw fa-trash"></i></a>
                            <?php else: ?>
                                <a href="users.php?activate_id=<?php echo $user['id']; ?>" class="btn btn-success">Aktif Et <i class="fa fa-fw fa-check"></i></a>
                            <?php endif; ?>
                        </p>
                        <ul class="buttons"></ul>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>
