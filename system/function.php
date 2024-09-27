<?php
session_start();

require_once "../system/config.php";

if(isset($_POST["islem"]))
{
    $islem = $_POST["islem"];
}elseif(isset($_GET["islem"]))
{
    $islem = $_GET["islem"];
}else
{
    header("Location: / ");
    exit();
}

if($islem == "login")
{
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['password'] === $password) 
        {
                $_SESSION['username'] = $username;
                header("Location: /index.php");
                exit();
        } else {
            header("Location: /index.php?hata=Şifre Yanlış");
        }
    } else {
        header("Location: /index.php?hata=Kullanıcı Bulunamadı");
    }
}elseif($islem == "account-edit")
{
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $id = $_POST['u_id'];

    $query = "UPDATE users SET name = ?, surname = ?, username = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $surname, $username, $id]);

    header("Location: /account.php?success=1");
    exit;
}elseif($islem == "password-update")
{
    $password = $_POST['password'];
    $rpassword = $_POST['r-password'];
    $id = $_POST['u_id'];

    if($password == $rpassword)
    {
        $pass = md5($password);
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$pass, $id]);

        header("Location: /account.php?success=Başarılı");
        exit;
    }else
    {
        header("Location: /account.php?error=Şifreler Uyuşmuyor");
    }
}elseif($islem == "balance-add")
{
    $tutar = $_POST['tutar'];
    $exbalance = $_POST['ex_balance'];
    $id = $_POST['u_id'];

    $newbalance = $exbalance + $tutar;
    $query = "UPDATE users SET balance = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$newbalance, $id]);

    header("Location: /account.php?success=Başarılı");
    exit;
   
}elseif($islem == "basket-add")
{
    $user_id = $_POST["u_id"];
    $food_id = $_POST['food_id'];
    $quantity = $_POST['quantity'];
    $note = $_POST['note'];

    $stmt = $pdo->prepare("INSERT INTO basket (user_id, food_id, quantity, note) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $food_id, $quantity, $note]);

    header("Location: /cart.php");
    exit();
}elseif($islem == "basket-delete")
{
    $id = $_GET["id"];

    $sql = "DELETE FROM basket WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: /cart.php");
    exit();
}elseif($islem == "order")
{
    $user_id = $_GET["u_id"];
    $total = $_GET["total"];

    $basket_query = "SELECT * FROM basket WHERE user_id = :user_id";
    $stmt = $pdo->prepare($basket_query);
    $stmt->execute(['user_id' => $user_id]);
    $basket_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $food_id = $basket_items[0]['food_id'];

    $food_query = "SELECT restaurant_id FROM food WHERE id = :food_id";
    $stmt = $pdo->prepare($food_query);
    $stmt->execute(['food_id' => $food_id]);
    $food = $stmt->fetch(PDO::FETCH_ASSOC);

    $restaurant_id = $food['restaurant_id'];

    $stmt = $pdo->prepare("INSERT INTO `order` (user_id, restaurant_id, order_status, total_price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $restaurant_id, 1, $total]);

    $order_id = $pdo->lastInsertId();

    foreach ($basket_items as $item) {
        $food_id = $item['food_id'];
        $quantity = $item['quantity'];
        $note = $item['note'];

        $food_query = "SELECT price FROM food WHERE id = :food_id";
        $stmt = $pdo->prepare($food_query);
        $stmt->execute(['food_id' => $food_id]);
        $food = $stmt->fetch(PDO::FETCH_ASSOC);

        $price = $food['price'] * $quantity;

        $order_items_query = "INSERT INTO order_items (order_id, food_id, quantity, price, note) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($order_items_query);
        $stmt->execute([$order_id, $food_id, $quantity, $price, $note]);
    }

    $clear_basket_query = "DELETE FROM basket WHERE user_id = :user_id";
    $stmt = $pdo->prepare($clear_basket_query);
    $stmt->execute(['user_id' => $user_id]);

    header("Location: /confirm.php");
    exit();
}elseif($islem == "add-review")
{
    $restaurant_id = $_POST['restaurant_id'];
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $score = $_POST['score'];

    $stmt = $pdo->prepare("INSERT INTO comments (restaurant_id, user_id, tittle, description, score) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$restaurant_id, $user_id, $title, $description, $score]);

    header("Location: /detail.php?id=" . $restaurant_id);
    exit();
}elseif($islem == "register")
{
    $username = $_POST['username'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = md5($_POST['password']);
    $current_date = date('Y-m-d');

    $query = "INSERT INTO users (username, name, surname, password, created_at) 
              VALUES (:username, :name, :surname, :password, :created_at)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'username' => $username,
        'name' => $name,
        'surname' => $surname,
        'password' => $password,
        'created_at' => $current_date
    ]);

    if ($stmt) {
        header("Location: /login.php");
    } else {
        echo "Kullanıcı eklenirken bir hata oluştu.";
    }
}