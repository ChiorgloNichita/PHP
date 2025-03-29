<?php
// Устанавливаем московский часовой пояс
date_default_timezone_set('Europe/Chisinau');

// Получаем текущий день недели в коротком формате (например: 'Mon', 'Tue')
$dayOfWeek = date('D');

// Графики работы по дням недели
$johnSchedule = (in_array($dayOfWeek, ['Mon', 'Wed', 'Fri'])) ? "8:00-12:00" : "Нерабочий день";
$janeSchedule = (in_array($dayOfWeek, ['Tue', 'Thu', 'Sat'])) ? "12:00-16:00" : "Нерабочий день";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание работы</title>
    <style>
        table {
            width: 40%;
            border-collapse: collapse;
        }
        th, td {
            border: 2px solid grey;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>Расписание работы</h2>
    <p>Сегодня: <?php echo date('d.m.Y (l)'); ?></p>

    <table>
        <tr>
            <th>№</th>
            <th>Фамилия Имя</th>
            <th>График работы</th>
        </tr>
        <tr>
            <td>1</td>
            <td>John Styles</td>
            <td><?php echo $johnSchedule; ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Doe</td>
            <td><?php echo $janeSchedule; ?></td>
        </tr>
    </table>

    <h2>Результаты циклов</h2>
    <?php include 'index1.php'; ?>

</body>
</html>
