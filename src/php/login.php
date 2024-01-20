<?php
require_once 'config.php';
session_start();

// エラーメッセージ用
$error = '';

if (isset($_POST['submit'])) {
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    if ($userid === ADMIN_USER && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['logged_in'] = true;
        header('Location: SpotifyAuth.php');
        exit;
    } else {
        $error = 'miss';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://halu33.net/">
    <meta property="og:locale" content="ja_JP">
    <link rel="stylesheet" href="../css/style.css"/>
    <script src="https://kit.fontawesome.com/820bccf440.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- モード切り替えボタン -->
    <div class="switch-button">
        <!-- ライトモード切り替えボタン -->
        <button id="lightModeButton" class="mode-button">
            <i class="fa-regular fa-sun"></i>
        </button>
        <!-- ダークモード切り替えボタン -->
        <button id="darkModeButton" class="mode-button">
            <i class="fa-solid fa-moon"></i>
        </button>
    </div>

    <!-- ログインフォーム -->
    <div class="loginform">
        <form action="login.php" method="post">
            ユーザー名: <input type="text" name="userid"><br>
            パスワード: <input type="password" name="password"><br>
            <input type="submit" name="submit" value="ログイン">
        </form>
    </div>

    <script src="../js/ModeSwitch.js"></script>
</body>
</html>
