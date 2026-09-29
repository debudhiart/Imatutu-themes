<?php
/**
 * Build Script to generate standard WordPress Theme ZIP archive
 * Ensures standard POSIX forward slashes (/) so WordPress on Linux/Apache/Nginx
 * can locate style.css without "missing stylesheet" errors.
 */

$zipFilename = __DIR__ . '/imatutu-theme.zip';
if (file_exists($zipFilename)) {
    unlink($zipFilename);
}

$zip = new ZipArchive();
if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die("Error: Cannot create zip file\n");
}

$themeDirName = 'imatutu-theme';
$zip->addEmptyDir($themeDirName);

$sourceDir = rtrim(__DIR__, '/\\');
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

$excludeList = array(
    '.git',
    '.gitignore',
    'issue.md',
    'imatutu-theme.zip',
    'build-zip.php',
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

    $zipPath = $themeDirName . '/' . $cleanPath;

    if ($item->isDir()) {
        $zip->addEmptyDir($zipPath);
    } elseif ($item->isFile()) {
        $zip->addFile($realPath, $zipPath);
        $count++;
    }
}

$zip->close();
echo "SUCCESS: {$count} files added to {$zipFilename} with valid forward slashes.\n";
