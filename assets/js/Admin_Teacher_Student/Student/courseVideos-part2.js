const videoHandler = () => {

    var player = videojs('my-video');
    player.on('loadedmetadata', function() {
        console.log("Metadata loaded");
        var totalDuration = player.duration();

        // Your other logic here that depends on the total duration
        // For example, setting the stored position
        var storedPosition = getVideoProgressCookie(studentID, currentID) * totalDuration / 100;
        console.log("Stored position: " + storedPosition);

        // Save the current position in localStorage when the video is paused
        player.on('pause', function() {
            localStorage.setItem('videoPosition', player.currentTime());
            console.log('Position saved: ' + player.currentTime());
            var progress = (player.currentTime() / totalDuration) * 100 ;
            setVideoProgressCookie(studentID, currentID, progress);
        });

        // Set the video position when it's loaded
        if (storedPosition) {
            player.currentTime(parseInt(storedPosition)); // Set the video to the stored position
        }
    });
}

const changeVideo = (videoUrl, videoTitle, videoDescription) => {
    var player = videojs('my-video');
    console.log('Changing video to: ' + videoUrl);
    player.src({ type: 'video/youtube', src: videoUrl });
    player.play();
    // Update title and description
    document.getElementById('video-title').innerText = videoTitle;
    document.getElementById('video-description').innerText = videoDescription;
};

document.addEventListener('DOMContentLoaded', videoHandler());