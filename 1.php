<?php
$address = '/code/birthdays.txt';

function validateDate(string $date): bool {
    $dateBlocks = explode("-", $date);
    
    if (count($dateBlocks) !== 3) {
        return false;
    }

    $day = (int)$dateBlocks[0];
    $month = (int)$dateBlocks[1];
    $year = (int)$dateBlocks[2];

    if (!is_numeric($dateBlocks[0]) || !is_numeric($dateBlocks[1]) || !is_numeric($dateBlocks[2])) {
        return false;
    }

    if ($day < 1 || $day > 31) {
        return false;
    }

    if ($month < 1 || $month > 12) {
        return false;
    }

    if ($year < 1900 || $year > (int)date('Y')) {
        return false;
    }

    if (($month == 4 || $month == 6 || $month == 9 || $month == 11) && $day > 30) {
        return false;
    }

    if ($month == 2) {
        $isLeap = ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
        if ($day > ($isLeap ? 29 : 28)) {
            return false;
        }
    }

    return checkdate($month, $day, $year);
}

function validateName(string $name): bool {
    return preg_match('/^[а-яА-ЯёЁa-zA-Z\s\-]+$/u', $name) && strlen(trim($name)) > 0;
}

try {
    $name = trim(readline("Введите имя: "));
    if (!validateName($name)) {
        throw new Exception("Некорректное имя. Допустимы только буквы, пробелы и дефисы.");
    }

    $date = trim(readline("Введите дату рождения в формате ДД-ММ-ГГГГ: "));
    if (!validateDate($date)) {
        throw new Exception("Некорректная дата. Проверьте формат и допустимые значения.");
    }

    if (!file_exists($address) && !touch($address)) {
        throw new Exception("Не удалось создать файл для записи.");
    }

    if (!is_writable($address)) {
        throw new Exception("Нет прав на запись в файл.");
    }

    $data = "$name, $date\n";
    $fileHandler = fopen($address, 'a');
    
    if (!$fileHandler) {
        throw new Exception("Не удалось открыть файл для записи.");
    }

    if (fwrite($fileHandler, $data) === false) {
        throw new Exception("Ошибка при записи в файл.");
    }

    fclose($fileHandler);
    echo "Запись успешно добавлена: $data";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>
