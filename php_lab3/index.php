<?php
/**
 * Путь к директории с изображениями.
 *
 * @var string
 */
$dir = 'image/';

/**
 * Получение списка файлов из директории.
 *
 * Проверка, существует ли директория, и получение всех файлов, если директория существует. Если директория не найдена, создается пустой массив.
 *
 * @var array Массив файлов из директории.
 */
if (is_dir($dir)) {
    $files = scandir($dir); // Получаем список файлов
    $files = array_diff($files, ['.', '..']); // Убираем служебные элементы
} else {
    $files = []; // Если директория не найдена, создаем пустой массив
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cats</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <p>About Cats | News | Contacts</p>
    </header>
    <main>
        <div class="gallery">
            <?php
            /**
             * Вывод всех файлов (без проверки типа).
             */
            if (!empty($files)) {
                foreach ($files as $file) {
                    echo "<div class='image'><img src='{$dir}{$file}' alt='Изображение'></div>";
                }
            } else {
                echo "<p>No images found.</p>";
            }
            ?>
        </div>
    </main>
    <footer>
        <p>USM © 2025</p>
    </footer>
</body>
</html>
