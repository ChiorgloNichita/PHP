<?php
require_once __DIR__ . '/../db/education.php';

// Получаем токен из cookies
$token = $_COOKIE['auth_token'] ?? null;

// Проверяем, если токен существует, то извлекаем данные пользователя из базы
if ($token) {
    // Получаем пользователя по токену
    $stmt = $authPdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    // Если токен совпадает с пользователем и роль администратора
    if ($user && $user['role'] === 'admin') {
        // Логика редактирования курса
        $id = $_GET['id'] ?? null;
        if (!$id) die('Не передан ID');

        $stmt = $eduPdo->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        $course = $stmt->fetch();
        if (!$course) die('Курс не найден');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $desc = trim($_POST['description']);
            $upd = $eduPdo->prepare("UPDATE courses SET title = ?, description = ? WHERE id = ?");
            $upd->execute([$title, $desc, $id]);

            logAction("Обновлён курс ID $id");
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: login.php"); // Если не администратор, перенаправляем на страницу входа
        exit;
    }
} else {
    header("Location: login.php"); // Если нет токена, перенаправляем на страницу входа
    exit;
}
?>

<?php require_once __DIR__ . '/../templates/header.php'; ?>
<h1>Редактировать курс</h1>
<form method="post" class="card p-4">
  <div class="mb-3">
    <label class="form-label">Название</label>
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course['title']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Описание</label>
    <textarea name="description" class="form-control"><?= htmlspecialchars($course['description']) ?></textarea>
  </div>
  <button class="btn btn-primary">Сохранить</button>
  <a href="index.php" class="btn btn-secondary">Отмена</a>
</form>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>
