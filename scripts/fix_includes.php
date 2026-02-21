<?php

$root = realpath(__DIR__ . "/../");
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
$changed = [];
foreach ($it as $file) {
    if (!$file->isFile()) {
        continue;
    }
    if (pathinfo($file->getFilename(), PATHINFO_EXTENSION) !== 'php') {
        continue;
    }
    $path = $file->getPathname();
    $contents = file_get_contents($path);
    $pattern = '/\b(include|require)(?:_once)?\s*\(?\s*["\'](\.\.\/\.\.\/\.\.\/php\/([^"\']+))["\']\s*\)?\s*;/i';
    if (preg_match_all($pattern, $contents, $matches, PREG_SET_ORDER)) {
        $orig = $contents;
        foreach ($matches as $m) {
            $full = $m[0];
            $fileName = $m[3]; // e.g., classPaciente.php
            $replacement = sprintf("%s %s __DIR__ . '/../../../app/Models/%s';", $m[1], isset($m[0]) ? (strpos($m[0], '_once') !== false ? '_once' : '') : '_once', $fileName);
            // Better to preserve include_once vs include
            $type = $m[1];
            // detect if _once used
            $isOnce = (stripos($full, '_once') !== false) ? '_once' : '';
            $replacement = sprintf("%s%s __DIR__ . '/../../../app/Models/%s';", $type, $isOnce, $fileName);
            // replace exact full occurrence with replacement
            $contents = str_replace($full, $replacement, $contents);
        }
        if ($contents !== $orig) {
            copy($path, $path . '.bak');
            file_put_contents($path, $contents);
            $changed[] = $path;
        }
    }
}
if ($changed) {
    echo "Updated: \n" . implode("\n", $changed) . "\n";
} else {
    echo "No files updated\n";
}
