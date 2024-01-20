<?php
require_once 'config.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

ini_set('display_errors', 0);
session_start();

// ログイン確認
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// データベース接続
function getDatabaseConnection() {
    return new PDO(DB_DSN, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}

// すべてのトークンを取得する関数
function getAllTokensFromDB($pdo) {
    $stmt = $pdo->query("SELECT access_token, refresh_token FROM spotify_tokens");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// トークンをリフレッシュする関数
function refreshToken($session, $pdo, $refreshToken) {
    $session->refreshAccessToken($refreshToken);
    $newAccessToken = $session->getAccessToken();
    $newRefreshToken = $session->getRefreshToken();

    $stmt = $pdo->prepare("UPDATE spotify_tokens SET access_token = :access_token, refresh_token = :refresh_token WHERE refresh_token = :old_refresh_token");
    $stmt->execute([
        ':access_token' => $newAccessToken,
        ':refresh_token' => $newRefreshToken ?: $refreshToken,
        ':old_refresh_token' => $refreshToken
    ]);
    return $newAccessToken;
}

$pdo = getDatabaseConnection();
$tokens = getAllTokensFromDB($pdo);

$session = new Session(
    SPOTIFY_CLIENT_ID,
    SPOTIFY_CLIENT_SECRET,
    CALLBACK_URL
);

$api = new SpotifyWebAPI();

// 全てのトークンを試す
foreach ($tokens as $token) {
    $session->setAccessToken($token['access_token']);
    $session->setRefreshToken($token['refresh_token']);

    try {
        $api->setAccessToken($token['access_token']);
        $api->me(); // トークンが有効かどうかを確認
        $accessToken = $token['access_token']; // 有効なトークンを保存
        break;
    } catch (Exception $e) {
        // 無効なトークンの場合、次のトークンを試す
        $accessToken = refreshToken($session, $pdo, $token['refresh_token']);
        $api->setAccessToken($accessToken);
    }
}

if ($accessToken) {
    $currentTrack = $api->getMyCurrentTrack();
    saveCurrentPlaying($currentTrack, $pdo);

    header('Content-Type: application/json');
    echo json_encode($currentTrack);
} else {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['error' => 'Authentication required.']);
}

// NowPlayingをDBに保存
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
            ':track_length' => $currentTrack->item->duration_ms,
            ':thumbnail_url' => $currentTrack->item->album->images[0]->url
        ]);
    }
}
