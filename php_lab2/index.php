
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
    <table>
        <tr>
            <th>№</th>
            <th>Фамилия Имя</th>
            <th>График работы</th>
        </tr>
        <?php
            // Определяем день недели
            $dayOfWeek = date('D');

            // Определяем график для John и Jane
            $johnSchedule = (in_array($dayOfWeek, ['Mon', 'Wed', 'Fri'])) ? "8:00-12:00" : "Нерабочий день";
            $janeSchedule = (in_array($dayOfWeek, ['Tue', 'Thu', 'Sat'])) ? "12:00-16:00" : "Нерабочий день";
        ?>
        <tr>
            <td>1</td>
            <td>John Styles</td>
            <td>
                <?php echo $johnSchedule; ?>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Doe</td>
            <td>
                <?php echo $janeSchedule; ?>
            </td>
        </tr>
    </table>

    <h2>Результаты циклов</h2>
    <?php include 'index1.php'; ?>
</body>
</html>

<?php
    // Получаем текущий день недели
    $dayOfWeek = date('l');  // Функция date() с параметром 'l' возвращает полный день недели (например, 'Monday').

    // Условие для John Styles
    if ($dayOfWeek == 'Monday' || $dayOfWeek == 'Wednesday' || $dayOfWeek == 'Friday') {
        // Если текущий день понедельник, среда или пятница, выводится график работы 8:00-12:00
        echo '<tr><td>John Styles</td><td>8:00-12:00</td></tr>';
    } else {
        // В остальные дни недели выводится текст "Нерабочий день"
        echo '<tr><td>John Styles</td><td>Нерабочий день</td></tr>';
    }

    // Условие для Jane Doe
    if ($dayOfWeek == 'Tuesday' || $dayOfWeek == 'Thursday' || $dayOfWeek == 'Saturday') {
        // Если текущий день вторник, четверг или суббота, выводится график работы 12:00-16:00
        echo '<tr><td>Jane Doe</td><td>12:00-16:00</td></tr>';
    } else {
        // В остальные дни недели выводится текст "Нерабочий день"
        echo '<tr><td>Jane Doe</td><td>Нерабочий день</td></tr>';
    }
?>