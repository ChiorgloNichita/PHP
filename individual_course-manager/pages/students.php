<?php
/**
 * Страница отображения списка студентов.
 *
 * Доступна всем авторизованным пользователям. Администраторы могут добавлять,
 * редактировать и удалять студентов.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../db/education.php';

// Получаем всех студентов
$students = $eduPdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>

<h1 class="mb-4">📋 Список студентов</h1>

<!-- Кнопка добавления (только для администратора) -->
<?php if (isAdmin()): ?>
  <p>
    <a class="btn btn-main mb-3" href="../pages/add_student_form.php">
      ➕ Добавить студента
    </a>
  </p>
<?php endif; ?>

<!-- Таблица студентов -->
<div class="table-responsive">
  <table class="students-table table table-bordered table-striped bg-white">
    <thead>
      <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Возраст</th>
        <th>Группа</th>
        <th>Пол</th>
        <th>Активен</th>
        <?php if (isAdmin()): ?><th>Действие</th><?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $s): ?>
        <tr>
          <td><?= $s['id'] ?></td>
          <td><?= htmlspecialchars($s['name']) ?></td>
          <td><?= htmlspecialchars($s['email']) ?></td>
          <td><?= htmlspecialchars($s['age']) ?></td>
          <td><?= htmlspecialchars($s['group_name']) ?></td>
          <td><?= $s['gender'] === 'male' ? 'Мужской' : 'Женский' ?></td>
          <td><?= $s['active'] ? 'Да' : 'Нет' ?></td>

          <?php if (isAdmin()): ?>
            <td class="d-flex gap-2">
              <!-- Кнопка редактирования -->
              <a href="edit_student.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-warning" title="Редактировать">
                <i class="fas fa-edit"></i>
              </a>

              <!-- Кнопка удаления -->
              <form method="post" action="../actions/delete_student.php" onsubmit="return confirm('Удалить студента?');" style="display:inline;">
                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                <button class="btn btn-sm btn-danger" title="Удалить">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
