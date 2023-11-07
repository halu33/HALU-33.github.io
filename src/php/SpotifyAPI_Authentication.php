<?php
require_once 'config.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$session = new Session(
    SPOTIFY_CLIENT_ID,
    SPOTIFY_CLIENT_SECRET,
    CALLBACK_URL
);

$scopes = unserialize(SPOTIFY_SCOPES);
$options = [
    'scope' => $scopes,
];

if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    $_SESSION['accesstoken'] = $session->getAccessToken();
    $_SESSION['refreshtoken'] = $session->getRefreshToken();

    $api = new SpotifyWebAPI();
    $api->setAccessToken($_SESSION['accesstoken']);

    header('Location: ' . CALLBACK_URL);
    exit;
} else {
    $authorizeUrl = $session->getAuthorizeUrl($options);
    header('Location: ' . $authorizeUrl);
    exit;
}
?>