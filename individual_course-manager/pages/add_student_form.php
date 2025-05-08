<?php
/**
 * Форма добавления студента.
 *
 * Доступна только администраторам. После заполнения отправляет данные методом POST
 * в обработчик ../actions/add_student.php.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../templates/header.php';

// 🔐 Проверка прав доступа администратора
if (!isAdmin()) {
    die("⛔ Только администратор может добавлять студентов.");
}
?>

<div class="container mt-4">
  <h2>Добавить студента</h2>

  <form method="POST" action="../actions/add_student.php" class="card p-4">
    <!-- Поле имени -->
    <div class="mb-3">
      <label class="form-label">Имя</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <!-- Поле email -->
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <!-- Поле возраста -->
    <div class="mb-3">
      <label class="form-label">Возраст</label>
      <input type="number" name="age" class="form-control" min="15" max="100" required>
    </div>

    <!-- Выбор группы -->
    <div class="mb-3">
      <label class="form-label">Группа</label>
      <select name="group" class="form-select" required>
        <option value="">Выберите группу</option>
        <option value="IA2304">IA2304</option>
        <option value="IA2303">IA2303</option>
        <option value="I2301">I2301</option>
      </select>
    </div>

    <!-- Пол -->
    <div class="mb-3">
      <label class="form-label">Пол</label><br>
      <div class="form-check form-check-inline">
        <input type="radio" name="gender" value="male" class="form-check-input" required>
        <label class="form-check-label">Мужской</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="radio" name="gender" value="female" class="form-check-input" required>
        <label class="form-check-label">Женский</label>
      </div>
    </div>

    <!-- Активный студент -->
    <div class="mb-3 form-check">
      <input type="checkbox" name="active" class="form-check-input">
      <label class="form-check-label">Активный студент</label>
    </div>

    <!-- Кнопки -->
    <button class="btn btn-success">Добавить</button>
    <a href="students.php" class="btn btn-secondary">Отмена</a>
  </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
