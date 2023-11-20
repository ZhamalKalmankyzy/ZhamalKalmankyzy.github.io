<?php

function dealCard() {
    $cards = [11, 2, 3, 4, 5, 6, 7, 8, 9, 10, 10, 10, 10];
    return $cards[array_rand($cards)];
}

function calculateScore($cards) {
    if (array_sum($cards) == 21 && count($cards) == 2) {
        return 0; // Блэкджек
    }
    if (in_array(11, $cards) && array_sum($cards) > 21) {
        $index = array_search(11, $cards);
        $cards[$index] = 1;
    }
    return array_sum($cards);
}

function compare($userScore, $dealerScore) {
    if ($userScore > 21 && $dealerScore > 21) {
        return "Вы проиграли. Перебор!";
    }
    if ($userScore == $dealerScore) {
        return "Ничья!";
    } elseif ($dealerScore == 0) {
        return "Вы проиграли. Дилер блэкджек!";
    } elseif ($userScore == 0) {
        return "Поздравляем! Вы выиграли блэкджек!";
    } elseif ($userScore > 21) {
        return "Вы проиграли. Перебор!";
    } elseif ($dealerScore > 21) {
        return "Дилер проиграл. Перебор!";
    } elseif ($userScore > $dealerScore) {
        return "Поздравляем! Вы выиграли!";
    } else {
        return "Вы проиграли.";
    }
}

function playGame() {
    $userCards = [];
    $dealerCards = [];
    $gameOver = false;

    // Запрос начальной ставки
    $bet = (int)readline("Сделайте свою ставку: $");

    for ($i = 0; $i < 2; $i++) {
        $userCards[] = dealCard();
        $dealerCards[] = dealCard();
    }

    while (!$gameOver) {
        $userScore = calculateScore($userCards);
        $dealerScore = calculateScore($dealerCards);

        echo "Ваши карты: " . implode(', ', $userCards) . ", текущий счет: $userScore\n";
        echo "Карты дилера: " . $dealerCards[0] . "\n";

        if ($userScore == 0 || $dealerScore == 0 || $userScore > 21) {
            $gameOver = true;
        } else {
            $anotherCard = readline("Хотите еще карту? Введите 'y' or 'n': ");
            if ($anotherCard == 'y') {
                $userCards[] = dealCard();
            } else {
                $gameOver = true;
            }
        }
    }

    while ($dealerScore != 0 && $dealerScore < 17) {
        $dealerCards[] = dealCard();
        $dealerScore = calculateScore($dealerCards);
    }

    echo "Ваши карты: " . implode(', ', $userCards) . ", текущий счет: $userScore\n";
    echo "Карты дилера: " . implode(', ', $dealerCards) . ", счет дилера: $dealerScore\n";
    echo compare($userScore, $dealerScore) . "\n";

    // Обработка ставки
    if ($userScore == 0 && $dealerScore != 0) {
        echo "Поздравляем! Вы выиграли блэкджек! Ваш выигрыш: $" . (2 * $bet) . "\n";
    } elseif ($userScore > 21) {
        echo "Вы проиграли. Перебор! Вы теряете свою ставку: $" . $bet . "\n";
    } elseif ($dealerScore > 21) {
        echo "Дилер проиграл. Перебор! Вы выигрываете: $" . (2 * $bet) . "\n";
    } elseif ($userScore > $dealerScore) {
        echo "Поздравляем! Вы выиграли! Ваш выигрыш: $" . (2 * $bet) . "\n";
    } elseif ($userScore < $dealerScore) {
        echo "Вы проиграли. Ваш проигрыш: $" . $bet . "\n";
    } else {
        echo "Ничья! Ваша ставка возвращается.\n";
    }
}

while (true) {
    playGame();
}
?>
