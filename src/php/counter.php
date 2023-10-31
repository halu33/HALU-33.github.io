<?php
include dirname(__FILE__) . '/config.php';
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// 今日の日付を取得 レコード検索
$today = date('Y-m-d');

$stmt = $pdo->prepare("SELECT * FROM visit_counts WHERE date = ?");
$stmt->execute([$today]);


// データの存在確認
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // データが存在したらcountを1増やす
    $stmt = $pdo->prepare("UPDATE visit_counts SET count = count + 1 WHERE date = ?");
    $stmt->execute([$today]);
} else {
    // データが存在しなければ新しいレコードを作成
    $stmt = $pdo->prepare("INSERT INTO visit_counts (count, date) VALUES (1, ?)");
    $stmt->execute([$today]);
}


// 訪問者数を取得
$stmt = $pdo->prepare("SELECT SUM(count) AS total_count FROM visit_counts");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total_visitor_count = $row['total_count'];


?>