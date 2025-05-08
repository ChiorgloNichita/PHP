<?php
/**
 * Страница отображения всех пользователей системы.
 *
 * Доступна только администраторам. Показывает ID, логин, роль и токен авторизации каждого пользователя.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../templates/header.php';

// Проверка прав администратора
if (!isAdmin()) {
    die('⛔ Доступ запрещён. Только для администраторов.');
}

// Получение всех пользователей
$users = $authPdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
?>

<h1 class="mb-4">👥 Пользователи системы</h1>

<div class="table-responsive">
  <table class="table table-bordered table-striped bg-white">
    <thead>
      <tr>
        <th>ID</th>
        <th>Логин</th>
        <th>Роль</th>
        <th>Токен</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= htmlspecialchars($u['login']) ?></td>
          <td><?= $u['role'] === 'admin' ? 'Администратор' : 'Пользователь' ?></td>
          <td><code><?= htmlspecialchars($u['token']) ?></code></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
