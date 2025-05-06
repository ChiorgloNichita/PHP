<?php require_once __DIR__ . '/../includes/auth.php'; ?>
<?php
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../includes/log_action.php';

// Обработка удаления записи
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    // Проверка, является ли пользователь администратором
    if (!isAdmin()) {  
        die("У вас нет прав для удаления записи.");
    }

    $student_id = (int)($_POST['student_id'] ?? 0);
    $course_id = (int)($_POST['course_id'] ?? 0);

    if ($student_id && $course_id) {
        $stmt = $eduPdo->prepare("DELETE FROM enrollments WHERE student_id = ? AND course_id = ?");
        $stmt->execute([$student_id, $course_id]);
        logAction("Удалена запись студента #$student_id с курса #$course_id");
        header("Location: enroll.php");
        exit;
    }
}

// Обработка добавления записи
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
    // Проверка, является ли пользователь администратором
    if (!isAdmin()) {  
        die("У вас нет прав для добавления записи.");
    }

    $student_id = (int)($_POST['student_id'] ?? 0);
    $course_id = (int)($_POST['course_id'] ?? 0);

    if ($student_id && $course_id) {
        $stmt = $eduPdo->prepare("INSERT IGNORE INTO enrollments (student_id, course_id) VALUES (?, ?)");
        $stmt->execute([$student_id, $course_id]);
        logAction("Студент #$student_id записан на курс #$course_id");
        header("Location: enroll.php");
        exit;
    }
}

// Получение всех студентов и курсов
$students = $eduPdo->query("SELECT * FROM students")->fetchAll();
$courses = $eduPdo->query("SELECT * FROM courses")->fetchAll();

// Фильтр по имени студента
$search = trim($_GET['search'] ?? '');
$query = "
    SELECT e.student_id, e.course_id, s.name AS student, c.title AS course
    FROM enrollments e
    JOIN students s ON e.student_id = s.id
    JOIN courses c ON e.course_id = c.id
";

if ($search !== '') {
    $stmt = $eduPdo->prepare($query . " WHERE s.name LIKE ?");
    $stmt->execute(['%' . $search . '%']);
    $enrollments = $stmt->fetchAll();
} else {
    $enrollments = $eduPdo->query($query)->fetchAll();
}
?>

<h1 class="mb-4">Записать студента на курс</h1>

<form method="post" class="row g-3 mb-4">
    <div class="col-md-5">
        <label class="form-label">Студент</label>
        <select name="student_id" class="form-select" required>
            <option value="">Выберите студента</option>
            <?php foreach ($students as $s): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-5">
        <label class="form-label">Курс</label>
        <select name="course_id" class="form-select" required>
            <option value="">Выберите курс</option>
            <?php foreach ($courses as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" name="enroll" class="btn btn-primary w-100">Записать</button>
    </div>
</form>

<h2 class="mb-3">Записи</h2>

<form method="get" class="mb-3 d-flex gap-2">
    <input type="text" name="search" class="form-control" placeholder="Поиск по имени студента" value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-secondary">Найти</button>
    <a href="pages/enroll.php" class="btn btn-outline-secondary">Сброс</a>
    <a href="pages/enroll.php?export=csv" class="btn btn-success">Экспорт в CSV</a>
</form>

<table class="table table-bordered">
    <thead><tr><th>Студент</th><th>Курс</th><th>Действие</th></tr></thead>
    <tbody>
        <?php foreach ($enrollments as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['student']) ?></td>
                <td><?= htmlspecialchars($e['course']) ?></td>
                <td>
                    <?php if (isAdmin()): ?>
                        <!-- Удаление доступно только администратору -->
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="student_id" value="<?= $e['student_id'] ?>">
                            <input type="hidden" name="course_id" value="<?= $e['course_id'] ?>">
                            <button type="submit" name="delete" class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">Удаление недоступно</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
