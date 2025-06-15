<?php
const FILENAME = '/code/birthdays.txt';

function showMenu(): void {
    echo "\nМеню:\n";
    echo "1. Добавить запись\n";
    echo "2. Показать все записи\n";
    echo "3. Найти именинников сегодня\n";
    echo "4. Удалить запись\n";
    echo "5. Выход\n";
    echo "Выберите действие: ";
}

function main(): void {
    while (true) {
        showMenu();
        $choice = trim(readline());
        
        switch ($choice) {
            case '1':
                require 'fwrite-cli.php';
                break;
            case '2':
                showAllRecords(FILENAME);
                break;
            case '3':
                findTodayBirthdays(FILENAME);
                break;
            case '4':
                deleteRecord(FILENAME);
                break;
            case '5':
                exit("До свидания!\n");
            default:
                echo "Неверный выбор. Попробуйте снова.\n";
        }
    }
}

function showAllRecords(string $filename): void {
    if (!file_exists($filename)) {
        echo "Файл с данными не найден.\n";
        return;
    }

    $content = file_get_contents($filename);
    if ($content === false) {
        echo "Не удалось прочитать файл.\n";
        return;
    }

    if (empty(trim($content))) {
        echo "Файл пуст.\n";
        return;
    }

    echo "\nВсе записи:\n";
    echo $content;
}

main();
?>
