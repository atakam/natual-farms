<?php
include 'backupfunctions.php';
// Get real path for our folder
$rootPath = realpath('/home/natural/public_html/portal');

// Initialize archive object
$zip = new ZipArchive();
$file_path = 'files-'.time().'.zip';
$zip->open($file_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($rootPath),
		RecursiveIteratorIterator::LEAVES_ONLY
		);

foreach ($files as $name => $file)
{
	// Skip directories (they would be added automatically)
	if (!$file->isDir())
	{
		// Get real and relative path for current file
		$filePath = $file->getRealPath();
		$relativePath = substr($filePath, strlen($rootPath) + 1);

		// Add current file to archive
		$zip->addFile($filePath, $relativePath);
	}
}

// Zip archive will be created only after closing object
$zip->close();

uploadToDb($file_path, 'NaturalFarms/Files_Backups');
unlink($file_path);
?>