### Лабораторная работа №2: Управляющие конструкции

 Цель работы
Освоить использование условных конструкций и циклов в PHP.

 Задание
 
 Условные конструкции
 
В этой части задания необходимо создать таблицу с расписанием, которая будет формироваться на основе текущего дня недели с использованием функции `date()`.

- Для John Styles:
  - Если текущий день — понедельник, среда или пятница, выводится график работы 8:00-12:00.
  - В остальные дни недели выводится текст Нерабочий день.

- Для Jane Doe:
  - Если текущий день — вторник, четверг или суббота, выводится график работы 12:00-16:00.
  - В остальные дни недели выводится текст Нерабочий день.

### Циклы
Необходимо реализовать три цикла:
1. Цикл `for` — с добавлением промежуточных значений переменных `$a` и `$b` на каждом шаге.
2. Цикл `while` — с аналогичным функционалом.
3. Цикл `do-while` — с аналогичным функционалом.

Каждый цикл должен выводить промежуточные значения переменных и результат выполнения после завершения цикла.

#### Код в файле `index.php`:

```php
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
```

В файл `index1.php` добавлены следующие реализации циклов:

```php
<h3>Цикл for</h3>
<?php
    $a = 0;
    $b = 0;
// Цикл for выполняется от 0 до 5 включительно
    for ($i = 0; $i <= 5; $i++) {
// В каждом шаге цикла увеличиваем переменные $a и $b
        $a += 10;
        echo "a = $a, ";
        $b += 5;
        echo "b = $b<br>";
    }

    echo "End of the loop: a = $a, b = $b<br>";
?>

<h3>Цикл while</h3>
<?php
    $i = 0;
    $a = 0;
    $b = 0;
// Цикл while выполняется, пока условие $i <= 5 истинно
    while ($i <= 5) {
        $a += 10;
        $b += 5;
        echo "a = $a, b = $b<br>"; // Выводим промежуточные значения
        $i++;
    }
    echo "End of the loop: a = $a, b = $b<br>";
?>

<h3>Цикл do-while</h3>
<?php
    $i = 0;
    $a = 0;
    $b = 0;
 // Цикл do-while сначала выполняет тело цикла, а затем проверяет условие
    do {
        $a += 10;
        $b += 5;
        echo "a = $a, b = $b<br>"; // Выводим промежуточные значения
        $i++;
    } while ($i <= 5);
   echo "End of the loop: a = $a, b = $b<br>";
?>
```
### Контрольные вопросы
Разница между циклами for, while и do-while:

Цикл for используется, когда количество итераций известно заранее.
Цикл while используется, когда условие проверяется перед каждой итерацией, и цикл выполняется, пока условие истинно.
Цикл do-while гарантирует, что тело цикла будет выполнено хотя бы один раз, так как условие проверяется после выполнения тела цикла.

Как работает тернарный оператор ? : в PHP? Тернарный оператор представляет собой сокращенную форму условного оператора if-else. Синтаксис: условие ? выражение_если_истинно : выражение_если_ложно.

Что произойдет, если в do-while поставить условие, которое изначально ложно? В этом случае тело цикла выполнится хотя бы один раз, поскольку условие проверяется только после выполнения тела цикла.
