<?php
require_once __DIR__ . '/includes/bootstrap.php';

//clears session data
$_SESSION = [];

//removes the session cookies
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

//destroys the session and returns to homepage
session_destroy();
header('Location: index.php');
exit();