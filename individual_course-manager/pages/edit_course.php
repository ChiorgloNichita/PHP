<?php
/**
 * Страница редактирования курса.
 *
 * Доступ разрешён только пользователю с ролью "admin".
 * Загружает данные курса по ID, отображает форму и сохраняет изменения.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../includes/log_action.php';
require_once __DIR__ . '/../templates/header.php';

// Получаем токен из cookies
$token = $_COOKIE['auth_token'] ?? null;

// Проверка токена и прав администратора
if (!$token) {
    header("Location: login.php");
    exit;
}

$stmt = $authPdo->prepare("SELECT * FROM users WHERE token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user || $user['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Получение ID курса
$id = $_GET['id'] ?? null;
if (!$id) {
    die('❌ Не передан ID курса.');
}

// Получение данных курса
$stmt = $eduPdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$id]);
$course = $stmt->fetch();

if (!$course) {
    die('❌ Курс не найден.');
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $desc  = trim($_POST['description'] ?? '');

    // Минимальная валидация
    if ($title === '') {
        die('❌ Название не может быть пустым.');
    }

    // Обновление записи
    $update = $eduPdo->prepare("UPDATE courses SET title = ?, description = ? WHERE id = ?");
    $update->execute([$title, $desc, $id]);

    // Логирование действия
    logAction("Обновлён курс ID $id: $title");

    // Перенаправление
    header("Location: index.php");
    exit;
}
?>

<h1 class="mb-4">Редактировать курс</h1>

<form method="post" class="card p-4">
  <div class="mb-3">
    <label class="form-label">Название</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course['title']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Описание</label>
    <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($course['description']) ?></textarea>
  </div>

  <button class="btn btn-primary">💾 Сохранить</button>
  <a href="index.php" class="btn btn-secondary">← Отмена</a>
</form>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
