<?php
/**
 * Страница управления студентами.
 *
 * Позволяет искать студентов по имени, просматривать всех студентов и добавлять нового.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/education.php';

$searchTerm = $_GET['q'] ?? '';
$students = [];

// === Поиск студентов ===
if ($searchTerm !== '') {
    $stmt = $eduPdo->prepare("SELECT * FROM students WHERE name LIKE ?");
    $stmt->execute(["%$searchTerm%"]);
    $students = $stmt->fetchAll();
} else {
    $stmt = $eduPdo->prepare("SELECT * FROM students");
    $stmt->execute();
    $students = $stmt->fetchAll();
}

// === Обработка формы добавления студента ===
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '' || $email === '') {
        $error = '❌ Пожалуйста, заполните все поля.';
    } else {
        $stmt = $eduPdo->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
        $stmt->execute([$name, $email]);
        header('Location: students.php');
        exit;
    }
}
?>

<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4">
  <h2 class="mb-3">👨‍🎓 Список студентов</h2>

  <!-- Форма поиска -->
  <form method="get" class="mb-3 d-flex" role="search">
    <input type="text" name="q" value="<?= htmlspecialchars($searchTerm) ?>" class="form-control me-2" placeholder="Поиск по имени...">
    <button class="btn btn-outline-primary">Найти</button>
    <?php if ($searchTerm): ?>
      <a href="students.php" class="btn btn-outline-secondary ms-2">Сброс</a>
    <?php endif; ?>
  </form>

  <!-- Таблица студентов -->
  <table class="table table-bordered table-striped bg-white">
    <thead>
      <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $student): ?>
        <tr>
          <td><?= $student['id'] ?></td>
          <td><?= htmlspecialchars($student['name']) ?></td>
          <td><?= htmlspecialchars($student['email']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Форма добавления -->
  <h4 class="mt-5">➕ Добавить студента</h4>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post" class="mt-3">
    <div class="mb-3">
      <label class="form-label">Имя</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <button class="btn btn-success">Добавить</button>
  </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
