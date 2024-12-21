<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $_SESSION = array();
    session_destroy();
    exit();
} else {
    http_response_code(405); 
    exit();
}
?>