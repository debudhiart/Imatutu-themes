<?php
/**
 * Theme ZIP Packaging Script (Hybrid Edition)
 * Excludes git files, markdown documents, and development artifacts.
 */

$sourceDir   = rtrim(__DIR__, '/\\');

$excludeList = array(
    '.git',
    '.gitignore',
    '.github',
    'node_modules',
    'scratch',
    'build-zip.php',
    'imatutu-theme.zip',
    'imatutu.zip',
    'imatutu-flat.zip',
    'issue.md',
    'README.md',
    '.DS_Store',
    'Thumbs.db',
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
        die("ERROR: Cannot create {$zipFilename}\n");
    }

    if (!empty($prefix)) {
        $zip->addEmptyDir(rtrim($prefix, '/'));
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    $count = 0;
    foreach ($files as $file) {
        $realPath     = $file->getRealPath();
        $relativePath = substr($realPath, strlen($sourceDir) + 1);
        $normalized   = str_replace('\\', '/', $relativePath);

        if (substr($normalized, -4) === '.zip') {
            continue;
        }

        $skip = false;
        foreach ($excludeList as $exclude) {
            if ($normalized === $exclude || strpos($normalized, $exclude . '/') === 0) {
                $skip = true;
                break;
            }
        }

        if ($skip) {
            continue;
        }

        $zipPath = empty($prefix) ? $normalized : rtrim($prefix, '/') . '/' . $normalized;

        if ($file->isDir()) {
            $zip->addEmptyDir($zipPath);
        } else {
            $zip->addFile($realPath, $zipPath);
            $count++;
        }
    }

    $zip->close();
    $size = round(filesize($zipFilename) / 1024, 2);
    echo "SUCCESS: Created " . basename($zipFilename) . " with {$count} files ({$size} KB)\n";
}

// 1. Standard WordPress Theme Package (imatutu-theme/)
packageThemeZip(__DIR__ . '/imatutu-theme.zip', $sourceDir, $excludeList, 'imatutu-theme/');

// 2. Standard WordPress Theme Package (imatutu/)
packageThemeZip(__DIR__ . '/imatutu.zip', $sourceDir, $excludeList, 'imatutu/');

// 3. Flat root package
packageThemeZip(__DIR__ . '/imatutu-flat.zip', $sourceDir, $excludeList, '');
