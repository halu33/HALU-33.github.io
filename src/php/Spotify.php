<?php
require_once 'config.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

ini_set('display_errors', 0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function setupSpotifySession($session) {
    $accessToken = $_SESSION['accesstoken'] ?? null;
    $refreshToken = $_SESSION['refreshtoken'] ?? null;

    if ($accessToken) {
        $session->setAccessToken($accessToken);
    } elseif ($refreshToken) {
        $session->refreshAccessToken($refreshToken);
        $_SESSION['accesstoken'] = $session->getAccessToken();
        $session->setAccessToken($_SESSION['accesstoken']);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Re-authentication required.']);
        exit;
    }

    return $session;
}

function getCurrentTrack($session) {
    $api = new SpotifyWebAPI();
    setupSpotifySession($session);
    $api->setAccessToken($session->getAccessToken());
    return $api->getMyCurrentTrack();
}

function getDatabaseConnection() {
    return new PDO(DB_DSN, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}

function saveCurrentPlaying($currentTrack, $pdo) {
    if ($currentTrack && isset($currentTrack->item)) {
        $stmt = $pdo->prepare("
            INSERT INTO NowPlaying (track_name, artist_name, track_url, track_length, thumbnail_url)
            VALUES (:track_name, :artist_name, :track_url, :track_length, :thumbnail_url)
            ON DUPLICATE KEY UPDATE
                track_name = VALUES(track_name),
                artist_name = VALUES(artist_name),
                track_url = VALUES(track_url),
                track_length = VALUES(track_length),
                thumbnail_url = VALUES(thumbnail_url),
                last_played_at = NOW()
        ");
        $stmt->execute([
            ':track_name' => $currentTrack->item->name,
            ':artist_name' => implode(', ', array_map(function($artist) { return $artist->name; }, $currentTrack->item->artists)),
            ':track_url' => $currentTrack->item->external_urls->spotify,
            ':track_length' => gmdate('i:s', $currentTrack->item->duration_ms / 1000),
            ':thumbnail_url' => $currentTrack->item->album->images[0]->url
        ]);
    }
}

try {
    $session = new Session(
        SPOTIFY_CLIENT_ID,
        SPOTIFY_CLIENT_SECRET,
        CALLBACK_URL
    );

    $session = setupSpotifySession($session);
    $api = new SpotifyWebAPI();
    $api->setAccessToken($session->getAccessToken());
    $currentTrack = getCurrentTrack($session);
    $pdo = getDatabaseConnection();
    saveCurrentPlaying($currentTrack, $pdo);

    header('Content-Type: application/json');
    echo json_encode($currentTrack);
} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500); // サーバーエラーのステータスコードを設定
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
?>