# https://halu33.net

HTML(PHP), CSS, JavaScript, MySQLを使用


`index.php`

プロフィール情報やSNSの他、ライトモード/ダークモードの切り替えボタン、SpotifyのNowPlaying機能、アクセスカウンターなどの機能を作成。

`style.css`

index.phpのスタイルを定義。

`ModeSwitch.js`

ライトモード/ダークモードの切り替え機能。ユーザーの設定に応じて表示する。ボタンはフォントアイコン。

`NowPlaying.js`

SpotifyAPIから現在再生中の曲のデータを取得。1分ごとに非同期で更新。取得したデータはJSON形式で解析。

`counter.php`

プロフィールにアクセスされたらアクセス数をDBに保存するファイル。まず今日の日付でDBを検索する、レコードが存在したら+1カウント、存在しなければ新たにレコードを作成し+1カウント。またこれまでのアクセス数を集計し`index.php`で表示。

`Spotify.php`

SpotifyAPIを利用し、現在再生中の曲の情報を取得しDBに保存する処理を行う。

詳しくは [このリポジトリ](https://github.com/halu33/SpotifyAPI_PHP)

`CleanUp.php`

4日以上前のDBのデータを削除する。

`composer.json composer.lock`

ggrks

`.gitignore`

ggrks

`README.md`

The file you are reading now