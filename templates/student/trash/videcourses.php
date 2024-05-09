<?php
  session_start();
  require_once('../../database/dbcreation.php');
  require_once('../../form/verifyAdmin.php');
  verifyStudent();
  $studentInfo=ConnexionBD::getUserInfo('student');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student's Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../main.css" rel="stylesheet">
    <link href="../nav%20bar.css" rel="stylesheet">
    <!-- video styling -->
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet" />
    <link href="../videoCourses.css" rel="stylesheet" />
    <script>
      function setVideoProgressCookie(studentId, videoId, progress) {
        const cookieName = 'studentProgress_' + studentId + '_' + videoId;
        document.cookie = cookieName + '=' + progress + '; expires=' + new Date(new Date().getTime() + (10*30 * 24 * 60 * 60 * 1000)).toUTCString() + '; path=/';
      }
      function getVideoProgressCookie(studentId, videoId) {
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
      }
    </script>
</head>
<body>
  <nav class="navbar">
    <div class="container-nav">
      <div class="logo-uni-nav">
        <a class="ucar" href="#"><img src="../src/logo-ucar.png"></a>
        <a class="insat" href="#"><img src="../src/logo-insat.png"></a>
        <h3 class="page-title">Student's Space</h3>
      </div>
      <button class="btn btn-deconnect mobile" type="submit">Se Déconnecter</button>
      <div class="profile-nav" >
        <p class="username-nav">Welcome, <?=$studentInfo['firstname']." ".$studentInfo['lastname'] ?></p>
        <img class="profile-pic-nav" src="../src/profile%20pic.png">
        <button class="btn btn-deconnect" type="submit" onclick="window.location.href = '../../form/form.php';">Se Déconnecter</button>
      </div>
    </div>
  </nav>
<main>
  <!-- vertical nav bar -->
  <nav class="main-menu">
        <h1 class="current-nav-element">Menu</h1>
        <ul>
          <li class="nav-item-vertical">
            <b></b>
            <b></b>
            <a href="dashboardEtudiant.php">
              <span class="nav-text">Profile</span>
            </a>
          </li>
          <li class="nav-item-vertical">
            <b></b>
            <b></b>
            <a href="scheduleStudent.php">
              <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
              <span class="nav-text">Schedule</span>
            </a>
          </li>

          <li class="nav-item-vertical">
            <b></b>
            <b></b>
            <a href="absencesEtudiant.php">
              <!-- <img src="src/abscent white.png" alt="abscence img " class="nav-vertical-icons"> -->
              <span class="nav-text">Absences</span>
            </a>
          </li>

          <li class="nav-item-vertical active">
            <b></b>
            <b></b>
            <a >
              <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
              <span class="nav-text">Courses</span>
            </a>
          </li>
        </ul>
      </nav>
  <section class="container" style="padding: 2rem">
    <?php
      $courseVideos = ConnexionBD::getVideosByLevel();
      if (empty($courseVideos)) {
          ?>
        <div class="row title">
            <div class="col-9 student-name-container">
                <h2 class="styled-text" style="margin-left: 3rem">There are no videos.</h2>
            </div>
        </div>
            <?php
      } else {
        $currentVideo = $courseVideos[0];
    ?>
    <script> 
      let currentID = "<?= $currentVideo->id ?>"; 
    </script>
    <!-- Video.js Player -->
    <div class="video-container">
      <div class="current-video">
        <video
        id="my-video"
        class="video-js vjs-theme-fantasy"
        controls
        preload="auto"
        width="560"
        height="315"
        data-setup='{"techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "<?= $currentVideo->url ?>"}]}'
              >
        <!-- Fallback content -->
        <p class="vjs-no-js">
          To view this video please enable JavaScript, and consider upgrading to a
          web browser that
          <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>.
        </p>
        </video>
      </div>
      <h2 id="video-title"><?= $currentVideo->title ?></h2>
      <p id="video-description"><?= $currentVideo->description ?></p>
      
    </div>
    <div>
      <h2>My Video Courses</h2>
      <ul class="list-group">
      <?php foreach($courseVideos as $course): ?>
        
        <li class="list-group-item listed-video" onclick="changeVideo('<?= $course->url ?>', '<?= $course->title ?>', '<?= $course->description ?>');currentID= <?= $course->id ?> ; ">
            <a href="#" data-video-id="<?= $course->id ?>" class="video-link"> <?= $course->title ?>
                <div class="progress" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                     <div class="progress-bar bg-success" id="<?= $course->id ?>" ></div> see original width
                </div>
            </a>
        </li>
        <script>
          let progress<?= $course->id ?> = getVideoProgressCookie(<?=$_SESSION['studentID']?>, <?=$course->id ?>);
          let progressBar<?= $course->id ?> = document.getElementById("<?= $course->id ?>");
          progressBar<?= $course->id ?>.style.width = progress<?= $course->id ?> + "%";
          progressBar<?= $course->id ?>.innerHTML = Math.round(progress<?= $course->id ?>) + "%";
        </script>
      <?php endforeach; ?>
      </ul>
    </div>
      <?php
      }
      ?>
  </section>
   <!-- Include Video.js JavaScript -->
  <script src="https://vjs.zencdn.net/7.15.4/video.min.js"></script>
  <!-- Include Video.js YouTube Plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-youtube/2.6.0/Youtube.min.js"></script>
  <script>



const videoHandler = function () { 
  
    var player = videojs('my-video');
    player.on('loadedmetadata', function() {
        console.log("Metadata loaded");
        var totalDuration = player.duration();
        
        // Your other logic here that depends on the total duration
        // For example, setting the stored position
        var storedPosition = getVideoProgressCookie(<?=$_SESSION['studentID']?>, currentID) * totalDuration / 100;
        console.log("Stored position: " + storedPosition);

        // Save the current position in localStorage when the video is paused
        player.on('pause', function() {
            localStorage.setItem('videoPosition', player.currentTime());
            console.log('Position saved: ' + player.currentTime());
            var progress = (player.currentTime() / totalDuration) * 100 ;
            setVideoProgressCookie(<?=$_SESSION['studentID']?>, currentID, progress);
        });

        // Set the video position when it's loaded
        if (storedPosition) {
            player.currentTime(parseInt(storedPosition)); // Set the video to the stored position
        }
    }); 
  }
  </script>
  <script src="courseVideos.js"></script>
  // <script src="courseVideos.js"></script>
</main>
</body>


</html>