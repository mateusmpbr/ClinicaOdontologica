<?php
// Script to migrate superglobals to input()/has_input() helpers in system/ and public/
$dirs = [__DIR__ . '/../system', __DIR__ . '/../public'];
$patterns = [
    // isset($_POST['key']) -> has_input('key')
    '/isset\s*\(\s*\$_POST\s*\[\s*["\']([^"\']+)["\']\s*\]\s*\)/',
    // !isset(...) already handled by previous, but replace explicit patterns
    '/!\s*isset\s*\(\s*\$_POST\s*\[\s*["\']([^"\']+)["\']\s*\]\s*\)/',
];
$replacements = [
    "has_input('$1')",
    "!has_input('$1')",
];

$pat2 = '/\$_POST\s*\[\s*["\']([^"\']+)["\']\s*\]/';
$pat3 = '/\$_GET\s*\[\s*["\']([^"\']+)["\']\s*\]/';

$filesChanged = [];
foreach ($dirs as $dir) {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($it as $file) {
        if (!$file->isFile()) continue;
        if ($file->getExtension() !== 'php') continue;
        $path = $file->getPathname();
        $orig = file_get_contents($path);
        $new = $orig;
        // 1) isset -> has_input
        $new = preg_replace($patterns, $replacements, $new);
        // 2) replace remaining $_POST[...] -> input('...')
        $new = preg_replace($pat2, "input('$1')", $new);
        // 3) replace $_GET[...] -> input('...')
        $new = preg_replace($pat3, "input('$1')", $new);

        if ($new !== $orig) {
            // backup
            copy($path, $path . '.bak');
            file_put_contents($path, $new);
            $filesChanged[] = $path;
            echo "Updated: $path\n";
        }
    }
}

if (empty($filesChanged)) {
    echo "No files changed.\n";
} else {
    echo "Modified " . count($filesChanged) . " files. Backups saved with .bak extension.\n";
}

