<?php

// Перевірка, чи дані були надіслані через POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Отримання даних з форми
    $dateStart = $_POST['date-start'] ?? null;
    $dateEnd = $_POST['date-end'] ?? null;
    $approval = $_POST['approval'] ?? null;
    $reason = $_POST['reason'] ?? null;

    // Перевірка обов'язкових полів
    if ($dateStart && $dateEnd && $approval && $reason) {
        echo 'good';
    } else {
        echo 'Будь ласка, заповніть всі поля форми.';
    }
} else {
    echo 'Неправильний метод запиту.';
}
