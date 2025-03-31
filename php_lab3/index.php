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
             * Проверка наличия изображений в директории и вывод изображений.
             *
             * Если в директории есть изображения (файлы), то выводятся изображения на страницу.
             * Если папка пуста или не найдена, выводится сообщение "No images found".
             */
            if (!empty($files)) { // Проверка на наличие файлов
                for ($i = 0; $i < count($files); $i++) {
                    if ($files[$i] !== "." && $files[$i] !== ".." && preg_match('/\.(jpg|jpeg|png|gif)$/i', $files[$i])) {
                        $path = $dir . $files[$i];
            ?>
            <div class="image">
                <img src="<?php echo $path ?>" alt="Изображение">
            </div>
            <?php
                    }
                }
            } else {
                echo "<p>No images found.</p>"; // Сообщение, если папка пуста или не найдена
            }
            ?>
        </div>
    </main>
    <footer>
        <p>USM © 2025</p>
    </footer>
</body>
</html>
