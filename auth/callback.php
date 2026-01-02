<?php
require_once '../config/google.php';

if (!isset($_GET['code'])) {
    header('Location: login.php');
    exit;
}

try {
    // Exchange code for access token
    $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        throw new Exception($token['error_description']);
    }

    $googleClient->setAccessToken($token['access_token']);

    // Fetch user info
    $googleService = new Google_Service_Oauth2($googleClient);
    $userData = $googleService->userinfo->get();

    $google_id = $userData->id;
    $name      = $userData->name;
    $email     = $userData->email;
    $picture   = $userData->picture;

    // Check user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE google_id = ? OR email = ?");
    $stmt->bind_param("ss", $google_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Insert new user
        $stmt = $conn->prepare(
            "INSERT INTO users (google_id, name, email, picture) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $google_id, $name, $email, $picture);
        $stmt->execute();
        $user_id = $stmt->insert_id;
    } else {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    }

    // Session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['picture'] = $picture;

    header('Location: dashboard.php');
    exit;

} catch (Exception $e) {
    echo "Authentication failed: " . $e->getMessage();
}
