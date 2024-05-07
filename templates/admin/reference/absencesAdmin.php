<?php
session_start();
require_once('../../database/dbcreation.php');
require_once('../../form/verifyAdmin.php');
verifyAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Absences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../main.css" rel="stylesheet">
    <link href="../nav%20bar.css" rel="stylesheet">

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
            <li class="nav-item-vertical">
                <b></b>
                <b></b>
                <a href="overviewAdmin.php">
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

            <li class="nav-item-vertical active">
                <b></b>
                <b></b>
                <a href="#">
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



    <section class="content">
        <?php
        $absences = ConnexionBD::getAbsences();
        $uniqueCourses = array_values(array_unique(array_column($absences, 'coursename')));
        ?>
        <script>
            const absences = <?= json_encode($absences) ?>;
        </script>
        <!-- content of profile section  -->
        <div class="container">
            <div class="row">
                <div class="row title">
                    <div class="col-9 student-name-container">
                        <h2 class="student-name">Absences </h2>
                    </div>
                </div>
                <div class="card-container">
                    <div class="card filter">
                        <div class="row info filter">
                            <form action="absencesAdmin.php" method="post">
                                <div class="col">
                                    <p>Filter absences by:
                                        <span>
                                            <select name="filterAbsences" id="filterAbsences">
                                                <option value="default">--</option>
                                                <option value="course">Course</option>
                                                <option value="month">Month</option>
                                            </select>
                                        </span>
                                    </p>

                                    <!-- Select menu for Course -->
                                    <p id="courseSelect" hidden> Select a Course:
                                        <select name="course" id="course">
                                            <option value="default">--</option>
                                            <?php
                                            foreach ($uniqueCourses as $course) {
                                                echo "<option value='$course'>$course</option>";
                                            }
                                            ?>
                                        </select>
                                    </p>

                                    <!-- Select menu for Month -->
                                    <p id="monthSelect" hidden> Select a Field:
                                        <select name="month" id="month">
                                            <option value="default">--</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </p>
                                </div>

                                <div class="col-8">
                                    <button hidden class="btn btn-outline" id="cancel" >Cancel Filter</button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="card card-two">
                        <div class="row info tbl">
                            <!-- bootstrap table -->
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Course Name</th>
                                    <th scope="col">Absence Date</th>
                                </tr>
                                </thead>
                                <tbody id="body">
                                <!-- The absence list that will be loaded-->
                                </tbody>
                            </table>
                        </div>

                        <button class="btn btn-primary" id="loadMore">Load More</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of profile section -->
    </section>
</main>
<script src="../script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>



</html>