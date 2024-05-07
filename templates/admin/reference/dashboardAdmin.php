<?php
  session_start();
  require_once('../../database/dbcreation.php');
  require_once('../../form/verifyAdmin.php');
  verifyAdmin();
  $pdo = ConnexionBD::getInstance();
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../main.css" rel="stylesheet">
    <link href="../nav%20bar.css" rel="stylesheet">
    <link href="dashboardAdmin.css" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <div class="container-nav">
        <div class="logo-uni-nav">
            <a class="ucar" href="#"><img src="../src/logo-ucar.png"></a>
            <a class="insat" href="#"><img src="../src/logo-insat.png"></a>
            <h3 class="page-title">Admin's Space</h3>

        </div>

        <div class="profile-nav" >
            <p class="username-nav">Welcome, Admin</p>
            <img class="profile-pic-nav" src="../src/profile%20pic.png">
            <button class="btn btn-deconnect" type="submit" onclick="window.location.href = '../../form/form.php';">Log Out</button>
        </div>

    </div>
</nav>
<main>
    <!-- vertical nav bar -->
    <nav class="main-menu">
        <h1 class="current-nav-element">Menu</h1>
        <img class="logo" src="../src/logo.png" alt="logo" />
        <ul>
            <li class="nav-item-vertical active">
                <b></b>
                <b></b>
                <a href="#">
                    <img src="../src/profile%20pic.png" alt="home img " class="nav-vertical-icons">
                    <span class="nav-text">Overview</span>
                </a>
            </li>
            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="studentsListAdmin.php">
                    <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Students</span>
                </a>
            </li>

            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="teachersListAdmin.php">
                    <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Teachers</span>
                </a>
            </li>

            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="absencesAdmin.php">
                    <!-- <img src="src/abscent white.png" alt="abscence img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Absences</span>
                </a>
            </li>

            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="applicationsAdmin.php">
                    <!-- <img src="src/Profile.png" alt="Profile img " class="nav-vertical-icons"> -->
                    <span class="nav-text">Applications</span>
                </a>
            </li>
        </ul>
    </nav>

    <section class="container">
        <div class="row title">
            <div class="col-9 student-name-container">
                <h2 class="student-name">Overview</h2>
            </div>
        </div>
        <div class="card-container">
            <div class="card">
                <div class="row elements">
                    <div class="col-6 vertical">
                        <div class="row">
                            <h5>Number of Students Per Study Level</h5>
                        </div>
                        <div class="row">
                            <div class="studentsPerYearContainer">
                                <canvas id="studentsPerYearCanvas"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 vertical">
                        <div class="row">
                            <h5>Number of Students Per Field</h5>
                        </div>
                        <div class="row">
                            <div class="fieldContainer">
                                <canvas id="fieldCanvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="card">
                <div class="row elements">
                    <div class="col-6 vertical">
                        <div class="row">
                            <h5>Number of Recent Absences</h5>
                        </div>
                        <div class="row">
                            <div class="absenceContainer">
                                <canvas id="absenceCanvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-container">
            <div class="card">
                <div class="row elements">
                    <div class="col-6 vertical">
                        <div class="row">
                            <h5>Number of Students per Gender</h5>
                        </div>
                        <div class="row">
                            <div class="genderContainer">
                                <canvas id="genderCanvas"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 vertical">
                        <div class="row">
                            <h5>Number of Teachers per Course</h5>
                        </div>
                        <div class="row">
                            <div class="teachersPerCourseContainer">
                                <canvas id="teachersPerCourseCanvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php 
            [$studentStatistics, $absenceStatistics, $genderStatistics,
                $fieldStatistics, $teacherStatistics] = ConnexionBD::get_statistics();
        ?>
        <script>
            const studentStatistics = <?= json_encode($studentStatistics) ?> ; 
            const absenceStatistics = <?= json_encode($absenceStatistics) ?> ;
            const genderStatistics = <?= json_encode($genderStatistics) ?> ;
            const fieldStatistics = <?= json_encode($fieldStatistics) ?> ;
            const teacherStatistics = <?= json_encode($teacherStatistics) ?> ;
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="dashboardAdmin.js" type="module"></script>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>


</html>