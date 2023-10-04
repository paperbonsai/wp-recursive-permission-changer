<?php
session_start();

if (isset($_SESSION['summary'])) {
    echo json_encode($_SESSION['summary']);
} else {
    echo json_encode([]);
}
?>
