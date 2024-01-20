<?php
require_once 'config.php';

function getDatabaseConnection() {
    return new PDO(DB_DSN, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}

try {
    $pdo = getDatabaseConnection();

    // 4日前の再生情報のデータを削除するSQL
    $stmt = $pdo->prepare("DELETE FROM NowPlaying WHERE last_played_at < NOW() - INTERVAL 4 DAY");
    $stmt->execute();

    echo "古い再生情報を削除しました。";
} catch (PDOException $e) {
    echo "データベースエラー: " . $e->getMessage();
    exit;
}
