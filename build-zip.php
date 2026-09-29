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
    'imatutu-theme.zip',
    'imatutu-theme-folder.zip',
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

// 1. Primary package: Flat root for WP Dashboard Upload
packageThemeZip(__DIR__ . '/imatutu-theme.zip', $sourceDir, $excludeList, '');

// 2. Secondary package: Enclosed folder for manual extraction
packageThemeZip(__DIR__ . '/imatutu-theme-folder.zip', $sourceDir, $excludeList, 'imatutu-theme/');
