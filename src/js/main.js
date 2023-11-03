const lightModeButton = document.querySelector("#lightModeButton");
const darkModeButton = document.querySelector("#darkModeButton");

// ダークモードが有効かどうかをチェックしてボタンを表示
function toggleButtons(darkModeOn) {
    if (darkModeOn) {
        lightModeButton.style.display = 'block';
        darkModeButton.style.display = 'none';
    } else {
        lightModeButton.style.display = 'none';
        darkModeButton.style.display = 'block';
    }
}

// ユーザーの端末のダークモード設定をチェック
const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
document.body.classList.toggle("dark-mode", prefersDark);
toggleButtons(prefersDark);

// ライトモードボタンのクリックイベント
lightModeButton.addEventListener("click", function() {
    document.body.classList.remove("dark-mode");
    toggleButtons(false);
});

// ダークモードボタンのクリックイベント
darkModeButton.addEventListener("click", function() {
    document.body.classList.add("dark-mode");
    toggleButtons(true);
});
