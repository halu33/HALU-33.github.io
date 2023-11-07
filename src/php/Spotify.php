<?php
require_once 'config.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

ini_set('display_errors', 0);

session_start();

// データベース接続のための関数
function getDatabaseConnection() {
    return new PDO(DB_DSN, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}

// トークンをリフレッシュする関数
function refreshToken($session, $pdo) {
    $stmt = $pdo->query("SELECT refresh_token FROM spotify_tokens WHERE user_id = 'your_user_id'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && $row['refresh_token']) {
        $session->refreshAccessToken($row['refresh_token']);
        $newAccessToken = $session->getAccessToken();
        $newRefreshToken = $session->getRefreshToken();
        $stmt = $pdo->prepare("UPDATE spotify_tokens SET access_token = :access_token, refresh_token = :refresh_token WHERE user_id = 'your_user_id'");
        $stmt->execute([
            ':access_token' => $newAccessToken,
            ':refresh_token' => $newRefreshToken ?: $row['refresh_token']
        ]);
        return $newAccessToken;
    }
    return null;
}

// アクセストークンの有効期限を確認し、必要に応じて更新
function validateAccessToken($session, $pdo) {
    if (isset($_SESSION['accesstoken'])) {
        $api = new SpotifyWebAPI();
        $api->setAccessToken($_SESSION['accesstoken']);
        try {
            $api->me();
        } catch (Exception $e) {
            return refreshToken($session, $pdo);
        }
        return $_SESSION['accesstoken'];
    } else {
        return refreshToken($session, $pdo);
    }
}

$session = new Session(
    SPOTIFY_CLIENT_ID,
    SPOTIFY_CLIENT_SECRET,
    CALLBACK_URL
);

$pdo = getDatabaseConnection();

$accessToken = validateAccessToken($session, $pdo);

if ($accessToken) {
    $api = new SpotifyWebAPI();
    $api->setAccessToken($accessToken);
    $currentTrack = $api->getMyCurrentTrack();
    saveCurrentPlaying($currentTrack, $pdo);

    header('Content-Type: application/json');
    echo json_encode($currentTrack);
} else {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['error' => 'Authentication required.']);
}

// 現在再生中の曲情報をデータベースに保存する関数
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
?>