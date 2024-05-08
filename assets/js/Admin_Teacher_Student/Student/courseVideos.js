const setVideoProgressCookie = (studentId, videoId, progress) => {
    const cookieName = 'studentProgress_' + studentId + '_' + videoId;
    document.cookie = cookieName + '=' + progress + '; expires=' + new Date(new Date().getTime() + (10*30 * 24 * 60 * 60 * 1000)).toUTCString() + '; path=/';
};

const getVideoProgressCookie = (studentId, videoId) => {
    const cookieName = 'studentProgress_' + studentId + '_' + videoId;
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(cookieName) === 0) {
            return cookie.substring(cookieName.length + 1, cookie.length);
        }
    }
    setVideoProgressCookie(studentId, videoId, 0)
    return 0;
};