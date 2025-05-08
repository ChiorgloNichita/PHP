<?php
/**
 * Страница отображения студентов, записанных на выбранный курс.
 *
 * Получает ID курса через GET, извлекает название курса и список студентов,
 * записанных на него, через таблицу `enrollments`.
 * 
 * Доступна авторизованным пользователям.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../templates/header.php';

// Получение ID курса из URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("❌ ID курса не передан");
}

// Получение информации о курсе
$courseStmt = $eduPdo->prepare("SELECT * FROM courses WHERE id = ?");
$courseStmt->execute([$id]);
$courseData = $courseStmt->fetch();

if (!$courseData) {
    die("❌ Курс не найден");
}

// Получение студентов, записанных на курс
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
      <?php foreach ($students as $student): ?>
        <tr>
          <td><?= htmlspecialchars($student['name']) ?></td>
          <td><?= htmlspecialchars($student['email']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <div class="alert alert-info">На этот курс ещё никто не записан.</div>
<?php endif; ?>

<a href="../index.php" class="btn btn-secondary">← Назад к курсам</a>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
