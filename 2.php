function findTodayBirthdays(string $filename): void {
    if (!file_exists($filename)) {
        echo "Файл с данными не найден.\n";
        return;
    }

    if (!is_readable($filename)) {
        echo "Нет прав на чтение файла.\n";
        return;
    }

    $today = date('d-m');
    $found = false;

    $file = fopen($filename, 'r');
    if (!$file) {
        echo "Не удалось открыть файл для чтения.\n";
        return;
    }

    echo "Сегодня день рождения у:\n";
    while (($line = fgets($file)) !== false) {
        $line = trim($line);
        if (empty($line)) continue;

        $parts = explode(', ', $line);
        if (count($parts) !== 2) continue;

        $dateParts = explode('-', $parts[1]);
        if (count($dateParts) !== 3) continue;

        $birthday = $dateParts[0] . '-' . $dateParts[1];
        if ($birthday === $today) {
            echo "- " . $parts[0] . " (" . $parts[1] . ")\n";
            $found = true;
        }
    }

    fclose($file);

    if (!$found) {
        echo "Никого не найдено.\n";
    }
}
