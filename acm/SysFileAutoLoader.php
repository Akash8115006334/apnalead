<?php
//Display Errors
ini_set("display_errors", 1);

ini_set("log_errors", 1);
date_default_timezone_set("Asia/Calcutta");
ini_set('error_log', dirname(__FILE__) . '/../logs/err_log_for_' . date("d_M_Y") . '.txt');

//session_start()
session_start();
ob_start();

//App Configurations
//Change configuration according to your need and project requirements

//check SSL is installed or not
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
} else {
    $link = "http";
}

// Here append the common URL characters.
$link .= "://";

//dir & domain setup
define("HOST", $HOST = $_SERVER['SERVER_NAME']);

/**
 * @load system files
 * 
 */
//system url handler
require __DIR__ . "/../config.php";

//DB File Loader
require __DIR__ . "/SystemDBConnector.php";

//system Module Manager
require __DIR__ . "/SystemFileProcessor.php";

//system configuration Handler
require __DIR__ . "/SystemConfigurations.php";

//auto load all modules
require __DIR__ . "/SysModuleAutoLoader.php";



//  for dailyt code back-up in zip=====================================================================================================


// Specify the directory and file to check
$directory = __DIR__ . '/backups';
$filename = "CODE_BackUp_" . date('Ymd') . ".zip";

// Combine the directory and file to create the full path
$filepath = $directory . '/' . $filename;

// Check if the file exists
if (!file_exists($filepath)) {
    // Define the source directory
    $sourceDir = realpath(__DIR__ . '/backups');

    // Define the zip file path
    $zipFilePath = __DIR__ . "/backups/$filename";

    try {
        // Create a ZipArchive object
        $zip = new ZipArchive();

        // Open or create the zip file
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new Exception("Failed to open or create zip file: $zipFilePath");
        }

        // Create a recursive iterator to get all files and directories
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($files as $name => $file) {
            // Skip directories (they will be added automatically)
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($sourceDir) + 1);

                // Adjust the relative path to include subdirectories
                $relativePathInZip = str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);

                // Add the current file to the zip archive with the original relative path
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Close the zip archive
        $zip->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

    //if backup already exists
}
