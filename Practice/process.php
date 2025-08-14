<?php
require_once 'db_connect.php';

// Устанавливаем заголовок для корректного отображения кириллицы
header('Content-Type: text/html; charset=utf-8');

try {
    // Получаем соединение с базой данных
    $pdo = getDBConnection();
    
    // Проверяем метод запроса
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Обработка данных формы
        $fullname = trim($_POST['fullname']);
        $class = trim($_POST['class']);
        $description = trim($_POST['description']);
        $symptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : [];
        
        // Валидация данных
        if (empty($fullname) || empty($class)) {
            throw new Exception("ФИО и класс обязательны для заполнения");
        }
        
        if (!preg_match('/^[А-ЯЁ][а-яё]+\s[А-ЯЁ][а-яё]+$/u', $fullname)) {
            throw new Exception("Неверный формат ФИО. Введите в формате 'Фамилия Имя'");
        }
        
        if (!preg_match('/^([1-9]|1[0-1])\s*[А-ЯЁ]$/u', $class)) {
            throw new Exception("Неверный формат класса. Введите в формате '2 А'");
        }
        
        if (strlen($description) > 1000) {
            throw new Exception("Описание не должно превышать 1000 символов");
        }
        
        // Преобразуем массив симптомов в строку для хранения в БД
        $symptomsStr = '{' . implode(',', $symptoms) . '}';
        
        // Подготавливаем SQL-запрос
        $stmt = $pdo->prepare("
            INSERT INTO student_health 
            (fullname, class, symptoms, description) 
            VALUES (:fullname, :class, :symptoms, :description)
        ");
        
        // Выполняем запрос с параметрами
        $stmt->execute([
            ':fullname' => $fullname,
            ':class' => $class,
            ':symptoms' => $symptomsStr,
            ':description' => $description
        ]);
        
        // Перенаправляем на страницу успеха
        header('Location: success.html');
        exit;
    } else {
        // Если запрос не POST, перенаправляем на главную
        header('Location: index.html');
        exit;
    }
} catch (PDOException $e) {
    // Обработка ошибок базы данных
    die("Ошибка базы данных: " . $e->getMessage());
} catch (Exception $e) {
    // Обработка других ошибок
    die("Ошибка: " . $e->getMessage());
} finally {
    // Закрываем соединение
    $pdo = null;
}
?>