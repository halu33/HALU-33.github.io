<?php
session_start();
include dirname(__FILE__) . '/config.php';
require 'vendor/autoload.php';
use League\OAuth2\Client\Provider\GenericProvider;


// OAuth設定
$provider = new GenericProvider([
    'clientId'                => $spotifyClientId,
    'clientSecret'            => $spotifyClientSecret,
    'redirectUri'             => $spotifyRedirectUri,
    'urlAuthorize'            => 'https://accounts.spotify.com/authorize',
    'urlAccessToken'          => 'https://accounts.spotify.com/api/token',
    'urlResourceOwnerDetails' => 'https://api.spotify.com/v1/me'
]);


// 認証URLにリダイレクト
if (!isset($_GET['code']) && !isset($_SESSION['access_token'])) {
    $authorizationUrl = $provider->getAuthorizationUrl();
    header('Location: ' . $authorizationUrl);
    exit();
}
// コールバックURLの処理
if (isset($_GET['code'])) {
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    $_SESSION['access_token'] = $accessToken->getToken();
}


// Spotify再生情報を取得する関数
function getCurrentPlaying() {
    global $provider;

    if (isset($_SESSION['access_token'])) {
        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://api.spotify.com/v1/me/player/currently-playing',
            $_SESSION['access_token']
        );

        $response = $provider->getParsedResponse($request);

        if ($response) {
            $data = [];
            $data['trackName'] = $response['item']['name'];
            $data['artistName'] = $response['item']['artists'][0]['name'];
            $data['albumCover'] = $response['item']['album']['images'][0]['url'];

            return $data;
        }
    }
    return false;
}

?>