<?php
session_start();
require_once '../system/config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['password'] === $password) {
            if ($user['role'] == 2) {
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            }elseif (!empty($user['company_id'])) {
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Yetki bulunamadı.";
            }
        } else {
            $error = "Şifre yanlış.";
        }
    } else {
        $error = "Kullanıcı bulunamadı.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lezzet Sepeti - Yönetim Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login {
            min-height: 100vh;
        }

        .bg-image {
            background-image: url('img/bg.png');
            background-size: cover;
            background-position: center;
        }

        .login-heading {
            font-weight: 300;
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h3 class="login-heading mb-4">Lezzet Sepeti Yönetim Paneli</h3>

                                <?php if ($error): ?>
                                    <div class="alert alert-danger error-message">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Kullanıcı Adı" required>
                                        <label for="floatingInput">Kullanıcı Adı</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Şifre" required>
                                        <label for="floatingPassword">Şifre</label>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Giriş Yap</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
