<?php
require_once 'config.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

// ログイン
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// トークンをDBに保存
function saveTokenToDB($pdo, $accessToken, $refreshToken) {
    $stmt = $pdo->prepare("REPLACE INTO spotify_tokens (user_id, access_token, refresh_token) VALUES ('HALU_33', :access_token, :refresh_token)");
    $stmt->execute([
        ':access_token' => $accessToken,
        ':refresh_token' => $refreshToken
    ]);
}

// 初期化
$session = new Session(
    SPOTIFY_CLIENT_ID,
    SPOTIFY_CLIENT_SECRET,
    CALLBACK_URL
);

// DB接続
$pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// 認証のスコープを設定
$scopes = unserialize(SPOTIFY_SCOPES);
$options = ['scope' => $scopes];

// Spotifyからの認証コードを確認
if (isset($_GET['code'])) {
    // アクセストークンをリクエスト
    $session->requestAccessToken($_GET['code']);
    $accessToken = $session->getAccessToken();
    $refreshToken = $session->getRefreshToken();

    saveTokenToDB($pdo, $accessToken, $refreshToken);

    // コールバックURLにリダイレクト
    header('Location: ' . CALLBACK_URL);
    exit;
} else {
    // 認証用URLを取得しリダイレクト
    $authorizeUrl = $session->getAuthorizeUrl($options);
    header('Location: ' . $authorizeUrl);
    exit;
}