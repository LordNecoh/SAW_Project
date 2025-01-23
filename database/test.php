<?php
header('Content-Type: application/json');

echo json_encode([
    'success' => true,
    'message' => 'Questo è un test di prova',
]);