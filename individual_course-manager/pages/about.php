<?php
/**
 * Страница "О проекте".
 *
 * Отображает список доступных курсов, полученных из базы данных SQLite (education.php).
 * Доступна без авторизации.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../db/education.php'; // подключение к базе данных
require_once __DIR__ . '/../templates/header.php'; // подключение шаблона шапки

// Получаем список курсов
$courses = $eduPdo->query("SELECT * FROM courses ORDER BY id DESC")->fetchAll();
?>

<h1 class="mb-4">📚 О проекте «Менеджер Курсов»</h1>
<p>Это общедоступная страница. Здесь вы можете ознакомиться с курсами, которые предлагаются системой.</p>

<?php if (count($courses) > 0): ?>
  <div class="row">
    <?php foreach ($courses as $course): ?>
      <div class="col-md-6 fade-in">
        <div class="course-card mb-3">
          <strong><?= htmlspecialchars($course['title']) ?></strong><br>
          <small><?= htmlspecialchars($course['description']) ?></small>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="text-muted">Нет доступных курсов.</p>
<?php endif; ?>

<hr>
<a href="../login.php" class="btn btn-outline-primary">🔐 Войти в систему</a>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
