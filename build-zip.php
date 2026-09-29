<?php
/**
 * Build Script to generate standard WordPress Theme ZIP archive(s)
 * 
 * Generates two packages:
 * 1. imatutu-theme.zip (Flat/Root structure - recommended for WP Admin Dashboard upload)
 *    Eliminates the "The theme is missing the style.css stylesheet" error caused by
 *    WP Upgrader failing single-subdirectory detection on certain hosting environments.
 * 2. imatutu-theme-folder.zip (Enclosed folder structure - for manual FTP/cPanel extraction)
 */

$sourceDir = rtrim(__DIR__, '/\\');
$excludeList = array(
    '.git',
    '.gitignore',
    'issue.md',
    'build-zip.php',
    'scratch',
);

function packageThemeZip($zipFilename, $sourceDir, $excludeList, $prefix = '') {
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

        // Check if file is a zip archive
        if (substr($cleanPath, -4) === '.zip') {
            continue;
        }

        // Check exclusion
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
    echo "SUCCESS: {$count} files added to " . basename($zipFilename) . "\n";
}

// 1. Standard WordPress Theme Package (Slug: imatutu-theme)
packageThemeZip(__DIR__ . '/imatutu-theme.zip', $sourceDir, $excludeList, 'imatutu-theme/');

// 2. Standard WordPress Theme Package (Slug: imatutu)
packageThemeZip(__DIR__ . '/imatutu.zip', $sourceDir, $excludeList, 'imatutu/');

// 3. Flat root package (Direct files at root)
packageThemeZip(__DIR__ . '/imatutu-flat.zip', $sourceDir, $excludeList, '');

