<?php

require_once 'connessioneDB.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["email"])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(["success" => false, "message" => "Both password fields are required."]);
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        echo json_encode(["success" => false, "message" => "Passwords do not match."]);
        exit();
    }

    if (strlen($newPassword) < 8) {
        echo json_encode([
            "success" => false, "message" => "Password must be at least 8 characters long."
        ]);
        exit();
    }
    
    if (!preg_match("/^[0-9A-Za-z!@&%$*#]+$/", $newPassword)) {
    $response['error'] = "Password must contain only letters, numbers, and the special characters !, @, &, %, $, *, #.";
    echo json_encode($response);
    exit();
}


    try {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $_SESSION["email"]]);

        echo json_encode(["success" => true, "message" => "Password updated successfully!"]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "An error occurred while updating the password. Please try again later."]);
    }
}
?>
