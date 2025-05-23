<h3>Цикл for</h3>
<?php
$a = 0;
$b = 0;

// Цикл for выполняется от 0 до 5 включительно
for ($i = 0; $i <= 5; $i++) {
    $a += 10;
    $b += 5;

    // Выводим промежуточные значения a и b на каждом шаге цикла
    echo "Шаг $i: a = $a, b = $b<br>";
}

// Финальный результат после выполнения цикла
echo "End of the loop: a = $a, b = $b<br>";
?>

<h3>Цикл while</h3>
<?php
$i = 0;
$a = 0;
$b = 0;

// Цикл while выполняется, пока $i <= 5
while ($i <= 5) {
    $a += 10;
    $b += 5;

    // Выводим промежуточные значения a и b на каждом шаге цикла
    echo "Шаг $i: a = $a, b = $b<br>";
    
    $i++;
}

// Финальный результат после выполнения цикла
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

    // Выводим промежуточные значения a и b на каждом шаге цикла
    echo "Шаг $i: a = $a, b = $b<br>";
    
    $i++;
} while ($i <= 5);

// Финальный результат после выполнения цикла
echo "End of the loop: a = $a, b = $b<br>";
?>
