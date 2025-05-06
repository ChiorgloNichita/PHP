<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../db/education.php';

$students = $eduPdo->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>

<h1 class="mb-4">Список студентов</h1>

<table class="table table-bordered">
    <thead>
        <tr><th>ID</th><th>Имя</th><th>Email</th></tr>
    </thead>
    <tbody>
        <?php foreach ($students as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <td><?= htmlspecialchars($s['email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2 class="mt-5">Добавить студента</h2>
<form method="post" action="../actions/add_student.php">
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

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
