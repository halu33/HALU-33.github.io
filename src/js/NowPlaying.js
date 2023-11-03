document.addEventListener('DOMContentLoaded', function() {
    const trackInfoContainer = document.getElementById('track-info');

    function fetchNowPlaying() {
        fetch('src/php/Spotify.php')
            .then(response => response.json())
            .then(data => {
                if (data && data.item) {
                    // データが存在する場合、表示を更新
                    const trackName = data.item.name;
                    const artistName = data.item.artists.map(artist => artist.name).join(', ');
                    const trackLength = data.item.duration_ms;
                    const thumbnailUrl = data.item.album.images[0].url;
                    const trackUrl = data.item.external_urls.spotify;

                    // 分と秒に変換
                    const minutes = Math.floor(trackLength / 60000);
                    const seconds = ((trackLength % 60000) / 1000).toFixed(0);

                    // DOMを更新
                    trackInfoContainer.innerHTML = `
                        <img src="${thumbnailUrl}" alt="Album Art" class="album-art">
                        <div class="track-name"><a href="${trackUrl}" target="_blank">${trackName}</a></div>
                        <div class="artist-name">${artistName}</div>
                        <div class="track-length">${minutes}:${seconds < 10 ? '0' : ''}${seconds}</div>
                    `;
                } else {
                    // データが存在しない場合の処理
                    trackInfoContainer.textContent = '現在再生中の曲はありません。';
                }
            })
            .catch(error => {
                console.error('Error fetching now playing data:', error);
                trackInfoContainer.textContent = '情報を取得できませんでした。';
            });
    }

    fetchNowPlaying();
    setInterval(fetchNowPlaying, 60000);
});