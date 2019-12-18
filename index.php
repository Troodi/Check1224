<?
$tiket_price = 60; // Цена билета
$plays = 1352078; // Общее число игр
$losses_games = 0; // Проиграно игр изначально
$won_games = 0; // Выиграно игр изначально
$losses_money = 0; // Проиграно игр изначально
$won_money = 0; // Выиграно игр изначально
$won_60 = 0; // Количество раз выиграно по 60 рублей изначально
$won_240 = 0; // Количество раз выиграно по 240 рублей изначально
$won_1200 = 0; // Количество раз выиграно по 1200 рублей изначально
$won_15k = 0; // Количество раз выиграно по 15к рублей изначально
$won_9kk = 0; // Количество раз выиграно по 9кк рублей изначально

$super_numbers = array();
$conbinations = array(); // Массив для подсчета наиболее часто встречающихся игр
for($i=0; $i<24; $i++){ // Запускаем цикл с 24 итерациями
  $conbinations[$i] = 0; // Заполняем нулями до 24
}

for($i=0; $i<$plays; $i++){ // Играем количество игр, указанных в $plays
  if($i % 100000 == 0){ // Отладочная инфа, если текущая игра кратна 10к
    echo $i.' '.PHP_EOL; // То выводим какой номер игры на экран
  }
  $user_numbers = generateNumbers(); // Генерируем случаные числа (как будто мы человек)
  $tiket_numbers = generateNumbers(); // Генерируем случаные числа (как будто мы сама лотерея)
  $overlap = 0; // Количество совпавших номеров

  $shooted = array(); // Массив для чисел, которые дали выигрыш

  foreach($user_numbers as $user_number){ // Перебираем все числа человека
    if(in_array($user_number, $tiket_numbers)){ // Если в лотереи и у пользователя есть совпадение числа
      $shooted[] = $user_number; // Записываем совпадающий номер в массив
      $overlap++; // Прибавляем единицу
    }
  }

  if($overlap == 8 || $overlap == 4){ // Если совпало 8 чисел или 4
    $won_60++; // Прибавляем единицу к количеству выигранных игр с прибылью 60 рублей
    $won_games++; // Прибавляем единицу к общему количеству выигранных игр
    $won_money += $tiket_price; // Прибавляем выигранную сумму у общему числу выигранных денег
  } elseif ($overlap == 9 || $overlap == 3) { // Если совпало 9 чисел или 3
    $won_240++; // Прибавляем единицу к количеству выигранных игр с прибылью 240 рублей
    $won_games++; // Прибавляем единицу к общему количеству выигранных игр
    $won_money += $tiket_price*4;
    luckyNumbers($shooted, $conbinations); //Записываем счастливые числа в массив
  } elseif ($overlap == 10 || $overlap == 2) { // Если совпало 10 чисел или 2
    $won_1200++; // Прибавляем единицу к количеству выигранных игр с прибылью 1200 рублей
    $won_games++; // Прибавляем единицу к общему количеству выигранных игр
    $won_money += $tiket_price*20; // Прибавляем выигранную сумму у общему числу выигранных денег
    luckyNumbers($shooted, $conbinations); //Записываем счастливые числа в массив
  } elseif ($overlap == 11 || $overlap == 1) { // Если совпало 11 чисел или 1
    $won_15k++; // Прибавляем единицу к количеству выигранных игр с прибылью 15к рублей
    $won_games++; // Прибавляем единицу к общему количеству выигранных игр
    $won_money += $tiket_price*250; // Прибавляем выигранную сумму у общему числу выигранных денег
    luckyNumbers($shooted, $conbinations); //Записываем счастливые числа в массив
  } elseif ($overlap == 12 || $overlap == 0) { // Если совпало 12 чисел или 0
    $won_9kk++; // Прибавляем единицу к количеству выигранных игр с прибылью 9кк рублей
    $won_games++; // Прибавляем единицу к общему количеству выигранных игр
    $won_money += $tiket_price*150000; // Прибавляем выигранную сумму у общему числу выигранных денег
    $super_numbers[] = $user_numbers;
    luckyNumbers($shooted, $conbinations); //Записываем счастливые числа в массив
  } else {
    $losses_games++; // Прибавляем единицу в случае проигрыша к общему количеству проигрышей
    $losses_money -= $tiket_price; // Вычитаем стоимость билета в общем убытке
  }
}

function generateNumbers(){ // Функция генерации случайных неповторяющихся 12 чисел из 24
  $random_numbers = array(); // Массив для случайных чисел
  while(true){ // Запускаем бесконечный цикл
    $rand = rand(1, 24); // Генерируем случайное число от 1 до 24
    if(!in_array($rand, $random_numbers)){ // Если число не повторяется
      $random_numbers[] = $rand; // То добавляем его в массив случайных чисел
    }
    if(sizeof($random_numbers) == 12){ // Если сгенерировалось 12 чисел
      return $random_numbers; // То возвращаем их
    }
  }
}

function luckyNumbers($shooted, &$conbinations){ // Функция для записи счастливых чисел
  foreach ($shooted as $value) { // Пробегаемся по выигрышным числам
    $conbinations[$value]++; // И прибавляем количество повторений в общем массив выигрышных чисел
  }
}

// Выводим полученную информацию
echo PHP_EOL.'Всего игр: '.number_format($plays).PHP_EOL;
echo 'Проигрышей: '.number_format($losses_games).PHP_EOL;
echo 'Выигрышей: '.number_format($won_games).PHP_EOL;

echo 'Выиграно 60 рублей раз: '.number_format($won_60).PHP_EOL;
echo 'Выиграно 240 рублей раз: '.number_format($won_240).PHP_EOL;
echo 'Выиграно 1200 рублей раз: '.number_format($won_1200).PHP_EOL;
echo 'Выиграно 15000 рублей раз: '.number_format($won_15k).PHP_EOL;
echo 'Выиграно 9 миллионов рублей раз: '.number_format($won_9kk).PHP_EOL;

echo 'Проиграно денег: '.number_format($losses_money).' р.'.PHP_EOL;
echo 'Выиграно денег: '.number_format($won_money).' р.'.PHP_EOL;
echo 'Профит: '.number_format($won_money+$losses_money).' р.'.PHP_EOL;

foreach($conbinations as $key => $value){
  $value = number_format($value);
  echo "Число $key выпало $value раз".PHP_EOL;
}
?>
