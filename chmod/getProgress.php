<?php
session_start();

// Check if the 'progress' key exists in the session
if (isset($_SESSION['progress'])) {
    echo $_SESSION['progress'];
} else {
    echo '0'; // Default value if 'progress' is not set
}
?>
