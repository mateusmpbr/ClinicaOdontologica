<?php
// Replace input('key') with strict PSR-7 request() accesses in system/ and public/system/
$dirs = [__DIR__ . '/../system', __DIR__ . '/../public/system'];
$pattern = '/\binput\s*\(\s*["\']([^"\']+)["\']\s*\)/';
$filesChanged = [];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($it as $file) {
        if (!$file->isFile()) continue;
        if ($file->getExtension() !== 'php') continue;
        $path = $file->getPathname();
        $orig = file_get_contents($path);
        $new = preg_replace_callback($pattern, function ($m) {
            $key = $m[1];
            return '(request()->getParsedBody()[\'' . $key . '\'] ?? request()->getQueryParams()[\'' . $key . '\'] ?? null)';
        }, $orig);
        if ($new !== $orig) {
            copy($path, $path . '.bak');
            file_put_contents($path, $new);
            $filesChanged[] = $path;
            echo "Patched: $path\n";
        }
    }
}
if (empty($filesChanged)) {
    echo "No files changed.\n";
} else {
    echo "Modified " . count($filesChanged) . " files. Backups saved with .bak extension.\n";
}
