<h3>Цикл for</h3>
<?php
    $a = 0;
    $b = 0;

    for ($i = 0; $i <= 5; $i++) {
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

    do {
        $a += 10;
        $b += 5;
        echo "a = $a, b = $b<br>"; // Выводим промежуточные значения
        $i++;
    } while ($i <= 5);

    echo "End of the loop: a = $a, b = $b<br>";
?>
