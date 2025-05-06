<?php
require_once __DIR__ . '/../includes/auth.php';

$query = $_GET['q'] ?? '';
$students = [];

if ($query !== '') {
    $stmt = $eduPdo->prepare("SELECT * FROM students WHERE name LIKE ?");
    $stmt->execute(["%$query%"]);
    $students = $stmt->fetchAll();
} else {
    $stmt = $eduPdo->query("SELECT * FROM students");
    $students = $stmt->fetchAll();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '' || $email === '') {
        $error = 'Пожалуйста, заполните все поля.';
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
  <h2 class="mb-3">Список студентов</h2>

  <!-- Поиск -->
  <form method="get" class="mb-3 d-flex" role="search">
    <input type="text" name="q" value="<?= htmlspecialchars($query) ?>" class="form-control me-2" placeholder="Поиск по имени...">
    <button class="btn btn-outline-primary">Найти</button>
    <?php if ($query): ?>
      <a href="students.php" class="btn btn-outline-secondary ms-2">Сброс</a>
    <?php endif; ?>
  </form>

  <!-- Таблица -->
  <table class="table table-bordered table-striped">
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

  <h4 class="mt-5">Добавить студента</h4>
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
