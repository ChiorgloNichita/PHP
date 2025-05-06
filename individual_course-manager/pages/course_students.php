<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../templates/header.php';

$id = $_GET['id'] ?? null;
if (!$id) die("ID курса не передан");

$course = $eduPdo->prepare("SELECT * FROM courses WHERE id = ?");
$course->execute([$id]);
$courseData = $course->fetch();
if (!$courseData) die("Курс не найден");

$stmt = $eduPdo->prepare("
    SELECT s.* FROM students s
    JOIN enrollments e ON s.id = e.student_id
    WHERE e.course_id = ?
");
$stmt->execute([$id]);
$students = $stmt->fetchAll();
?>

<h1 class="mb-4">Студенты на курсе: <?= htmlspecialchars($courseData['title']) ?></h1>

<?php if (count($students) > 0): ?>
  <table class="table table-bordered bg-white">
    <thead>
      <tr>
        <th>Имя</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $s): ?>
        <tr>
          <td><?= htmlspecialchars($s['name']) ?></td>
          <td><?= htmlspecialchars($s['email']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <div class="alert alert-info">На этот курс ещё никто не записан.</div>
<?php endif; ?>

<a href="../index.php" class="btn btn-secondary">← Назад к курсам</a>


<?php require_once __DIR__ . '/../templates/footer.php'; ?>
