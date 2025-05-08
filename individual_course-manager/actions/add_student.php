<?php
/**
 * Страница для добавления нового студента.
 *
 * Эта страница позволяет администраторам добавлять новых студентов в систему.
 * Форма содержит поля для ввода имени, email, возраста, группы, пола и статуса активности студента.
 * Данные проверяются на стороне сервера перед добавлением в базу данных.
 * 
 * @return void
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../includes/log_action.php';

/**
 * Проверка, является ли пользователь администратором.
 *
 * Эта функция проверяет, есть ли у пользователя роль "admin". Если нет, доступ к странице будет закрыт.
 * 
 * @return void
 */
if (!isAdmin()) {
    die("⛔ Только администратор может добавлять студентов.");
}

$errors = []; // Массив для хранения ошибок

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение и очистка данных из формы
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $group = trim($_POST['group'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $active = isset($_POST['active']) ? 1 : 0;

    // Валидация данных
    if (!$name) $errors[] = "Имя обязательно.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Неверный email.";
    if ($age < 15 || $age > 100) $errors[] = "Возраст от 15 до 100.";
    if (!$group) $errors[] = "Группа обязательна.";
    if (!in_array($gender, ['male', 'female'])) $errors[] = "Укажите пол.";

    // Если нет ошибок, добавляем студента в базу данных
    if (empty($errors)) {
        // Подготовка SQL-запроса для добавления студента
        $stmt = $eduPdo->prepare("INSERT INTO students (name, email, age, group_name, gender, active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $age, $group, $gender, $active]);
        
        // Логируем действие
        logAction("Добавлен студент: $name");

        // Перенаправление на страницу списка студентов
        header("Location: ../pages/students.php");
        exit;
    }
}
?>

<div class="container mt-4">
  <h2>Добавить студента</h2>

  <!-- Вывод ошибок, если они есть -->
  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errors as $err): ?>
          <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- Форма добавления студента -->
  <form method="POST" class="card p-4">
    <div class="mb-3">
      <label class="form-label">Имя</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Возраст</label>
      <input type="number" name="age" class="form-control" min="15" max="100" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Группа</label>
      <select name="group" class="form-select" required>
        <option value="">Выберите группу</option>
        <option value="ИС-221">IA2304</option>
        <option value="ИС-222">IA2303</option>
        <option value="ИС-223">I2301</option>
      </select>
    </div>

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

    <div class="mb-3 form-check">
      <input type="checkbox" name="active" class="form-check-input">
      <label class="form-check-label">Активный студент</label>
    </div>

    <button class="btn btn-success">Добавить</button>
    <a href="../pages/students.php" class="btn btn-secondary">Отмена</a>
  </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
