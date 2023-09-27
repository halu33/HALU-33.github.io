const darkModeToggle = document.querySelector("#darkModeToggle");

// ユーザーの端末のダークモード設定をチェック
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    // ユーザーの端末がダークモードに設定されている場合
    document.body.classList.add("dark-mode");
    darkModeToggle.checked = true;
}

darkModeToggle.addEventListener("change", function() {
    if (this.checked) {
        document.body.classList.add("dark-mode");
    } else {
        document.body.classList.remove("dark-mode");
    }
});
