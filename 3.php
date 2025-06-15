function deleteRecord(string $filename): void {
    if (!file_exists($filename)) {
        echo "Файл с данными не найден.\n";
        return;
    }

    $search = trim(readline("Введите имя или дату для поиска записи: "));
    if (empty($search)) {
        echo "Поисковый запрос не может быть пустым.\n";
        return;
    }

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        echo "Не удалось прочитать файл.\n";
        return;
    }

    $newLines = [];
    $found = false;
    
    foreach ($lines as $line) {
        if (strpos($line, $search) !== false) {
            $found = true;
            continue;
        }
        $newLines[] = $line;
    }

    if (!$found) {
        echo "Запись не найдена.\n";
        return;
    }

    if (file_put_contents($filename, implode("\n", $newLines) . "\n") === false) {
        echo "Не удалось сохранить изменения.\n";
        return;
    }

    echo "Запись успешно удалена.\n";
}
