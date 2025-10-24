<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GORSTROY";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Обработка отправленной формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));
    $role = 'user'; // Все пользователи по умолчанию получают роль "user"

    // Проверка совпадения паролей
    if (!empty($username) && !empty($email) && !empty($password) && $password === $confirm_password) {
        // Хеширование пароля
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // SQL-запрос на добавление нового пользователя
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password_hash', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Регистрация успешна!";
            header("Location: login.php"); // Перенаправление на страницу входа
            exit();
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Пожалуйста, убедитесь, что пароли совпадают и заполните все поля.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../css/reg.css">
</head>
<body>
    <div class="form">
        
        <h2>Регистрация</h2>
        <form method="POST" action="register.php">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="confirm_password">Подтвердите пароль:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>

            <button type="submit">Зарегистрироваться</button>
            <button onclick="document.location='login.php'" type="submit">Войти</button>
        </form>
    </div>
</body>
</html>
