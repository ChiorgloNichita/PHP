<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../includes/log_action.php';

$id = $_GET['id'] ?? null;
if (!$id) die('Не передан ID');

$stmt = $eduPdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();
if (!$student) die('Студент не найден');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $upd = $eduPdo->prepare("UPDATE students SET name = ?, email = ? WHERE id = ?");
    $upd->execute([$name, $email, $id]);
    logAction("Обновлён студент ID $id");
    header("Location: students.php");
    exit;
}
?>
<?php require_once __DIR__ . "/templates/header.php"; ?>
<h1>Редактировать студента</h1>
<form method="post" class="card p-4">
  <div class="mb-3">
    <label class="form-label">Имя</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
  </div>
  <button class="btn btn-primary">Сохранить</button>
  <a href="pages/students.php" class="btn btn-secondary">Отмена</a>
</form>
<?php require_once __DIR__ . "/templates/footer.php"; ?>