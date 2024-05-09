
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
const setVideoProgressCookie = (studentId, videoId, progress) => {
    const cookieName = 'studentProgress_' + studentId + '_' + videoId;
    document.cookie = cookieName + '=' + progress + '; expires=' + new Date(new Date().getTime() + (10*30 * 24 * 60 * 60 * 1000)).toUTCString() + '; path=/';
};

const getVideoProgressCookie = (studentId, videoId) => {
    console.log('Getting cookie for student ' + studentId + ' and video ' + videoId);
    const cookieName = 'studentProgress_' + studentId + '_' + videoId;
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cookieName) === 0 && cookie.charAt(cookieName.length) === '='){
            console.log('Cookie found: ' + cookie);
            return parseInt(cookie.substring(cookieName.length + 1, cookie.length));
        }
    }
    setVideoProgressCookie(studentId, videoId, 0)
    return 0;
};


// document.addEventListener('DOMContentLoaded', videoHandler());
// function changeVideo(videoUrl, videoTitle, videoDescription) {
//     console.log('Changing video to: ' + videoUrl);
//     var player = videojs('my-video');
    
//     player.src({ type: 'video/youtube', src: videoUrl });
//     player.play();
//     // Update title and description
//     document.getElementById('video-title').innerText = videoTitle;
//     document.getElementById('video-description').innerText = videoDescription;
// }
