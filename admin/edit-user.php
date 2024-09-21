<?php
require_once "header.php"; 

if (!$isAuthorized)
{
    header("Location: index.php");
}
require_once "../system/config.php";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $company_id = $_POST['company_id'];
    $role = $_POST['role'];
    $balance = $_POST['balance'];

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $query = "UPDATE users SET username = :username, name = :name, surname = :surname, company_id = :company_id, 
                  role = :role, balance = :balance, password = :password WHERE id = :id";
        $params = [
            'username' => $username,
            'name' => $name,
            'surname' => $surname,
            'company_id' => $company_id,
            'role' => $role,
            'balance' => $balance,
            'password' => $password,
            'id' => $user_id
        ];
    } else {
        $query = "UPDATE users SET username = :username, name = :name, surname = :surname, company_id = :company_id, 
                  role = :role, balance = :balance WHERE id = :id";
        $params = [
            'username' => $username,
            'name' => $name,
            'surname' => $surname,
            'company_id' => $company_id,
            'role' => $role,
            'balance' => $balance,
            'id' => $user_id
        ];
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    if ($stmt) {
        $success_message = "Kullanıcı başarıyla güncellendi.";
        header("Refresh: 2; url=users.php");
    } else {
        $error_message = "Kullanıcı güncellenirken bir hata oluştu.";
    }
}

$company_query = "SELECT id, name FROM company";
$company_stmt = $pdo->prepare($company_query);
$company_stmt->execute();
$companies = $company_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Anasayfa</a>
            </li>
            <li class="breadcrumb-item active">Kullanıcı Düzenle</li>
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

        <div class="box_general padding_bottom">
            <div class="header_box version_2">
                <h2><i class="fa fa-edit"></i>Kullanıcı Düzenle</h2>
            </div>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kullanıcı Adı</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Şirket</label>
                            <select name="company_id" class="form-control" required>
                                <?php foreach ($companies as $company): ?>
                                    <option value="<?php echo $company['id']; ?>" <?php if ($company['id'] == $user['company_id']) echo 'selected'; ?>>
                                        <?php echo $company['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>İsim</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Soyisim</label>
                            <input type="text" name="surname" class="form-control" value="<?php echo $user['surname']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Şifre (Güncellemek istemiyorsanız boş bırakın)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bakiye</label>
                            <input type="number" name="balance" class="form-control" value="<?php echo $user['balance']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rol</label>
                            <select name="role" class="form-control" required>
                                <option value="1" <?php if ($user['role'] == 1) echo 'selected'; ?>>Kullanıcı</option>
                                <option value="2" <?php if ($user['role'] == 2) echo 'selected'; ?>>Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Kullanıcı Güncelle</button>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>
