<?php
function getDBConnection() {
    $dsn = 'pgsql:host=localhost;port=5432;dbname=school_health;user=school_user;password=123123123';
    
    try {
        $dbh = new PDO($dsn);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    } catch (PDOException $e) {
        die("Ошибка подключения: " . $e->getMessage());
    }
}

// Проверка подключения
if (basename(__FILE__) == 'db_connect.php') {
    header('Content-Type: text/plain; charset=utf-8');
    try {
        $conn = getDBConnection();
        echo "Успешное подключение к PostgreSQL через PDO!";
        $conn = null;
    } catch (PDOException $e) {
        echo "Ошибка PDO: " . $e->getMessage();
    }
}
?>