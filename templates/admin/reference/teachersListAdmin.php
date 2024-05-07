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
    <title id="pageTitle">Teachers</title>
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

            <li class="nav-item-vertical active">
                <b></b>
                <b></b>
                <a href="#">
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



    <section class="content">

        <!-- Modal -->
        <div class="modal fade" id="showMoreModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Additional Information:</h5>
                    </div>
                    <div class="modal-body" id="studentInfo">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- content of profile section  -->
        <div class="container">
            <div class="row">
                <div class="row title">
                    <div class="col-9 student-name-container">
                        <h2 class="student-name">Teachers </h2>
                    </div>
                </div>
                <div class="card-container">

                    <?php
                        $teachers = ConnexionBD::getTeachers();
                    ?>
                    <script>
                        const teachers = <?= json_encode($teachers) ?>;
                    </script>
                    <div class="card card-two">
                        <div class="row info tbl">
                            <!-- bootstrap table -->
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Phone</th>
                                    </tr>
                                </thead>
                                <tbody id="body">
                                <!-- The teachers list that will be loaded-->
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