<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}

require_once "../system/config.php";

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM comments WHERE id = :deleteId";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute(['deleteId' => $deleteId]);
}

$query = "SELECT c.*, u.username, r.name as restaurant_name FROM comments c
          JOIN users u ON c.user_id = u.id
          JOIN restaurant r ON c.restaurant_id = r.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active">Yorumlar</li>
        </ol>
        <div class="box_general pb-3">
            <div class="header_box">
                <h2 class="d-inline-block">Yorum Listesi</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kullanıcı</th>
                            <th>Restorant</th>
                            <th>Başlık</th>
                            <th>Açıklama</th>
                            <th>Puan</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td><?php echo $comment['username']; ?></td>
                            <td><?php echo $comment['restaurant_name']; ?></td>
                            <td><?php echo $comment['tittle']; ?></td>
                            <td><?php echo $comment['description']; ?></td>
                            <td><?php echo $comment['score']; ?></td>
                            <td>
                                <a href="?delete_id=<?php echo $comment['id']; ?>" class="btn_1 gray delete" onclick="return confirm('Bu yorumu silmek istediğinizden emin misiniz?');">Sil</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>
