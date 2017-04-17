<?php
//Получить  все  четырехзначные  числа,  сумма  цифр  которых  равна заданному числу  n.
$n = 5;

    for ($i=1000; $i < 10000; $i++) {
    $sum = 0;
    $number = $i;

        while ($number != 0) {
            $sum += $number % 10;
            $number = (int) ($number / 10);
        }

        if ($sum == $n) {
            echo "$i <br>";
        }
    }



?>