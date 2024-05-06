

document.addEventListener('DOMContentLoaded', videoHandler());
function changeVideo(videoUrl, videoTitle, videoDescription) {
    var player = videojs('my-video');
    console.log('Changing video to: ' + videoUrl);
    player.src({ type: 'video/youtube', src: videoUrl });
    player.play();
    // Update title and description
    document.getElementById('video-title').innerText = videoTitle;
    document.getElementById('video-description').innerText = videoDescription;
}