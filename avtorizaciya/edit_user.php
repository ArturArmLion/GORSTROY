<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GORSTROY";

$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = '$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $role = htmlspecialchars(trim($_POST['role']));

    $sql = "UPDATE users SET username = '$username', email = '$email', role = '$role' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать пользователя</title>
</head>
<body>
    <h2>Редактировать пользователя</h2>
    <form method="POST" action="edit_user.php?id=<?php echo $id; ?>">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

        <label for="role">Роль:</label>
        <select id="role" name="role">
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Админ</option>
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>Пользователь</option>
        </select><br><br>

        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>
