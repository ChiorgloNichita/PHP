<?php
/**
 * Страница редактирования студента (только для администратора).
 * 
 * Позволяет администратору изменить данные студента по ID.
 * После сохранения происходит перенаправление обратно к списку студентов.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../includes/auth.php';
if (!isAdmin()) {
    die('⛔ Только администратор может редактировать студентов.');
}

require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../includes/log_action.php';
require_once __DIR__ . '/../templates/header.php';

// Получение ID из GET
$id = $_GET['id'] ?? null;
if (!$id) die('❌ ID не передан');

// Получение данных студента из БД
$stmt = $eduPdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();
if (!$student) die('❌ Студент не найден');

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $age    = (int)($_POST['age'] ?? 0);
    $group  = trim($_POST['group'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $active = isset($_POST['active']) ? 1 : 0;

    // Обновление в БД
    $stmt = $eduPdo->prepare("
        UPDATE students
        SET name = ?, email = ?, age = ?, group_name = ?, gender = ?, active = ?
        WHERE id = ?
    ");
    $stmt->execute([$name, $email, $age, $group, $gender, $active, $id]);

    // Логирование действия
    logAction("Обновлён студент ID $id");

    // Перенаправление
    header("Location: students.php");
    exit;
}
?>

<div class="container mt-4">
  <h2>Редактировать студента</h2>

  <form method="POST" class="card p-4">
    <div class="mb-3">
      <label class="form-label">Имя</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Возраст</label>
      <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($student['age']) ?>" min="15" max="100" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Группа</label>
      <input type="text" name="group" class="form-control" value="<?= htmlspecialchars($student['group_name']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Пол</label><br>
      <div class="form-check form-check-inline">
        <input type="radio" name="gender" value="male" class="form-check-input" <?= $student['gender'] === 'male' ? 'checked' : '' ?>>
        <label class="form-check-label">Мужской</label>
      </div>
      <div class="form-check form-check-inline">
        <input type="radio" name="gender" value="female" class="form-check-input" <?= $student['gender'] === 'female' ? 'checked' : '' ?>>
        <label class="form-check-label">Женский</label>
      </div>
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" name="active" class="form-check-input" <?= $student['active'] ? 'checked' : '' ?>>
      <label class="form-check-label">Активный студент</label>
    </div>

    <button class="btn btn-success">Сохранить</button>
    <a href="students.php" class="btn btn-secondary">Отмена</a>
  </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
