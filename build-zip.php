<?php
/**
 * Build Script to generate production WordPress Theme ZIP archive
 */

$sourceDir = rtrim(__DIR__, '/\\');
$excludeList = array(
    '.git',
    '.gitignore',
    'issue.md',
    'build-zip.php',
    'scratch',
    'imatutu-theme.zip',
    'imatutu.zip',
    'imatutu-flat.zip',
    'assets/images/customizer-ui-mockup.jpg',
    'assets/images/website-redesign-preview.jpg',
    'assets/images/before-after-comparison.jpg',
);

function packageThemeZip($zipFilename, $sourceDir, $excludeList, $prefix = 'imatutu-theme/') {
    if (file_exists($zipFilename)) {
        unlink($zipFilename);
    }

    $zip = new ZipArchive();
    if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        die("Error: Cannot create zip file: {$zipFilename}\n");
    }

    if (!empty($prefix)) {
        $zip->addEmptyDir(rtrim($prefix, '/'));
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    $count = 0;
    foreach ($iterator as $item) {
        $realPath = $item->getPathname();
        $subPath = substr($realPath, strlen($sourceDir));
        $cleanPath = ltrim(str_replace('\\', '/', $subPath), '/');

        if (substr($cleanPath, -4) === '.zip') {
            continue;
        }

        $skip = false;
        foreach ($excludeList as $ex) {
            if ($cleanPath === $ex || strpos($cleanPath, $ex . '/') === 0) {
                $skip = true;
                break;
            }
        }
        if ($skip) {
            continue;
        }

        $zipPath = empty($prefix) ? $cleanPath : rtrim($prefix, '/') . '/' . $cleanPath;

        if ($item->isDir()) {
            $zip->addEmptyDir($zipPath);
        } elseif ($item->isFile()) {
            $zip->addFile($realPath, $zipPath);
            $count++;
        }
    }

    $zip->close();
    echo "SUCCESS: {$count} files added to " . basename($zipFilename) . " (" . round(filesize($zipFilename) / 1024, 2) . " KB)\n";
}

// 1. Standard WordPress Theme Package (Slug: imatutu-theme)
packageThemeZip(__DIR__ . '/imatutu-theme.zip', $sourceDir, $excludeList, 'imatutu-theme/');

// 2. Standard WordPress Theme Package (Slug: imatutu)
packageThemeZip(__DIR__ . '/imatutu.zip', $sourceDir, $excludeList, 'imatutu/');

// 3. Flat root package (Direct files at root)
packageThemeZip(__DIR__ . '/imatutu-flat.zip', $sourceDir, $excludeList, '');
