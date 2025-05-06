<?php require_once __DIR__ . "/includes/auth.php"; ?>
<?php require_once __DIR__ . "/templates/header.php"; ?>
<?php require_once __DIR__ . "/db/education.php";

$courses = $eduPdo->query("SELECT * FROM courses ORDER BY id DESC")->fetchAll();
?>

<h1 class="mb-4">Список курсов</h1>

<div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($courses as $index => $c): ?>
        <div class="col">
            <div class="card h-100 shadow-sm fade-in" style="animation-delay: <?= $index * 0.1 ?>s;">
                <div class="card-body">
                    <p class='card-text mb-2'><strong>ID:</strong> <?= $c['id'] ?></p>
                    <p class='card-text mb-2'><strong>Название:</strong> <?= htmlspecialchars($c['title']) ?></p>
                    <p class='card-text mb-2'><strong>Описание:</strong> <?= htmlspecialchars($c['description']) ?></p>
                    <p class='card-text'>
                        <a href="pages/course_students.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-info">👥 Студенты</a>
                        <a href="pages/edit_course.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-secondary ms-2">✏️ Редактировать</a>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<h2 class="mt-5">Добавить курс</h2>
<form method="post" action="actions/add_course.php">
    <div class="mb-3">
        <label class="form-label">Название</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Описание</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Добавить</button>
</form>

<?php require_once __DIR__ . "/templates/footer.php"; ?>
