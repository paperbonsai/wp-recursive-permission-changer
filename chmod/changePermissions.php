<?php
session_start();

$dirPerms = isset($_POST['dirPerms']) ? octdec($_POST['dirPerms']) : 0755;
$filePerms = isset($_POST['filePerms']) ? octdec($_POST['filePerms']) : 0644;

function countItems($dir) {
    $count = 0;
    $handle = opendir($dir);
    
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $fullPath = $dir . '/' . $entry;
            $count++;
            if (is_dir($fullPath)) {
                $count += countItems($fullPath);
            }
        }
    }
    
    closedir($handle);
    return $count;
}

function changePermissions($dir) {
    global $dirPerms, $filePerms, $totalItems, $processedItems;
    $handle = opendir($dir);
    
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $fullPath = $dir . '/' . $entry;
            
            if (is_dir($fullPath)) {
                chmod($fullPath, $dirPerms);
                changePermissions($fullPath);
            } else {
                switch ($entry) {
                    case '.htaccess':
                        chmod($fullPath, 0444);
                        break;
                    case 'wp-config.php':
                        chmod($fullPath, 0444);
                        break;
                    default:
                        chmod($fullPath, $filePerms);
                        break;
                }
            }
            
            $processedItems++;
            $_SESSION['progress'] = ($processedItems / $totalItems) * 100;
            session_write_close();
            session_start();
        }
    }
    
    closedir($handle);
}

// Set the parent directory to one directory above the script's directory
$parentDir = realpath(dirname(__DIR__));
$totalItems = countItems($parentDir);
$processedItems = 0;
$startTime = microtime(true);

changePermissions($parentDir);

$endTime = microtime(true);
$timeTaken = $endTime - $startTime;

$_SESSION['summary'] = [
    'totalItems' => $totalItems,
    'timeTaken' => $timeTaken
];

//session_destroy();  // Destroy the session since the script is 100% done
?>
