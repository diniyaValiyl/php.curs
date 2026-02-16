<!DOCTYPE html>
<html>
<head>
    <title>привет</title>
</head>
<body>
    <p>привет</p>
    
    <?php
        echo "<p><strong>Текущая дата и время:</strong> " . date('d.m.Y H:i:s') . "</p>";

    $name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';
    $role = isset($_GET['role']) ? htmlspecialchars($_GET['role']) : '';
    
    if ($name != '') {
        echo "<p>приве, ";
        if ($role == 'admin') {
            echo "админ ";
        }
        echo "$name!</p>";
    } else {
        echo "<p>ты гость?</p>";
    }
    ?>

    <p><em> добавьте в URL свое имя для работы: ?name=ВашеИмя&role=admin</em></p>
    
    <h3>Информация о запросе:</h3>
    <p>Метод: <?php echo $_SERVER['REQUEST_METHOD']; ?></p>
    <p>Полный URI: <?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?></p>
    
    <h3>Server Data:</h3>
    <ul>
        <?php
        echo "<li><strong>Ваш IP:</strong> " . $_SERVER['REMOTE_ADDR'] . "</li>";
        echo "<li><strong>Сервер:</strong> " . $_SERVER['SERVER_NAME'] . "</li>";
        echo "<li><strong>Порт сервера:</strong> " . $_SERVER['SERVER_PORT'] . "</li>";
        echo "<li><strong>Метод запроса:</strong> " . $_SERVER['REQUEST_METHOD'] . "</li>";
        echo "<li><strong>Протокол:</strong> " . $_SERVER['SERVER_PROTOCOL'] . "</li>";
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            echo "<li><strong>Браузер:</strong> " . $_SERVER['HTTP_USER_AGENT'] . "</li>";
        }
        ?>
    </ul>
</body>
</html>