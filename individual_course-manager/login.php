<?php
/**
 * Страница входа в систему.
 *
 * Принимает логин и пароль, проверяет пользователя, генерирует токен авторизации
 * и сохраняет его в cookie и БД. Если вход успешен — перенаправляет на `about.php`.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/db/education.php';

$error = '';

// Обработка формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $error = 'Введите логин и пароль.';
    } else {
        // Поиск пользователя
        $stmt = $authPdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        // Проверка пароля
        if ($user && password_verify($password, $user['password'])) {
            // Генерация токена
            $token = bin2hex(random_bytes(32));
            setcookie('auth_token', $token, time() + 86400 * 7, '/'); // 7 дней

            // Сохранение токена в базе
            $stmt = $authPdo->prepare("UPDATE users SET token = ? WHERE id = ?");
            $stmt->execute([$token, $user['id']]);

            // Редирект
            header('Location: pages/about.php');
            exit;
        } else {
            $error = 'Неверный логин или пароль.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
<div class="card p-4 shadow" style="max-width:400px; width:100%;">
  <h4 class="mb-3">🔐 Вход в систему</h4>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Логин</label>
      <input type="text" name="login" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Пароль</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary w-100">Войти</button>
  </form>
</div>
</body>
</html>
