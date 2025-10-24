<?php
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, переданы ли данные в POST-запросе
    $name = isset($_POST['name']) ? trim($_POST['name']) : "";
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : "";

    if (empty($name) || empty($phone)) {
        $error_message = "Пожалуйста, заполните все поля.";
    } else {
        $servername = "localhost"; // Адрес сервера базы данных
        $username = "root"; // Логин
        $password = ""; // Пароль
        $dbname = "GORSTROY"; // Имя базы данных

        // Подключение к базе данных
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка соединения
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Экранирование данных перед вставкой
        $name = $conn->real_escape_string($name);
        $phone = $conn->real_escape_string($phone);

        // SQL-запрос для вставки данных
        $sql = "INSERT INTO feedback (name, phone) VALUES ('$name', '$phone')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Данные успешно отправлены!";
        } else {
            $error_message = "Ошибка: " . $conn->error;
        }

        // Закрытие соединения
        $conn->close();
    }
}
?>