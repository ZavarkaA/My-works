<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Театр</title>
    <link rel="stylesheet" href="GeneralCSS.CSS">
    <style>
          @import url('https://fonts.googleapis.com/css2?family=Marck+Script&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
		.menu-right {
			display: block;
		}
		.menu-button.mobile {
			display: none;
		}
        @media (max-width: 72em) {
            .main-container {
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                align-items: flex-start;
            }
            
            .menu-left, .menu-right {
                width: 100px;
                order: 0;
                flex-shrink: 0;
            }
            
			.menu-right {
				display: none;
			}
			
			.menu-button.mobile {
				display: block;
			}
			
            .content-wrapper {
                order: 1;
                flex: 1;
                margin-left: 0;
                min-width: 0;
            }
            
            .content-blocks {
                height: 100%;
            }
            
            .content-block2 {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header>
        <img class="logo" src="Лого2.png" alt="Логотип театра">
        <div class="page-title">Театр</div>
    </header>
    
    <div class="main-container">
    <div class="menu-left">
            <button class="menu-button" onclick="self.location.href='General.html'">Главная</button>
            <button class="menu-button" onclick="self.location.href='news.html'">Новости</button>
            <button class="menu-button mobile" onclick="self.location.href='history.html'">История</button>
            <button class="menu-button mobile" onclick="self.location.href='contacts.php'">Контакты</button>
        </div>
        
       <div class="menu-right">
       <button class="menu-button1" onclick="self.location.href='history.html'">История</button>
       <button class="menu-button1" onclick="self.location.href='contacts.php'">Контакты</button>        </div>
        
        <div class="content-wrapper">
            <div class="content-blocks">
                <div class="content-block1">
                    <p><b>Контакты</b></p>
                    
                    <?php
                    $host = "localhost";
                    $port = "5432";
                    $dbname = "theater";
                    $user = "Admin";
                    $password = "123123123";
                    
                    try {
                        $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        // Запрос данных из таблицы contacts
                        $query = "SELECT id, phone_num, email FROM contacts ORDER BY id";
                        $stmt = $db->query($query);
                        
                        if ($stmt && $stmt->rowCount() > 0) {
                            echo '<table class="contacts-table">';
                            echo '<thead><tr>';
                            echo '</tr></thead>';
                            echo '<tbody>';
                            
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<tr >';
                                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['phone_num']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                echo '</tr>';
                            }
                            
                            echo '</tbody></table>';
                        } else {
                            echo '<p style="text-align: center;">Нет данных о контактах</p>';
                        }
                    } catch (PDOException $e) {
                        echo '<p style="text-align: center; color: red;">Ошибка при получении контактов: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                    ?>
                </div>
                <div class="content-block2">
                <p><b>Контакты</b></p>
                <div class="map">
                    <script type="text/javascript"
                    charset="utf-8"
                    async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aef1a939703887d81abc4dd047873317ba6e95cf1d723c80b99768d9206bf317e&amp;
                    width=1000&amp;
                    height=1000&amp;
                    lang=ru_RU&amp;
                    scroll=true">
                </script>
                </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <div class="ssilki">
            <a href="https://vk.com/dzav2000"><img class="vk" src="Вк Надпись.png" alt="ВКонтакте"></a> 
            <a href="https://t.me/ZavarkaAa23"><img class="tg" src="Тг просто.png" alt="Telegram"></a>
            <a href="#"><img class="yt" src="YT.png" alt="YouTube"></a>
        </div>
    </footer>
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function navigate(url) {
            window.location.href = url;
        }
    </script>
</body>
</html>