<?php
include "./src/php/counter.php";
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="HALU_33のプロフィール">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://halu33.net/MyProfile">
        <meta property="og:locale" content="ja_JP">
        <link rel="stylesheet" href="./src/css/style.css?v=1"/>
        <title>@HALU_33</title>
        <meta name="description" content="HALU_33 Profile">
        <link rel="icon" href="./img/epril_icon.png">
        <link rel="apple-touch-icon" sizes="180x180" href="./img/epril_icon.png">
        <script src="https://kit.fontawesome.com/820bccf440.js" crossorigin="anonymous"></script>
    </head>

    <body>
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

        <!-- ヘッダー -->
        <div class="header">
            <h1><strong><img src="./img/epril_icon.png" alt="icon" class="header-icon"><a href="https://halu33.net/MyProfile">@HALU_33</a></strong></h1>
        </div>

        <!-- SNS -->
        <div class="sns">
            <table class="sns-table">
                <tr>
                    <td><a href="https://twitter.com/MK8DX_mkmg" target="_blank"><i class="fab fa-twitter"></i></a></td>
                    <td><s>@HALU_33</s> → @MK8DX_mkmg <br> ※アカウントが凍結されたためIDが変わりました</td>
                </tr>
                <tr>
                    <td><a href="https://discord.gg/UQMnbP85PB" target="_blank"><i class="fab fa-discord"></i></a></td>
                    <td>username: <code>halu_33</code> <br> ※個人鯖では通話の他に（遊びで）botの開発等行ってます</td>
                </tr>
                <tr>
                    <td><a href="https://www.youtube.com/c/HALU_33" target="_blank"><i class="fab fa-youtube"></i></a></td>
                    <td>@HALU_33</td>
                </tr>
                <tr>
                    <td><a href="https://open.spotify.com/user/i1l47xrnbi52fzlnbi8bw95f6?si=f22210590b4e477e&nd=1" target="_blank"><i class="fab fa-spotify"></i></a></td>
                    <td>mna</a></td>
                </tr>
                <tr>
                    <td><a href="https://github.com/halu33" target="_blank"><i class="fab fa-github"></i></a></td>
                    <td>halu33</td>
                </tr>
            </table>
        </div>

        <!-- 詳細情報部分 -->
        <div class="info">
            <table class="info-table">
                <tr>
                    <th>名前</th>
                    <td>halu</td>
                </tr>
                <tr>
                    <th>生年月日</th>
                    <td>2005/03/03</td>
                </tr>
                <tr>
                    <th>所在地</th>
                    <td>日本 三重県</td>
                </tr>
                <tr>
                    <th>学校</th>
                    <td>どこかの高専 #kosen20s</td>
                </tr>
                <tr>
                    <th>MK8DX</th>
                    <td>所属:elf Code RL ill Iruca その他化石チーム<br>
                        150cc Lounge:<a href="https://www.mk8dx-lounge.com/PlayerDetails/10999" target="_blank">SenjuIroha</a>
                    </td>
                </tr>
                <tr>
                    <th>ユメステ</th>
                    <td>親指勢 多指置きプレイ🔰 23年7月～ レート950↑ 星章30%↑ <br> 推し: 新妻八恵、千寿いろは、白丸美兎、流石知冴</td>
                </tr>
                <tr>
                    <th>白猫プロジェクト(故)</th>
                    <td>Name: 33<i class="fa-brands fa-apple"></i> Rank: 650↑ 段位: 25↑ 21年4月頃～<br>
                        推しキャラ: ヴィレータ、エプリル
                    </td>
                </tr>
            </table>
        </div>

        <!-- NowPlaying -->
        <div id="now-playing-container">
            <div id="now-playing-header">
                <i class="fab fa-spotify"></i> Now Playing <i class="fa-solid fa-headphones"></i>
            </div>
            <div id="track-info">
                <!-- NowPlaying.jsによって出力 -->
            </div>
        </div>

        <!-- アクセスカウンター -->
        <div class="access-counter">
            <?php echo str_pad($total_visitor_count, 8, '0', STR_PAD_LEFT); ?>
        </div>

        <script src="./src/js/ModeSwitch.js"></script>
        <script src="./src/js/NowPlaying.js"></script>
    </body>
</html>
