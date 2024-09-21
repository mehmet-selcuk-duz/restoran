<?php
 require_once "header.php"; 

 if (!$isAuthorized)
 {
     header("Location: index.php");
 }
 
require_once "../system/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $company_id = $_POST['company_id'];
    $role = $_POST['role'];
    $balance = $_POST['balance'];
    $password = md5($_POST['password']);

    $query = "INSERT INTO users (username, name, surname, company_id, role, balance, password) 
              VALUES (:username, :name, :surname, :company_id, :role, :balance, :password)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'username' => $username,
        'name' => $name,
        'surname' => $surname,
        'company_id' => $company_id,
        'role' => $role,
        'balance' => $balance,
        'password' => $password
    ]);

    if ($stmt) {
        $success_message = "Kullanıcı başarıyla eklendi.";
        header("Refresh: 2; url=users.php");
    } else {
        $error_message = "Kullanıcı eklenirken bir hata oluştu.";
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
            <li class="breadcrumb-item active">Kullanıcı Ekle</li>
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
                <h2><i class="fa fa-file"></i>Kullanıcı Ekle</h2>
            </div>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kullanıcı Adı</label>
                            <input type="text" name="username" class="form-control" required>
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
                            <label>İsim</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Soyisim</label>
                            <input type="text" name="surname" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Şifre</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bakiye</label>
                            <input type="number" name="balance" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rol</label>
                            <select name="role" class="form-control" required>
                                <option value="1">Kullanıcı</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Kullanıcı Ekle</button>
            </form>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>
